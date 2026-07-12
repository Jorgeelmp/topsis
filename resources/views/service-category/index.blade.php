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
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
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
                        <p class="text-xs text-slate-500">{{ $categories->total() }}
                            {{ $categories->total() === 1 ? 'categoria cadastrada' : 'categorias cadastradas' }}</p>
                    </div>
                </div>

                <form action="{{ route('service-categories.index') }}" method="GET" class="w-full sm:w-64">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar categoria..." 
                               class="w-full pl-9 pr-3 py-2 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </form>
            </div>
        </x-slot:header>

        @if($categories->isEmpty())
            <x-alert-info title="Nenhuma categoria cadastrada"
                message="Clique em Nova Categoria para adicionar a primeira categoria de serviço." />
        @else
            <div class="overflow-x-auto -mx-8 -mb-8">
                <table class="w-full text-xs sm:text-sm">
                    <thead class="hidden sm:table-header-group">
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
                    <tbody class="divide-y divide-slate-100 flex flex-col sm:table-row-group">
                        @foreach($categories as $category)
                            <tr class="hover:bg-slate-50 transition-colors flex flex-col sm:table-row p-4 sm:p-0 border-b border-slate-100 sm:border-0 relative">
                                <td class="px-4 sm:px-8 py-2 sm:py-4 text-slate-400 tabular-nums flex sm:table-cell justify-between items-center before:content-['ID'] before:sm:hidden before:font-semibold before:text-slate-500">
                                    {{ $category->id }}
                                </td>
                                <td class="px-4 py-2 sm:py-4 font-medium text-slate-800 flex sm:table-cell justify-between items-center before:content-['Nome'] before:sm:hidden before:font-semibold before:text-slate-500">
                                    <span class="inline-flex items-center gap-1.5">
                                        {{ $category->name }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 sm:py-4 text-slate-500 flex sm:table-cell justify-between items-center before:content-['Criado_em'] before:sm:hidden before:font-semibold before:text-slate-500">
                                    {{ $category->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-4 sm:px-8 py-4 sm:py-4 flex sm:table-cell justify-end sm:justify-end items-center mt-2 sm:mt-0 pt-4 sm:pt-4 border-t border-slate-100 sm:border-0">
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

            @if($categories->hasPages())
                <div class="px-8 py-4 border-t border-slate-200">
                    {{ $categories->withQueryString()->links() }}
                </div>
            @endif
        @endif
    </x-card>
@endsection