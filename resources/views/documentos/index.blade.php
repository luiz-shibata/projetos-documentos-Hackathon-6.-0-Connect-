@extends('layouts.app')

@section('page_title', 'Lista de Documentos')

@section('main_content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Documentos Cadastrados</h3>
        <div class="card-tools">
            <a href="{{ route('documentos.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Novo Documento
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Pessoa</th>
                        <th>Tipo</th>
                        <th>Arquivo</th>
                        <th>Data Cadastro</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documentos as $documento)
                        <tr>
                            <td>{{ $documento->id }}</td>
                            <td>{{ $documento->nome }}</td>
                            <td>{{ $documento->pessoa->nome }}</td>
                            <td>
                                <span class="badge badge-{{ $documento->tipo == 'pessoal' ? 'primary' : 'success' }}">
                                    {{ ucfirst($documento->tipo) }}
                                </span>
                            </td>
                            <td>{{ $documento->nome_original }}</td>
                            <td>{{ $documento->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('documentos.show', $documento) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('documentos.download', $documento) }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <a href="{{ route('documentos.edit', $documento) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('documentos.destroy', $documento) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Nenhum documento cadastrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($documentos->hasPages())
        <div class="card-footer">
            {{ $documentos->links() }}
        </div>
    @endif
</div>
@endsection