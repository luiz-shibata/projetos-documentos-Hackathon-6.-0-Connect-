@extends('layouts.app')

@section('page_title', 'Detalhes do Documento')

@section('main_content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Informações do Documento</h3>
        <div class="card-tools">
            <a href="{{ route('documentos.download', $documento) }}" class="btn btn-success">
                <i class="fas fa-download"></i> Download
            </a>
            <a href="{{ route('documentos.edit', $documento) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('documentos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <dl class="row">
                    <dt class="col-sm-3">Nome:</dt>
                    <dd class="col-sm-9">{{ $documento->nome }}</dd>
                    
                    <dt class="col-sm-3">Pessoa:</dt>
                    <dd class="col-sm-9">
                        <a href="{{ route('pessoas.show', $documento->pessoa) }}">
                            {{ $documento->pessoa->nome }}
                        </a>
                    </dd>
                    
                    <dt class="col-sm-3">Tipo:</dt>
                    <dd class="col-sm-9">
                        <span class="badge badge-{{ $documento->tipo == 'pessoal' ? 'primary' : 'success' }}">
                            {{ ucfirst($documento->tipo) }}
                        </span>
                    </dd>
                    
                    <dt class="col-sm-3">Arquivo original:</dt>
                    <dd class="col-sm-9">{{ $documento->nome_original }}</dd>
                    
                    <dt class="col-sm-3">Tipo de arquivo:</dt>
                    <dd class="col-sm-9">{{ $documento->tipo_arquivo }}</dd>
                    
                    <dt class="col-sm-3">Cadastrado em:</dt>
                    <dd class="col-sm-9">{{ $documento->created_at->format('d/m/Y H:i:s') }}</dd>
                    
                    <dt class="col-sm-3">Última atualização:</dt>
                    <dd class="col-sm-9">{{ $documento->updated_at->format('d/m/Y H:i:s') }}</dd>
                </dl>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Informações da Pessoa</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Nome:</strong> {{ $documento->pessoa->nome }}</p>
                        <p><strong>Documento:</strong> {{ $documento->pessoa->documento }}</p>
                        <p><strong>E-mail:</strong> {{ $documento->pessoa->email }}</p>
                        <p><strong>Celular:</strong> {{ $documento->pessoa->celular_whatsapp }}</p>
                        <a href="{{ route('pessoas.show', $documento->pessoa) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> Ver Pessoa
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection