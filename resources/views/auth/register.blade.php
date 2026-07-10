@extends('layouts.auth')

@section('title', 'Cadastro')
@section('meta_description', 'Crie sua conta na plataforma TOPSIS para encontrar ou oferecer serviços.')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @vite('resources/js/register-map.js')
    <style>
        #map {
            height: 260px;
            border-radius: 0.75rem;
            border: 1.5px solid #e2e8f0;
            z-index: 0;
        }

        .leaflet-container {
            font-family: inherit;
        }
    </style>
@endpush

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Crie sua conta</h1>
        <p class="text-slate-600 text-sm mt-1">
            Preencha seus dados para se cadastrar na plataforma.
        </p>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg py-3 px-4 text-sm mb-6" role="alert">
            <div class="flex items-start gap-2">
                <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                </svg>
                <ul class="space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ url('/register') }}" id="register-form" novalidate>
        @csrf

        <div class="mb-5">
            <label for="name" class="block text-sm font-medium text-slate-600 mb-1.5">Nome</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </span>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    autocomplete="name" placeholder="Seu nome completo"
                    class="w-full px-3.5 py-2.5 border-1.5 rounded-lg bg-white text-slate-900 text-[15px] leading-relaxed transition-colors duration-200 focus:outline-none focus:ring-3 placeholder:text-slate-400 pl-10 {{ $errors->has('name') ? 'border-red-500 focus:border-red-500 focus:ring-red-500/15' : 'border-slate-200 focus:border-blue-500 focus:ring-blue-500/15' }}">
            </div>
        </div>

        <div class="mb-5">
            <label for="email" class="block text-sm font-medium text-slate-600 mb-1.5">E-mail</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                    </svg>
                </span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    autocomplete="username" placeholder="seu@email.com"
                    class="w-full px-3.5 py-2.5 border-1.5 rounded-lg bg-white text-slate-900 text-[15px] leading-relaxed transition-colors duration-200 focus:outline-none focus:ring-3 placeholder:text-slate-400 pl-10 {{ $errors->has('email') ? 'border-red-500 focus:border-red-500 focus:ring-red-500/15' : 'border-slate-200 focus:border-blue-500 focus:ring-blue-500/15' }}">
            </div>
        </div>

        <div class="mb-5">
            <label for="password" class="block text-sm font-medium text-slate-600 mb-1.5">Senha</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                </span>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    placeholder="••••••••"
                    class="w-full px-3.5 py-2.5 border-1.5 rounded-lg bg-white text-slate-900 text-[15px] leading-relaxed transition-colors duration-200 focus:outline-none focus:ring-3 placeholder:text-slate-400 pl-10 {{ $errors->has('password') ? 'border-red-500 focus:border-red-500 focus:ring-red-500/15' : 'border-slate-200 focus:border-blue-500 focus:ring-blue-500/15' }}">
            </div>
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-slate-600 mb-1.5">Confirmar
                Senha</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                </span>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    autocomplete="new-password" placeholder="••••••••"
                    class="w-full px-3.5 py-2.5 border-1.5 rounded-lg bg-white text-slate-900 text-[15px] leading-relaxed transition-colors duration-200 focus:outline-none focus:ring-3 placeholder:text-slate-400 pl-10 border-slate-200 focus:border-blue-500 focus:ring-blue-500/15">
            </div>
        </div>

        <div class="mb-7">
            <label class="block text-sm font-medium text-slate-600 mb-1.5">
                Sua localização
                <span class="text-slate-400 font-normal">(clique no mapa para marcar)</span>
            </label>

            <div id="map" class="w-full mb-3"></div>

            <p id="map-hint" class="text-xs text-slate-400 mt-1.5 flex items-center gap-1">
                <svg class="w-3.5 h-3.5 shrink-0 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                </svg>
                Clique no mapa para definir sua localização. Isso é usado para calcular a distância até os profissionais.
            </p>

            @error('latitude')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            @error('longitude')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror

            <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
            <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">
        </div>

        <button type="submit" id="register-submit"
            class="inline-flex items-center justify-center gap-2 w-full py-2.5 px-6 bg-blue-600 text-white font-semibold text-[15px] rounded-lg shadow-[0_4px_14px_0_rgba(37,99,235,0.35)] transition-all duration-150 hover:brightness-110 hover:-translate-y-[1px] hover:shadow-[0_6px_20px_0_rgba(37,99,235,0.4)] active:translate-y-0 active:shadow-[0_2px_8px_0_rgba(37,99,235,0.3)] disabled:opacity-60 disabled:cursor-not-allowed disabled:transform-none">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM4 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 10.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
            </svg>
            Criar conta
        </button>
    </form>

    <hr class="border-t border-slate-200 my-6">

    <p class="text-center text-sm text-slate-600">
        Já tem uma conta?
        <a href="{{ url('/login') }}" class="font-semibold text-blue-600 hover:underline">
            Entre aqui
        </a>
    </p>

@endsection
