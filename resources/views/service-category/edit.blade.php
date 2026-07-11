@extends('layouts.app')

@section('title', 'Editar Categoria')
@section('page_heading', 'Editar Categoria de Serviço')

@section('content')
    <div class="w-full">
        <x-card>
            <x-slot:header>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-slate-900">Editar: {{ $serviceCategory->name }}</h3>
                </div>
            </x-slot:header>

            <form action="{{ route('service-categories.update', $serviceCategory) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <x-form-input label="Nome da Categoria" name="name" :value="$serviceCategory->name"
                    placeholder="Ex: Eletricista, Diarista, Pedreiro..." :required="true"
                    hint="O nome deve ser único e representar claramente o tipo de serviço." />

                <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                    <x-btn-secondary href="{{ route('service-categories.index') }}">
                        Cancelar
                    </x-btn-secondary>
                    <x-btn-primary type="submit">
                        Atualizar Categoria
                    </x-btn-primary>
                </div>
            </form>
        </x-card>
    </div>
@endsection