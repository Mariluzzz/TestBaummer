@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="center-align">Lista de Tarefas</h2>

    <form action="{{ route('tasks.index') }}" method="GET" class="row">
        <div class="input-field col s2">
            <select name="priority">
                <option value="" selected>Todos</option>
                <option value="Alta" {{ request('priority') == 'Alta' ? 'selected' : '' }}>Alta</option>
                <option value="Média" {{ request('priority') == 'Média' ? 'selected' : '' }}>Média</option>
                <option value="Baixa" {{ request('priority') == 'Baixa' ? 'selected' : '' }}>Baixa</option>
            </select>
            <label>Prioridade</label>
        </div>

        <div class="input-field col s2">
            <input type="text" id="collaborator_name" name="collaborator_name" value="{{ request('collaborator_name') }}">
            <label for="collaborator_name">Colaborador</label>
            <input type="hidden" id="collaborator_id" name="collaborator_id" value="{{ request('collaborator_id') }}">
        </div>

        <div class="input-field col s2">
            <input type="date" name="executed_date" value="{{ request('executed_date') }}">
            <label>Data de execução</label>
        </div>

        <div class="input-field col s2">
            <input type="date" name="end_date" value="{{ request('end_date') }}">
            <label>Data de Prazo</label>
        </div>

        <div class="col s2 center-align">
            <button type="submit" class="btn waves-effect waves-light">Filtrar</button>
        </div>
    </form>

    @if ($tasks->isEmpty())
        <div class="center-align">
            <p>Não há tarefas cadastradas.</p>
        </div>
    @else
        <table class="striped">
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Responsável</th>
                    <th>Prioridade</th>
                    <th>Data final/prazo</th>
                    <th>Data de Execução</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->collaborator->name ?? 'Não atribuído' }}</td>
                        <td>{{ ucfirst($task->priority) }}</td>
                        <td>{{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y H:i') ?? 'Não definida' }}</td>
                        <td>{{ !empty($task->executed_at) ? \Carbon\Carbon::parse($task->executed_at)->format('d/m/Y H:i') : 'Não definida' }}</td>
                        <td>
                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn waves-effect waves-light yellow darken-2">Editar</a>

                            <form action="{{ route('tasks.delete', $task->id) }}" method="POST" style="display:inline;">
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
            {{ $tasks->links('pagination') }}
        </div>
    @endif

    <div class="center-align">
        <button class="btn"><a class="white-text" href="{{ route('tasks.create') }}">Atribuir nova tarefa</a></button>
        <button class="btn"><a class="white-text" href="{{ route('home') }}">Voltar para o início</a></button>
    </div>
</div>

<script>
   document.addEventListener('DOMContentLoaded', function() {
        var collaborators = @json($collaborators->pluck('name')->toArray());
        var collaborators_id = @json($collaborators->pluck('id')->toArray());

        var collaboratorsMap = collaborators.reduce(function(acc, name, index) {
            acc[name] = collaborators_id[index];
            return acc;
        }, {});

        var elems = document.querySelectorAll('#collaborator_name');
        var instances = M.Autocomplete.init(elems, {
            data: collaborators.reduce((acc, name) => {
                acc[name] = null;
                return acc;
            }, {}),
            limit: 10,
            onAutocomplete: function(val) {
                var collaboratorId = collaboratorsMap[val];
                document.getElementById('collaborator_id').value = collaboratorId;
            }
        });

        var collaboratorNameField = document.getElementById('collaborator_name');
        collaboratorNameField.addEventListener('input', function() {
        
        if (collaboratorNameField.value.trim() === '') {
            document.getElementById('collaborator_id').value = ''; // Limpa o ID
        }
    });
   });
</script>
@endsection
