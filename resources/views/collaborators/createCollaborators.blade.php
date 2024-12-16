@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="center-align">Cadastro de Colaboradores</h2>

    <form method="POST" action="{{ route('collaborators.register') }}">
        @csrf
        <div class="input-field">
            <input type="text" name="name" id="name">
            <label for="name">Nome</label>
            @error('name')
                <span class="helper-text red-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="input-field">
            <input type="text" name="cpf" id="cpf">
            <label for="cpf">CPF</label>
            @error('cpf')
                <span class="helper-text red-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="input-field">
            <input type="email" name="email" id="email">
            <label for="email">E-mail</label>
            @error('email')
                <span class="helper-text red-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="center-align">
            <button type="submit" class="waves-effect waves-light btn">Cadastrar</button>
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
