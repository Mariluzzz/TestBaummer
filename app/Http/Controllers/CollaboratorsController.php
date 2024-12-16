<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterCollaboratorsRequest;
use App\Http\Requests\UpdateCollaboratorsRequest;
use App\Models\Collaborators;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollaboratorsController extends Controller
{

    public function index()
    {
        $collaborators = Collaborators::paginate(10);
        return view('collaborators.index', compact('collaborators'));
    }

    public function create()
    {
        return view('collaborators.createCollaborators');
    }

    public function register(RegisterCollaboratorsRequest $request)
    {
        Collaborators::create([
            'name' => $request->name,
            'cpf' => $request->cpf,
            'email' => $request->email,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('collaborators.index')->with('success', 'Colaborador cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $collaborator = Collaborators::findOrFail($id);
        return view('collaborators.updateCollaborators', compact('collaborator'));
    }

    public function update(UpdateCollaboratorsRequest $request, $id)
    {
        $collaborator = Collaborators::findOrFail($id);
        $collaborator->update($request->all());
        return redirect()->route('collaborators.index')->with('success', 'Colaborador atualizado com sucesso!');
    }

    public function delete($id)
    {
        $task = Collaborators::findOrFail($id);
        $task->delete();

        return redirect()->route('collaborators.index')->with('success', 'Colaborador excluído com sucesso!');
    }
}
