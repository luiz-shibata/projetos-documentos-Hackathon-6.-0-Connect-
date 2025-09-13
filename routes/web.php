<?php

use App\Http\Controllers\PessoaController;
use App\Http\Controllers\DocumentoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('pessoas.index');
});

Route::resource('pessoas', PessoaController::class);
Route::resource('documentos', DocumentoController::class);
Route::get('documentos/{documento}/download', [DocumentoController::class, 'download'])
    ->name('documentos.download');
