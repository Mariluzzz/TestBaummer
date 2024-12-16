@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="center-align">Lista de Colaboradores</h2>

    @if ($collaborators->isEmpty())
        <div class="center-align">
            <p>Não há colaboradores cadastrados.</p>
        </div>
    @else
        <table class="striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Cpf</th>
                    <th>Data de Cadastro</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($collaborators as $collaborator)
                    <tr>
                        <td>{{ $collaborator->name }}</td>
                        <td>{{ $collaborator->email }}</td>
                        <td>{{ $collaborator->cpf }}</td>
                        <td>{{ \Carbon\Carbon::parse($collaborator->created_at)->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('collaborators.edit', $collaborator->id) }}" class="btn waves-effect waves-light yellow darken-2">Editar</a>

                            <form action="{{ route('collaborators.delete', $collaborator->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn waves-effect waves-light red">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="center-align">
            {{ $collaborators->links('pagination') }}
        </div>
    @endif

    <div class="center-align">
        <button class="btn"><a class="white-text" href="{{ route('collaborators.create') }}">Cadastrar colaborador</a></button>
        <button class="btn"><a class="white-text" href="{{ route('home') }}">Voltar para o início</a></button>
    </div>
</div>
@endsection
