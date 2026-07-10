@extends('layouts.app')

@section('title', 'Torne-se um Profissional')
@section('page_heading', 'Divulgar Serviços')

@section('content')
    <div class="max-w-5xl mx-auto">
        <div class="bg-white rounded-xl overflow-hidden">

            <div class="bg-blue-600 px-8 py-10 text-white text-center">
                <h2 class="text-2xl font-bold mb-2">Quero divulgar meus serviços</h2>
                <p class="text-blue-100 text-sm">
                    Preencha os dados abaixo para fazer parte do nosso banco de profissionais e ser recomendado pelo TOPSIS.
                </p>
            </div>

            <div class="p-8">
                <form action="{{ route('professional.become') }}" method="POST">
                    @csrf

                    <div class="space-y-6">
                        <div>
                            <label for="category" class="block text-sm font-medium text-slate-700 mb-2">Categoria de
                                Serviço</label>
                                {{-- @TODO - Alterar para puxar um enum --}}
                            <select id="category" name="category" required
                                class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all bg-slate-50 hover:bg-white text-slate-800">
                                <option value="" disabled selected>Selecione a sua especialidade...</option>
                                <option value="Diarista" {{ old('category') == 'Diarista' ? 'selected' : '' }}>Diarista
                                </option>
                                <option value="Pedreiro" {{ old('category') == 'Pedreiro' ? 'selected' : '' }}>Pedreiro
                                </option>
                                <option value="Pintor" {{ old('category') == 'Pintor' ? 'selected' : '' }}>Pintor</option>
                                <option value="Eletricista" {{ old('category') == 'Eletricista' ? 'selected' : '' }}>
                                    Eletricista</option>
                                <option value="Encanador" {{ old('category') == 'Encanador' ? 'selected' : '' }}>Encanador
                                </option>
                            </select>
                            @error('category')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="hourly_price" class="block text-sm font-medium text-slate-700 mb-2">Preço Base
                                    (R$)</label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 font-medium">R$</span>
                                    <input id="hourly_price" type="number" step="0.01" name="hourly_price"
                                        value="{{ old('hourly_price') }}" required
                                        class="w-full px-4 py-3 pl-11 rounded-lg border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all bg-slate-50 hover:bg-white text-slate-800"
                                        placeholder="0.00">
                                </div>
                                <p class="text-xs text-slate-500 mt-1">Este valor será utilizado no cálculo de custo do
                                    TOPSIS.</p>
                                @error('hourly_price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="experience_years"
                                    class="block text-sm font-medium text-slate-700 mb-2">Experiência (Anos)</label>
                                <input id="experience_years" type="number" name="experience_years"
                                    value="{{ old('experience_years') }}" required
                                    class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all bg-slate-50 hover:bg-white text-slate-800"
                                    placeholder="Ex: 5">
                                <p class="text-xs text-slate-500 mt-1">Critério de benefício no TOPSIS.</p>
                                @error('experience_years')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="response_time_hours" class="block text-sm font-medium text-slate-700 mb-2">Tempo de
                                Resposta Médio (Horas)</label>
                            <input id="response_time_hours" type="number" name="response_time_hours"
                                value="{{ old('response_time_hours') }}" required
                                class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all bg-slate-50 hover:bg-white text-slate-800"
                                placeholder="Ex: 2">
                            <p class="text-xs text-slate-500 mt-1">Estimativa de quanto tempo você demora para responder um
                                cliente. Critério de custo no TOPSIS.</p>
                            @error('response_time_hours')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-100 flex justify-end gap-3">
                        <a href="{{ route('profile') }}"
                            class="px-5 py-2.5 rounded-lg text-slate-600 font-medium hover:bg-slate-100 transition-colors">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="cursor-pointer px-6 py-2.5 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-600/20">
                            Concluir Cadastro
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
