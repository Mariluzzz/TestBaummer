@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="center-align">Lista de Tarefas</h2>

    <form action="{{ route('tasks.index') }}" method="GET" class="row">
        <div class="input-field col s3">
            <select name="priority">
                <option value="" selected>Todos</option>
                <option value="Alta" {{ request('priority') == 'Alta' ? 'selected' : '' }}>Alta</option>
                <option value="Média" {{ request('priority') == 'Média' ? 'selected' : '' }}>Média</option>
                <option value="Baixa" {{ request('priority') == 'Baixa' ? 'selected' : '' }}>Baixa</option>
            </select>
            <label>Prioridade</label>
        </div>

        <div class="input-field col s3">
            <input type="text" id="collaborator_name" name="collaborator_name" value="{{ request('collaborator_name') }}">
            <label for="collaborator_name">Colaborador</label>
            <input type="hidden" id="collaborator_id" name="collaborator_id" value="{{ request('collaborator_id') }}">
        </div>

        <div class="input-field col s3">
            <input type="date" name="end_date" value="{{ request('end_date') }}" min="2000-01-01" max="2099-12-31">
            <label>Data de Prazo</label>
        </div>

        <div class="col s3 center-align">
            <button type="submit" class="btn waves-effect waves-light">Filtrar</button>
        </div>
    </form>

    @if ($tasks->isEmpty())
        <div class="center-align">
            <p>Não há tarefas cadastradas.</p>
        </div>
    @else
        <table id="task-table" class="striped centered responsive-table" >
            <thead class="grey lighten-1 black-text">
                <tr>
                    <th>Descrição</th>
                    <th>Responsável</th>
                    <th>Prioridade</th>
                    <th>Data criação</th>
                    <th>Data final/prazo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr class="grey lighten-2 black-text">
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->collaborator->name ?? 'Não atribuído' }}</td>
                        <td>{{ ucfirst($task->priority) }}</td>
                        <td>{{ \Carbon\Carbon::parse($task->created_at)->format('d/m/Y H:i') ?? 'Não definida' }}</td>
                        <td>{{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y H:i') ?? 'Não definida' }}</td>
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

    @if(session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                M.toast({html: "{{ session('success') }}", classes: 'rounded green'});
            });
        </script>
    @endif

    <div class="center-align" style="margin-top: 1em;">
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
                document.getElementById('collaborator_id').value = '';
            }
        });

        $('#task-table').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
            },
            paging: false,
            searching: false,
            ordering: true,
            responsive: true,
            info: false 
        });
   });
</script>
@endsection
