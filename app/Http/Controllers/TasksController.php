<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterTasksRequest;
use App\Models\Collaborators;
use App\Models\Tasks;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function index(Request $request)
    {
        $query = Tasks::query();

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('collaborator_id')) {
            $query->where('collaborator_id', $request->collaborator_id);
        }

        if ($request->filled('executed_date')) {
            $query->whereDate('executed_at', '=', $request->executed_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('deadline', '=', $request->end_date);
        }

        $tasks = $query->with('collaborator')->paginate(10);
        $collaborators = Collaborators::all();

        return view('tasks.index', compact('tasks', 'collaborators'));
    }

    public function create()
    {
        $collaborators = Collaborators::all();
        return view('tasks.createTasks', compact('collaborators'));
    }

    public function register(RegisterTasksRequest $request)
    {

        Tasks::create([
            'description' => $request->description,
            'deadline' => $request->deadline,
            'collaborator_id' => $request->collaborator_id,
            'priority' => $request->priority,
            'created_at' => \Carbon\Carbon::now('America/Sao_Paulo'),
            'executed_at' => !empty($request->executed_at) ? $request->executed_at : null,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tarefa cadastrada com sucesso!');
    }

    public function edit($id)
    {
        $task = Tasks::findOrFail($id);
        $collaborators = Collaborators::all();
        
        return view('tasks.updateTasks', compact('task', 'collaborators'));
    }

    public function update(RegisterTasksRequest $request, $id)
    {
        $task = Tasks::findOrFail($id);
        
        $task->update([
            'description' => $request->description,
            'deadline' => $request->deadline,
            'collaborator_id' => $request->collaborator_id,
            'priority' => $request->priority,
            'executed_at' => !empty($request->executed_at) ? $request->executed_at : null,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tarefa atualizada com sucesso!');
    }

    public function delete($id)
    {
        $task = Tasks::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tarefa excluído com sucesso!');
    }
    
}
