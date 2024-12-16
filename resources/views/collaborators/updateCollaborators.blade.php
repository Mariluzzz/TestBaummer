@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="center-align">{{ isset($collaborator) ? 'Editar' : 'Cadastrar' }} Colaborador</h2>

    <form method="POST" action="{{ isset($collaborator) ? route('collaborators.update', $collaborator->id) : route('collaborators.register') }}">
        @csrf
        @isset($collaborator)
            @method('PUT')
        @endisset

        <div class="input-field">
            <input type="text" name="name" id="name" value="{{ old('name', $collaborator->name ?? '') }}">
            <label for="name">Nome</label>
            @error('name')
                <span class="helper-text red-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="input-field">
            <input type="text" name="cpf" id="cpf" value="{{ old('cpf', $collaborator->cpf ?? '') }}">
            <label for="cpf">CPF</label>
            @error('cpf')
                <span class="helper-text red-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="input-field">
            <input type="email" name="email" id="email" value="{{ old('email', $collaborator->email ?? '') }}">
            <label for="email">E-mail</label>
            @error('email')
                <span class="helper-text red-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="center-align">
            <button type="submit" class="waves-effect waves-light btn">{{ isset($collaborator) ? 'Atualizar' : 'Cadastrar' }}</button>
        </div>
    </form>

    @if(session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                M.toast({html: "{{ session('success') }}", classes: 'rounded green'});
            });
        </script>
    @endif

    <div class="center-align" style="margin-top: 1em;">
        <button class="btn"><a class="white-text" href="{{ route('collaborators.index') }}">Voltar a lista de colaboradores</button>
    </div>
</div>
@endsection
