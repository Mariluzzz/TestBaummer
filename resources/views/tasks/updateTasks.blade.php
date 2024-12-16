@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="center-align">Editar Tarefa</h2>

    @if ($errors->has('collaborator_id'))
        <span class="red-text">{{ $errors->first('collaborator_id') }}</span>
    @endif

    <form method="POST" action="{{ route('tasks.update', $task->id) }}">
        @csrf
        @method('PUT')

        <div class="input-field">
            <input type="text" name="description" id="description" value="{{ old('description', $task->description) }}">
            <label for="description">Descrição</label>
            @error('description')
                <span class="helper-text red-text">{{ $message }}</span>
            @enderror
        </div>

        <label for="deadline">Data/Hora Prazo Limite</label>
        <div class="input-field">
            <input type="datetime-local" name="deadline" id="deadline" value="{{ old('deadline', \Carbon\Carbon::parse($task->deadline)->format('Y-m-d H:i')) }}" min="1900-01-01T00:00" max="2037-12-31T23:59">
            @error('deadline')
                <span class="helper-text red-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="input-field">
            <input type="text" name="collaborator_name" id="collaborator_name" value="{{ old('collaborator_name', $task->collaborator->name) }}" 
                {{ $collaborators->isEmpty() ? 'disabled' : '' }}>
            <input type="hidden" name="collaborator_id" id="collaborator_id" value="{{ old('collaborator_id', $task->collaborator->id) }}"> 
            <label for="collaborator_name">Responsável</label>
            @error('collaborator_name')
                <span class="helper-text red-text">{{ $message }}</span>
            @enderror
        </div>

        @if ($collaborators->isEmpty())
            <div class="center-align red-text">
                <p>Não há colaboradores cadastrados. Cadastre um colaborador primeiro para atribuir uma tarefa.</p>
            </div>
        @endif

        <div class="input-field">
            <select name="priority" id="priority">
                <option value="" disabled>Escolha a Prioridade</option>
                <option value="baixa" {{ old('priority', $task->priority) == 'Baixa' ? 'selected' : '' }}>Baixa</option>
                <option value="média" {{ old('priority', $task->priority) == 'Média' ? 'selected' : '' }}>Média</option>
                <option value="alta" {{ old('priority', $task->priority) == 'Alta' ? 'selected' : '' }}>Alta</option>
            </select>
            <label for="priority">Prioridade</label>
            @error('priority')
                <span class="helper-text red-text">{{ $message }}</span>
            @enderror
        </div>

        <label for="executed_at">Data/Hora de Execução</label>
        <div class="input-field">
            <input type="datetime-local" name="executed_at" id="executed_at" value="{{ old('executed_at', $task->executed_at ? \Carbon\Carbon::parse($task->executed_at)->format('Y-m-d\TH:i') : '') }}" min="1900-01-01T00:00" max="2037-12-31T23:59">
        </div>

        <div class="center-align">
            <button type="submit" class="waves-effect waves-light btn" {{ $collaborators->isEmpty() ? 'disabled' : '' }}>
                Atualizar Tarefa
            </button>
        </div>
    </form>

    <div class="center-align" style="margin-top: 1em;">
        <button class="btn"><a class="white-text" href="{{ route('tasks.index') }}">Voltar a lista de tarefas</a></button>
    </div>
    
    @if(session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                M.toast({html: "{{ session('success') }}", classes: 'rounded green'});
            });
        </script>
    @endif
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
});
</script>
@endsection
