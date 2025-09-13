@extends('layouts.app')

@section('page_title', 'Detalhes da Pessoa')

@section('main_content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informações da Pessoa</h3>
                <div class="card-tools">
                    <a href="{{ route('pessoas.edit', $pessoa) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <a href="{{ route('pessoas.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </div>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Nome:</dt>
                    <dd class="col-sm-9">{{ $pessoa->nome }}</dd>
                    
                    <dt class="col-sm-3">Documento:</dt>
                    <dd class="col-sm-9">{{ $pessoa->documento }}</dd>
                    
                    <dt class="col-sm-3">E-mail:</dt>
                    <dd class="col-sm-9">{{ $pessoa->email }}</dd>
                    
                    <dt class="col-sm-3">Celular/WhatsApp:</dt>
                    <dd class="col-sm-9">{{ $pessoa->celular_whatsapp }}</dd>
                    
                    <dt class="col-sm-3">Cadastrado em:</dt>
                    <dd class="col-sm-9">{{ $pessoa->created_at->format('d/m/Y H:i:s') }}</dd>
                    
                    <dt class="col-sm-3">Última atualização:</dt>
                    <dd class="col-sm-9">{{ $pessoa->updated_at->format('d/m/Y H:i:s') }}</dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Documentos</h3>
                <div class="card-tools">
                    <a href="{{ route('documentos.create', ['pessoa_id' => $pessoa->id]) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Novo Documento
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($pessoa->documentos->count() > 0)
                    <div class="list-group">
                        @foreach($pessoa->documentos as $documento)
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $documento->nome }}</h6>
                                    <small>
                                        <span class="badge badge-{{ $documento->tipo == 'pessoal' ? 'primary' : 'success' }}">
                                            {{ ucfirst($documento->tipo) }}
                                        </span>
                                    </small>
                                </div>
                                <p class="mb-1">{{ $documento->nome_original }}</p>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('documentos.show', $documento) }}" class="btn btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('documentos.download', $documento) }}" class="btn btn-success">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">Nenhum documento cadastrado para esta pessoa.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection