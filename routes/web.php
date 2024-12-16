<?php

use App\Http\Controllers\CollaboratorsController;
use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::get('/usuarios', [UserController::class, 'create'])->name('user.create');
Route::post('/usuarios', [UserController::class, 'register'])->name('user.store');
Route::get('/login', [UserController::class, 'login'])->name('user.login');
Route::post('/login', [UserController::class, 'validate'])->name('user.validate');

Route::middleware('auth')->group(function () {
   
    Route::get('/colaboradores', [CollaboratorsController::class, 'index'])->name('collaborators.index');
    Route::get('/colaborador', [CollaboratorsController::class, 'create'])->name('collaborators.create');
    Route::post('/colaborador', [CollaboratorsController::class, 'register'])->name('collaborators.register');
    Route::get('/colaborador/{id}/edit/', [CollaboratorsController::class, 'edit'])->name('collaborators.edit');
    Route::put('/colaborador/{id}', [CollaboratorsController::class, 'update'])->name('collaborators.update');
    Route::delete('/colaborador/{colaborator}', [CollaboratorsController::class, 'delete'])->name('collaborators.delete');
   
    Route::get('/tarefas', [TasksController::class, 'index'])->name('tasks.index');
    Route::get('/tarefa', [TasksController::class, 'create'])->name('tasks.create');
    Route::post('/tarefa', [TasksController::class, 'register'])->name('tasks.register');
    Route::get('/tarefa/{id}/edit', [TasksController::class, 'edit'])->name('tasks.edit');
    Route::put('/tarefa/{id}', [TasksController::class, 'update'])->name('tasks.update');
    Route::delete('/tarefa/{task}', [TasksController::class, 'delete'])->name('tasks.delete');

    Route::post('/logout', [UserController::class, 'destroy'])->name('user.logout');
});


Route::get('/', function () {
    return view('home');
})->name('home');


