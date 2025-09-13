<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Pessoa;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documentos = Documento::with('pessoa')->paginate(10);
        return view('documentos.index', compact('documentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pessoas = Pessoa::all();
        return view('documentos.create', compact('pessoas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pessoa_id' => 'required|exists:pessoas,id',
            'nome' => 'required|string|max:255',
            'tipo' => 'required|in:pessoal,financeiro',
            'arquivo' => 'required|file|max:10240' // 10MB máximo
        ]);

        $arquivo = $request->file('arquivo');
        $conteudoBinario = (file_get_contents($arquivo->path()));

        Documento::create([
            'pessoa_id' => $request->pessoa_id,
            'nome' => $request->nome,
            'tipo' => $request->tipo,
            'tipo_arquivo' => $arquivo->getClientMimeType(),
            'nome_original' => $arquivo->getClientOriginalName(),
            'conteudo_binario' => $conteudoBinario
        ]);

        return redirect()->route('documentos.index')
            ->with('success', 'Documento salvo com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Documento $documento)
    {
        return view('documentos.show', compact('documento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Documento $documento)
    {
        $pessoas = Pessoa::all();
        return view('documentos.edit', compact('documento', 'pessoas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Documento $documento)
    {
        $request->validate([
            'pessoa_id' => 'required|exists:pessoas,id',
            'nome' => 'required|string|max:255',
            'tipo' => 'required|in:pessoal,financeiro',
            'arquivo' => 'nullable|file|max:10240'
        ]);

        $dados = [
            'pessoa_id' => $request->pessoa_id,
            'nome' => $request->nome,
            'tipo' => $request->tipo,
        ];

        if ($request->hasFile('arquivo')) {
            $arquivo = $request->file('arquivo');
            $dados['tipo_arquivo'] = $arquivo->getClientMimeType();
            $dados['nome_original'] = $arquivo->getClientOriginalName();
            $dados['conteudo_binario'] = base64_encode(file_get_contents($arquivo->path()));
        }

        $documento->update($dados);

        return redirect()->route('documentos.index')
            ->with('success', 'Documento atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Documento $documento)
    {
        $documento->delete();

        return redirect()->route('documentos.index')
            ->with('success', 'Documento removido com sucesso!');
    }

    /**
     * Download the document file.
     */
    public function download(Documento $documento)
    {
        $conteudo = ($documento->conteudo_binario);
        
        return response($conteudo, 200)
            ->header('Content-Type', $documento->tipo_arquivo)
            ->header('Content-Disposition', 'attachment; filename="' . $documento->nome_original . '"');
    }
}
