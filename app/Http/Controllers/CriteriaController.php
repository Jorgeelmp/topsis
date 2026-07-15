<?php

namespace App\Http\Controllers;

use App\Enums\ProfessionalFieldsEnum;
use App\Models\Criteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class CriteriaController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('admin');

        $criterias = Criteria::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(10);

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
            'professional_field' => ['required', Rule::enum(ProfessionalFieldsEnum::class)],
            'weight' => ['required', 'numeric', 'between:0,1'],
            'type' => ['required', 'string', 'in:cost,benefit'],
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
            'professional_field' => ['required', Rule::enum(ProfessionalFieldsEnum::class)],
            'weight' => ['required', 'numeric', 'between:0,1'],
            'type' => ['required', 'string', 'in:cost,benefit'],
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
