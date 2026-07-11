@extends('layouts.app')

@section('title', 'Novo Critério')
@section('page_heading', 'Novo Critério')

@section('content')
    <div class="w-full">
        <x-card>
            <x-slot:header>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-slate-900">Cadastrar Critério</h3>
                </div>
            </x-slot:header>

            <form action="{{ route('criterias.store') }}" method="POST" class="space-y-6">
                @csrf

                <x-form-input label="Nome do Critério" name="name"
                    placeholder="Ex: Experiência, Preço, Tempo de Resposta..." :required="true"
                    hint="Descreva o que esse critério avalia no profissional." />

                <x-form-slider label="Peso Padrão do Critério" name="weight" value="0" min="0" max="1" step="0.01" :required="true"
                    hint="Define a importância deste critério no cálculo TOPSIS. Valores próximos de 1 têm maior influência." />

                <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                    <x-btn-secondary href="{{ route('criterias.index') }}">
                        Cancelar
                    </x-btn-secondary>
                    <x-btn-primary type="submit">
                        Salvar Critério
                    </x-btn-primary>
                </div>
            </form>
        </x-card>
    </div>
@endsection