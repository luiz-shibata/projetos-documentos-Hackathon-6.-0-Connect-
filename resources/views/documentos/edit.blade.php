@extends('layouts.app')

@section('page_title', 'Editar Documento')

@section('main_content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Documento</h3>
        <div class="card-tools">
            <a href="{{ route('documentos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <form action="{{ route('documentos.update', $documento) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="pessoa_id">Pessoa *</label>
                        <select class="form-control @error('pessoa_id') is-invalid @enderror" 
                                id="pessoa_id" name="pessoa_id" required>
                            <option value="">Selecione uma pessoa</option>
                            @foreach($pessoas as $pessoa)
                                <option value="{{ $pessoa->id }}" {{ old('pessoa_id', $documento->pessoa_id) == $pessoa->id ? 'selected' : '' }}>
                                    {{ $pessoa->nome }} - {{ $pessoa->documento }}
                                </option>
                            @endforeach
                        </select>
                        @error('pessoa_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nome">Nome do Documento *</label>
                        <input type="text" class="form-control @error('nome') is-invalid @enderror" 
                               id="nome" name="nome" value="{{ old('nome', $documento->nome) }}" required>
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tipo">Tipo *</label>
                        <select class="form-control @error('tipo') is-invalid @enderror" 
                                id="tipo" name="tipo" required>
                            <option value="">Selecione o tipo</option>
                            <option value="pessoal" {{ old('tipo', $documento->tipo) == 'pessoal' ? 'selected' : '' }}>Pessoal</option>
                            <option value="financeiro" {{ old('tipo', $documento->tipo) == 'financeiro' ? 'selected' : '' }}>Financeiro</option>
                        </select>
                        @error('tipo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="arquivo">Arquivo</label>
                        <input type="file" class="form-control-file @error('arquivo') is-invalid @enderror" 
                               id="arquivo" name="arquivo">
                        @error('arquivo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Arquivo atual: {{ $documento->nome_original }}<br>
                            Deixe em branco para manter o arquivo atual. Tamanho máximo: 10MB
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Atualizar
            </button>
            <a href="{{ route('documentos.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>
@endsection