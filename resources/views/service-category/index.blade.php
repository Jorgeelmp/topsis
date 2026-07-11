@extends('layouts.app')

@section('title', 'Categorias de Serviço')
@section('page_heading', 'Categorias de Serviço')

@section('topbar_actions')
    <x-btn-primary href="{{ route('service-categories.create') }}">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Nova Categoria
    </x-btn-primary>
@endsection

@section('content')
    <x-card>
        <x-slot:header>
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-slate-900">Lista de Categorias</h3>
                    <p class="text-xs text-slate-500">{{ $categories->count() }}
                        {{ $categories->count() === 1 ? 'categoria cadastrada' : 'categorias cadastradas' }}</p>
                </div>
            </div>
        </x-slot:header>

        @if($categories->isEmpty())
            <x-alert-info title="Nenhuma categoria cadastrada"
                message="Clique em Nova Categoria para adicionar a primeira categoria de serviço." />
        @else
            <div class="overflow-x-auto -mx-8 -mb-8">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-8 py-3 text-left text-xs font-semibold uppercase tracking-widest text-slate-400">ID
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-widest text-slate-400">Nome
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-widest text-slate-400">
                                Criado em</th>
                            <th class="px-8 py-3 text-right text-xs font-semibold uppercase tracking-widest text-slate-400">
                                Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($categories as $category)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-8 py-4 text-slate-400 text-xs tabular-nums">{{ $category->id }}</td>
                                <td class="px-4 py-4 font-medium text-slate-800">
                                    <span class="inline-flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-blue-400 shrink-0"></span>
                                        {{ $category->name }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-slate-500">{{ $category->created_at->format('d/m/Y') }}</td>
                                <td class="px-8 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <x-btn-secondary href="{{ route('service-categories.edit', $category) }}">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
                                            </svg>
                                            Editar
                                        </x-btn-secondary>
                                        <x-btn-delete :action="route('service-categories.destroy', $category)" />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-card>
@endsection