@extends('layouts.app')

@section('page_title', 'Lista de Pessoas')

@section('main_content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Pessoas Cadastradas</h3>
        <div class="card-tools">
            <a href="{{ route('pessoas.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nova Pessoa
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
                        <th>Documento</th>
                        <th>E-mail</th>
                        <th>Celular/WhatsApp</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pessoas as $pessoa)
                        <tr>
                            <td>{{ $pessoa->id }}</td>
                            <td>{{ $pessoa->nome }}</td>
                            <td>{{ $pessoa->documento }}</td>
                            <td>{{ $pessoa->email }}</td>
                            <td>{{ $pessoa->celular_whatsapp }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('pessoas.show', $pessoa) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('pessoas.edit', $pessoa) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('pessoas.destroy', $pessoa) }}" method="POST" style="display: inline;">
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
                            <td colspan="6" class="text-center">Nenhuma pessoa cadastrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($pessoas->hasPages())
        <div class="card-footer">
            {{ $pessoas->links() }}
        </div>
    @endif
</div>
@endsection