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
                    <p class="text-xs text-slate-500">{{ $criterias->count() }}
                        {{ $criterias->count() === 1 ? 'critério cadastrado' : 'critérios cadastrados' }}
                    </p>
                </div>
            </div>
        </x-slot:header>

        @if($criterias->isEmpty())
            <x-alert-info title="Nenhum critério cadastrado"
                message="Clique em &quot;Novo Critério&quot; para adicionar o primeiro critério de avaliação TOPSIS." />
        @else
            <div class="overflow-x-auto -mx-8 -mb-8">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-8 py-3 text-left text-xs font-semibold uppercase tracking-widest text-slate-400">ID
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-widest text-slate-400">Nome
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-widest text-slate-400">Peso
                            </th>
                            <th class="px-8 py-3 text-right text-xs font-semibold uppercase tracking-widest text-slate-400">
                                Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($criterias as $criteria)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-8 py-4 text-slate-400 text-xs tabular-nums">{{ $criteria->id }}</td>
                                <td class="px-4 py-4 font-medium text-slate-800">{{ $criteria->name }}</td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-1 max-w-[120px] h-1.5 rounded-full bg-slate-200">
                                            <div class="h-1.5 rounded-full bg-blue-500"
                                                style="width: {{ $criteria->weight * 100 }}%"></div>
                                        </div>
                                        <span
                                            class="text-xs font-semibold text-blue-600 tabular-nums w-8">{{ number_format($criteria->weight, 2) }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <x-btn-secondary href="{{ route('criterias.edit', $criteria) }}">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
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
        @endif
    </x-card>
@endsection