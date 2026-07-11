<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ServiceCategoryController extends Controller
{
    public function index()
    {
        Gate::authorize('admin');

        $categories = ServiceCategory::orderBy('name')->get();

        return view('service-category.index', compact('categories'));
    }

    public function create()
    {
        Gate::authorize('admin');

        return view('service-category.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('admin');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:service_categories,name'],
        ]);

        ServiceCategory::create($validated);

        return to_route('service-categories.index')
            ->with('success', 'Categoria criada com sucesso!');
    }

    public function edit(ServiceCategory $serviceCategory)
    {
        Gate::authorize('admin');

        return view('service-category.edit', compact('serviceCategory'));
    }

    public function update(Request $request, ServiceCategory $serviceCategory)
    {
        Gate::authorize('admin');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:service_categories,name,' . $serviceCategory->id],
        ]);

        $serviceCategory->update($validated);

        return to_route('service-categories.index')
            ->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy(ServiceCategory $serviceCategory)
    {
        Gate::authorize('admin');

        $serviceCategory->delete();

        return to_route('service-categories.index')
            ->with('success', 'Categoria removida com sucesso!');
    }
}
