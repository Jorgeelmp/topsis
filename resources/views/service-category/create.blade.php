@extends('layouts.app')

@section('title', 'Nova Categoria')
@section('page_heading', 'Nova Categoria de Serviço')

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
                    <h3 class="text-base font-semibold text-slate-900">Cadastrar Categoria</h3>
                </div>
            </x-slot:header>

            <form action="{{ route('service-categories.store') }}" method="POST" class="space-y-6">
                @csrf

                <x-form-input label="Nome da Categoria" name="name" placeholder="Ex: Eletricista, Diarista, Pedreiro..."
                    :required="true" hint="O nome deve ser único e representar claramente o tipo de serviço." />

                <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                    <x-btn-secondary href="{{ route('service-categories.index') }}">
                        Cancelar
                    </x-btn-secondary>
                    <x-btn-primary type="submit">
                        Salvar Categoria
                    </x-btn-primary>
                </div>
            </form>
        </x-card>
    </div>
@endsection