@extends('layouts.app')

@section('title', 'Torne-se um Profissional')
@section('page_heading', 'Divulgar Serviços')

@section('content')
    <div class="w-full">
        <x-card>
            <x-slot:header>
                <div class="bg-blue-600 -mx-8 -mt-8 px-8 py-8 text-white text-center rounded-t-xl mb-0">
                    <h2 class="text-xl font-bold mb-1">Quero divulgar meus serviços</h2>
                    <p class="text-blue-100 text-sm">
                        Preencha os dados abaixo para fazer parte do banco de profissionais e ser recomendado pelo TOPSIS.
                    </p>
                </div>
            </x-slot:header>

            <form action="{{ route('professional.become') }}" method="POST" class="space-y-6">
                @csrf

                <x-form-select label="Categoria de Serviço" name="service_category_id" :options="$categories"
                    :required="true" placeholder="Selecione a sua especialidade..."
                    hint="Escolha a categoria que melhor representa o seu serviço." />

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <x-form-input label="Preço Base (R$/Hora)" name="hourly_price" type="number" step="0.01" placeholder="0.00"
                        prefix="R$" :required="true" hint="Critério de custo no TOPSIS." />

                    <x-form-input label="Experiência (Anos)" name="experience_years" type="number" placeholder="Ex: 5"
                        :required="true" hint="Critério de benefício no TOPSIS." />
                </div>

                <x-form-input label="Tempo de Resposta Médio (Minutos)" name="response_time_hours" type="number"
                    placeholder="Ex: 2" :required="true"
                    hint="Estimativa de quanto tempo você demora para responder um cliente. Critério de custo no TOPSIS." />

                <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                    <x-btn-secondary href="{{ route('profile') }}">
                        Cancelar
                    </x-btn-secondary>
                    <x-btn-primary type="submit">
                        Concluir Cadastro
                    </x-btn-primary>
                </div>
            </form>
        </x-card>
    </div>
@endsection