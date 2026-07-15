@extends('layouts.app')

@section('title', 'Buscar Profissionais')
@section('page_heading', 'Buscar Profissionais')

@section('content')
    <x-card class="mb-6 !overflow-visible">
        <h2 class="text-lg font-semibold text-slate-800 mb-4">Selecione a categoria abaixo para aplicar a busca de
            profissionais:</h2>
        <form method="GET" action="{{ route('professionals.search') }}" class="flex flex-col gap-4">
            @if ($categories->count() <= 5)
                <div class="flex flex-wrap gap-2 items-center">
                    @foreach ($categories as $category)
                        <label class="cursor-pointer">
                            <input type="radio" name="category_id" value="{{ $category->id }}" class="peer hidden"
                                {{ $selectedCategory == $category->id ? 'checked' : '' }}>
                            <span
                                class="inline-block px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 peer-checked:bg-blue-600 peer-checked:text-white transition-colors font-medium">
                                {{ $category->name }}
                            </span>
                        </label>
                    @endforeach
                    <button type="button"
                        class="px-4 py-2 bg-white text-slate-700 rounded-lg border border-slate-300 shadow-sm hover:bg-slate-50 transition-colors flex items-center gap-2 font-medium"
                        data-modal-open="criteria-weights-modal">
                        <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                        </svg>
                        Filtros de critério
                    </button>
                    <x-btn-primary type="submit">
                        Buscar
                    </x-btn-primary>
                    @if (request()->has('category_id') || request()->has('weights'))
                        <a href="{{ route('professionals.search') }}"
                            class="text-sm text-slate-500 hover:text-slate-700 ml-2">Limpar filtros</a>
                    @endif
                </div>
            @else
                <div class="flex flex-col sm:flex-row gap-4 items-end">
                    <div class="flex-1 w-full">
                        <x-form-select name="category_id" label="" :options="$categories" :selected="$selectedCategory"
                            placeholder="Todas as categorias" :searchable="true" />
                    </div>
                    <button type="button"
                        class="px-4 py-2.5 bg-white text-slate-700 rounded-lg border border-slate-300 shadow-sm hover:bg-slate-50 transition-colors flex items-center gap-2 font-medium shrink-0 w-full sm:w-auto justify-center"
                        data-modal-open="criteria-weights-modal">
                        <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                        </svg>
                        Filtros de critério
                    </button>
                    @if (request()->has('category_id') || request()->has('weights'))
                        <a href="{{ route('professionals.search') }}"
                            class="px-4 py-2.5 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200 transition-colors shrink-0 w-full sm:w-auto text-center font-medium">
                            Limpar
                        </a>
                    @endif
                    <x-btn-primary type="submit" class="w-full sm:w-auto">
                        Buscar
                    </x-btn-primary>
                </div>
            @endif

            <x-modal id="criteria-weights-modal" title="Ajustar Pesos dos Critérios">
                <div class="space-y-6">
                    <p class="text-sm text-slate-600">Ajuste a importância de cada critério para o cálculo da recomendação.
                        Os valores alterados aqui serão aplicados na próxima busca.</p>
                    <div class="space-y-5">
                        @foreach ($criterias as $criteria)
                            <x-form-slider name="weights[{{ $criteria->id }}]" :label="$criteria->name" :value="request()->input('weights.' . $criteria->id, $criteria->weight)"
                                min="0" max="1" step="0.01" />
                        @endforeach
                    </div>
                </div>
                <x-slot:footer>
                    <x-btn-primary type="button" data-modal-close>
                        Aplicar e Fechar
                    </x-btn-primary>
                </x-slot:footer>
            </x-modal>
        </form>
    </x-card>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($professionals as $professional)
            <x-professional-card :professional="$professional" />
        @empty
            <x-card class="col-span-1 md:col-span-2 text-center" padding="p-8">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2m8-10a4 4 0 100-8 4 4 0 000 8z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-slate-900">Nenhum profissional encontrado</h3>
                <p class="text-slate-500 mt-1">Tente selecionar outra categoria ou limpar os filtros.</p>
            </x-card>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $professionals->links() }}
    </div>
@endsection
