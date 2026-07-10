@extends('layouts.auth')

@section('title', 'Entrar')
@section('meta_description', 'Faça login na plataforma TOPSIS e encontre os melhores profissionais autônomos.')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Boas-vindas novamente 👋</h1>
        <p class="text-slate-600 text-sm mt-1">
            Preencha com suas credenciais para acessar a plataforma.
        </p>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg py-3 px-4 text-sm mb-6" role="alert">
            <div class="flex items-start gap-2">
                <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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

    <form method="POST" action="{{ url('/login') }}" id="login-form" novalidate>
        @csrf

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
            <div class="flex items-center justify-between mb-1">
                <label for="password" class="block text-sm font-medium text-slate-600 mb-0">Senha</label>
            </div>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                </span>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    placeholder="••••••••"
                    class="w-full px-3.5 py-2.5 border-1.5 rounded-lg bg-white text-slate-900 text-[15px] leading-relaxed transition-colors duration-200 focus:outline-none focus:ring-3 placeholder:text-slate-400 pl-10 {{ $errors->has('password') ? 'border-red-500 focus:border-red-500 focus:ring-red-500/15' : 'border-slate-200 focus:border-blue-500 focus:ring-blue-500/15' }}">
            </div>
        </div>

        <div class="flex items-center gap-2 mb-7">
            <input id="remember" type="checkbox" name="remember"
                class="w-4 h-4 rounded border-slate-300 text-blue-600 accent-blue-600"
                {{ old('remember') ? 'checked' : '' }}>
            <label for="remember" class="text-sm text-slate-600 cursor-pointer select-none">
                Me lembre neste dispositivo
            </label>
        </div>

        <button type="submit" id="login-submit"
            class="inline-flex items-center justify-center gap-2 w-full py-2.5 px-6 bg-blue-600 text-white font-semibold text-[15px] rounded-lg shadow-[0_4px_14px_0_rgba(37,99,235,0.35)] transition-all duration-150 hover:brightness-110 hover:-translate-y-[1px] hover:shadow-[0_6px_20px_0_rgba(37,99,235,0.4)] active:translate-y-0 active:shadow-[0_2px_8px_0_rgba(37,99,235,0.3)] disabled:opacity-60 disabled:cursor-not-allowed disabled:transform-none">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
            </svg>
            Entrar na plataforma
        </button>
    </form>

    <hr class="border-t border-slate-200 my-6">

    <p class="text-center text-sm text-slate-600">
        Não tem uma conta?
        <a href="{{ url('/register') }}" class="font-semibold text-blue-600 hover:underline">
            Cadastre-se agora
        </a>
    </p>
@endsection
