@extends('layouts.app')

@section('title', 'Critérios')
@section('page_heading', 'Critérios TOPSIS')

@section('topbar_actions')
    <x-btn-primary href="{{ route('criterias.create') }}">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Novo Critério
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
                                d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-slate-900">Lista de Critérios</h3>
                        <p class="text-xs text-slate-500">{{ $criterias->total() }}
                            {{ $criterias->total() === 1 ? 'critério cadastrado' : 'critérios cadastrados' }}
                        </p>
                    </div>
                </div>

                <form action="{{ route('criterias.index') }}" method="GET" class="w-full sm:w-64">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Buscar critério..."
                            class="w-full pl-9 pr-3 py-2 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </form>
            </div>
        </x-slot:header>

        @if ($criterias->isEmpty())
            <x-alert-info title="Nenhum critério cadastrado"
                message="Clique em Novo Critério para adicionar o primeiro critério de avaliação TOPSIS." />
        @else
            <div class="overflow-x-auto -mx-8 -mb-8">
                <table class="w-full text-xs sm:text-sm">
                    <thead class="hidden sm:table-header-group">
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-8 py-3 text-left text-xs font-semibold uppercase tracking-widest text-slate-400">
                                ID
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-widest text-slate-400">
                                Nome
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-widest text-slate-400">
                                Tipo
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-widest text-slate-400">
                                Peso
                            </th>
                            <th class="px-8 py-3 text-right text-xs font-semibold uppercase tracking-widest text-slate-400">
                                Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 flex flex-col sm:table-row-group">
                        @foreach ($criterias as $criteria)
                            <tr
                                class="hover:bg-slate-50 transition-colors flex flex-col sm:table-row p-4 sm:p-0 border-b border-slate-100 sm:border-0 relative">
                                <td
                                    class="px-4 sm:px-8 py-2 sm:py-4 text-slate-400 tabular-nums flex sm:table-cell justify-between items-center before:content-['ID'] before:sm:hidden before:font-semibold before:text-slate-500">
                                    {{ $criteria->id }}
                                </td>
                                <td
                                    class="px-4 py-2 sm:py-4 font-medium text-slate-800 flex sm:table-cell justify-between items-center before:content-['Nome'] before:sm:hidden before:font-semibold before:text-slate-500">
                                    {{ $criteria->name }}
                                </td>
                                <td
                                    class="px-4 py-2 sm:py-4 font-medium text-slate-800 flex sm:table-cell justify-between items-center before:content-['Nome'] before:sm:hidden before:font-semibold before:text-slate-500">
                                    {{ $criteria->type->label() }}
                                </td>
                                <td
                                    class="px-4 py-2 sm:py-4 flex sm:table-cell justify-between items-center before:content-['Peso'] before:sm:hidden before:font-semibold before:text-slate-500">
                                    <div class="flex items-center gap-3 w-full sm:w-auto justify-end sm:justify-start">
                                        <div class="flex-1 sm:flex-none w-24 max-w-[120px] h-1.5 rounded-full bg-slate-200">
                                            <div class="h-1.5 rounded-full bg-blue-500"
                                                style="width: {{ $criteria->weight * 100 }}%"></div>
                                        </div>
                                        <span
                                            class="text-xs font-semibold text-blue-600 tabular-nums w-8">{{ number_format($criteria->weight, 2) }}</span>
                                    </div>
                                </td>
                                <td
                                    class="px-4 sm:px-8 py-4 sm:py-4 flex sm:table-cell justify-end sm:justify-end items-center mt-2 sm:mt-0 pt-4 sm:pt-4 border-t border-slate-100 sm:border-0">
                                    <div class="flex items-center justify-end gap-2">
                                        <x-btn-secondary href="{{ route('criterias.edit', $criteria) }}">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
                                            </svg>
                                            Editar
                                        </x-btn-secondary>
                                        <x-btn-delete :action="route('criterias.destroy', $criteria)" />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($criterias->hasPages())
                <div class="px-8 py-4 border-t border-slate-200">
                    {{ $criterias->withQueryString()->links() }}
                </div>
            @endif
        @endif
    </x-card>
@endsection
