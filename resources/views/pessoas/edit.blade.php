@extends('layouts.app')

@section('page_title', 'Editar Pessoa')

@section('main_content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Pessoa</h3>
        <div class="card-tools">
            <a href="{{ route('pessoas.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <form action="{{ route('pessoas.update', $pessoa) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nome">Nome *</label>
                        <input type="text" class="form-control @error('nome') is-invalid @enderror" 
                               id="nome" name="nome" value="{{ old('nome', $pessoa->nome) }}" required>
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="documento">Documento *</label>
                        <input type="text" class="form-control @error('documento') is-invalid @enderror" 
                               id="documento" name="documento" value="{{ old('documento', $pessoa->documento) }}" required>
                        @error('documento')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">E-mail *</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $pessoa->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="celular_whatsapp">Celular/WhatsApp *</label>
                        <input type="text" class="form-control @error('celular_whatsapp') is-invalid @enderror" 
                               id="celular_whatsapp" name="celular_whatsapp" value="{{ old('celular_whatsapp', $pessoa->celular_whatsapp) }}" required>
                        @error('celular_whatsapp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Atualizar
            </button>
            <a href="{{ route('pessoas.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>
@endsection