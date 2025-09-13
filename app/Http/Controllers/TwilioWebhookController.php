<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;
use App\Models\Documento;
use Illuminate\Support\Str;
use Twilio\Rest\Client;

class TwilioWebhookController extends Controller
{
    public function handle(Request $request)
    {
        ini_set('memory_limit', '2048M');

        
        // Suporte para JSON array (exemplo do Postman)
        $input = $request->all();
        if (isset($input[0]['data'])) {
            $data = $input[0]['data'];
        } elseif (isset($input['data'])) {
            $data = $input['data'];
        } else {
            $data = [];
        }
        $from = $request->input('From') ?? $request->input('from') ?? ($data['from'] ?? null);
        $messageSid = $request->input('MessageSid') ?? $request->input('messageSid') ?? ($data['messageSid'] ?? null);
        $numMedia = $request->input('NumMedia') ?? $request->input('numMedia') ?? ($data['numMedia'] ?? 0);

        if (!$from) {
            return response()->json(['error' => 'Campo From não encontrado'], 400);
        }

        $pessoa = Pessoa::where('celular_whatsapp', str_replace('whatsapp:', '', $from))->first();
        //dd( str_replace('whatsapp:', '', $from));
        if (!$pessoa) {
            return response()->json(['error' => 'Pessoa não encontrada para o número informado'], 404);
        }

        $documentos = [];
        if ($messageSid) {
            $twilio = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
            $accountSid = env('TWILIO_ACCOUNT_SID');
            $message = $twilio->messages($messageSid)->fetch();
            $mediaList = $message->media->read();
            foreach ($mediaList as $media) {
                // Para baixar o conteúdo binário, removemos .json da URI e não especificamos Accept como JSON
                $mediaUrl = 'https://api.twilio.com' . str_replace('.json', '', $media->uri);
                $mediaType = $media->contentType;
                $fileContents = $this->downloadMediaBinary($mediaUrl, $mediaType);
                
                if ($fileContents) {
                    $filename = 'twilio_' . Str::random(16) . '.' . $this->getExtensionFromMime($mediaType);
                    $documento = new Documento();
                    $documento->pessoa_id = $pessoa->id;
                    $documento->nome = $filename;
                    $documento->tipo = 'financeiro'; // ou 'financeiro' conforme sua regra
                    $documento->tipo_arquivo = $mediaType;
                    $documento->nome_original = $filename;
                    $documento->conteudo_binario = $fileContents;
                    $documento->save();
                    //$documentos[] = $documento;
                }
            }
        } else {
            // fallback para o payload do webhook
            $numMedia = (int) $request->input('NumMedia', 0);
            for ($i = 0; $i < $numMedia; $i++) {
                $mediaUrl = $request->input("MediaUrl{$i}");
                $mediaType = $request->input("MediaContentType{$i}");
                if ($mediaUrl) {
                    $fileContents = $this->downloadMedia($mediaUrl);
                    if ($fileContents) {
                        $filename = 'twilio_' . Str::random(16) . '.' . $this->getExtensionFromMime($mediaType);
                        $documento = new Documento();
                        $documento->pessoa_id = $pessoa->id;
                        $documento->nome = $filename;
                        $documento->tipo = 'pessoal'; // ou 'financeiro' conforme sua regra
                        $documento->tipo_arquivo = $mediaType;
                        $documento->nome_original = $filename;
                        $documento->conteudo_binario = $fileContents;
                        $documento->save();
                        $documentos[] = $documento;
                    }
                }
            }
        }

        return response()->json([
            'success' => true,
            'documentos' => $documentos
        ]);
    }

    private function downloadMedia($url)
    {
        $sid = env('TWILIO_ACCOUNT_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, "$sid:$token");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: */*'
        ]);
        
        $data = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_error($ch)) {
            curl_close($ch);
            return false;
        }
        
        curl_close($ch);
        
        if ($httpCode !== 200) {
            return false;
        }
        
        return $data;
    }

    private function downloadMediaBinary($url, $contentType)
    {
        $sid = env('TWILIO_ACCOUNT_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        
        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, "$sid:$token");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: ' . $contentType, // Especifica o tipo de conteúdo esperado
            'Content-Type: ' . $contentType
        ]);
        
        $data = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $responseContentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        
        if (curl_error($ch)) {
            curl_close($ch);
            return false;
        }
        
        curl_close($ch);
        
        if ($httpCode !== 200) {
            return false;
        }
        
        // Verifica se realmente recebemos dados binários e não JSON
        if (strpos($responseContentType, 'application/json') !== false) {
            return false; // Ainda está retornando JSON, não o arquivo binário
        }
        
        return $data;
    }

    private function getExtensionFromMime($mime)
    {
        $map = [
            // Imagens
            'image/jpeg' => 'jpg',
            'image/jpg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
            'image/bmp' => 'bmp',
            
            // Documentos
            'application/pdf' => 'pdf',
            'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            'application/vnd.ms-excel' => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
            'application/vnd.ms-powerpoint' => 'ppt',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
            'text/plain' => 'txt',
            'text/csv' => 'csv',
            
            // Áudio
            'audio/mpeg' => 'mp3',
            'audio/mp4' => 'm4a',
            'audio/ogg' => 'ogg',
            'audio/wav' => 'wav',
            'audio/aac' => 'aac',
            
            // Vídeo
            'video/mp4' => 'mp4',
            'video/mpeg' => 'mpeg',
            'video/quicktime' => 'mov',
            'video/webm' => 'webm',
            'video/avi' => 'avi',
            
            // Outros
            'application/zip' => 'zip',
            'application/x-rar-compressed' => 'rar',
            'application/json' => 'json',
            'application/xml' => 'xml',
        ];
        
        return $map[$mime] ?? 'bin';
    }
}
