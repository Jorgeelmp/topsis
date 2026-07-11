<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CriteriaController extends Controller
{
    public function index()
    {
        Gate::authorize('admin');

        $criterias = Criteria::orderBy('name')->get();

        return view('criteria.index', compact('criterias'));
    }

    public function create()
    {
        Gate::authorize('admin');

        return view('criteria.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('admin');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'weight' => ['required', 'numeric', 'between:0,1'],
        ]);

        Criteria::create($validated);

        return to_route('criterias.index')
            ->with('success', 'Critério criado com sucesso!');
    }

    public function edit(Criteria $criteria)
    {
        Gate::authorize('admin');

        return view('criteria.edit', compact('criteria'));
    }

    public function update(Request $request, Criteria $criteria)
    {
        Gate::authorize('admin');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'weight' => ['required', 'numeric', 'between:0,1'],
        ]);

        $criteria->update($validated);

        return to_route('criterias.index')
            ->with('success', 'Critério atualizado com sucesso!');
    }

    public function destroy(Criteria $criteria)
    {
        Gate::authorize('admin');

        $criteria->delete();

        return to_route('criterias.index')
            ->with('success', 'Critério removido com sucesso!');
    }
}
