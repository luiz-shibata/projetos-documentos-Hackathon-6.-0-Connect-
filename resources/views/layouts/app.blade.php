@extends('adminlte::page')

@section('title', 'Sistema de Documentos - Cresol')

@section('content_header')
    <h1>@yield('page_title', 'Sistema de Documentos')</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ session('error') }}
        </div>
    @endif

    @yield('main_content')
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        // Custom JavaScript without Vue/React
        $(document).ready(function() {
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);

            // Confirmation dialogs for delete actions
            $('.btn-delete').click(function(e) {
                e.preventDefault();
                if (confirm('Tem certeza que deseja excluir este item?')) {
                    $(this).closest('form').submit();
                }
            });
        });
    </script>
@stop

@section('adminlte_css')
    @parent
@stop

@section('adminlte_js')
    @parent
@stop