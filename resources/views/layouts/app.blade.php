<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'TOPSIS') - Recomendação de Profissionais</title>
    <meta name="description"
        content="@yield('meta_description', 'Plataforma inteligente de recomendação de profissionais autônomos baseada no método TOPSIS.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="flex min-h-screen bg-slate-50 font-sans text-slate-900">

    <input type="checkbox" id="mobile-sidebar-toggle" class="peer hidden" />

    <aside id="sidebar"
        class="w-[260px] shrink-0 bg-white border-r border-slate-200 flex flex-col h-screen sticky top-0 transition-transform duration-300 ease-in-out z-40
               max-lg:fixed max-lg:-translate-x-full max-lg:top-0 max-lg:left-0 max-lg:h-full peer-checked:max-lg:translate-x-0">

        <div class="px-5 py-5 border-b border-slate-200">
            <a href="{{ url('/') }}"
                class="inline-flex items-center gap-2.5 font-bold text-[1.1rem] text-blue-900 tracking-tight">
                <span>TOPSIS</span>
            </a>
        </div>

        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            <p class="px-3 text-[0.7rem] font-semibold uppercase tracking-widest text-slate-400 mb-2">
                Principal
            </p>

            <a href="{{ url('/search') }}"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-[15px] transition-colors duration-150 {{ request()->is('search*') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-slate-600 font-medium hover:bg-blue-50 hover:text-blue-700' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                Buscar Profissionais
            </a>

            @if(auth()->user()?->role === \App\Enums\RolesEnum::ADMIN)
                <a href="{{ route('criterias.index') }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-[15px] transition-colors duration-150 {{ request()->is('criterias*') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-slate-600 font-medium hover:bg-blue-50 hover:text-blue-700' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                    </svg>
                    Critérios
                </a>

                <a href="{{ route('service-categories.index') }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-[15px] transition-colors duration-150 {{ request()->is('service-categories*') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-slate-600 font-medium hover:bg-blue-50 hover:text-blue-700' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                    </svg>
                    Categorias
                </a>
            @endif

            <hr class="border-t border-slate-200 my-6">

            <p class="px-3 text-[0.7rem] font-semibold uppercase tracking-widest text-slate-400 mb-2">
                Configurações
            </p>

            <a href="{{ url('/profile') }}"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-[15px] transition-colors duration-150 {{ request()->is('profile*') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-slate-600 font-medium hover:bg-blue-50 hover:text-blue-700' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
                Meu Perfil
            </a>

            @if(auth()->user()?->role === \App\Enums\RolesEnum::ADMIN)
                <a href="{{ url('/users') }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-[15px] transition-colors duration-150 {{ request()->is('users*') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-slate-600 font-medium hover:bg-blue-50 hover:text-blue-700' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    Usuários
                </a>
            @endif
        </nav>

        @auth
            <div class="px-3 py-4 border-t border-slate-200">
                <div class="flex items-center gap-3 px-2 py-2 rounded-lg hover:bg-slate-50 transition-colors">
                    <div class="w-9 h-9 rounded-full bg-blue-600
                                flex items-center justify-center text-white font-bold text-sm shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-400 truncate">{{ auth()->user()->role->label() }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="Sair"
                            class="text-slate-400 hover:text-red-500 transition-colors cursor-pointer">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        @endauth
    </aside>

    <label for="mobile-sidebar-toggle" id="sidebar-overlay"
        class="fixed inset-0 bg-black/40 z-30 hidden lg:hidden peer-checked:block cursor-pointer"></label>

    <div class="flex flex-col flex-1 min-w-0">

        <header class="h-16 bg-white border-b border-slate-200 flex items-center px-4 sm:px-6 gap-4 sticky top-0 z-30">
            <label for="mobile-sidebar-toggle"
                class="lg:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100 transition-colors cursor-pointer"
                aria-label="Abrir menu">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </label>

            <div class="flex-1">
                <h1 class="text-base font-semibold text-slate-900">@yield('page_heading', 'Dashboard')</h1>
            </div>

            <div class="flex items-center gap-3">
                @yield('topbar_actions')
            </div>
        </header>

        <main class="flex-1 py-6 px-4 sm:px-6 lg:px-8 max-w-screen-xl w-full mx-auto">
            @if (session('success'))
                <div
                    class="bg-green-50 border border-green-200 text-green-700 rounded-lg py-3 px-4 text-sm mb-5 flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div
                    class="bg-red-50 border border-red-200 text-red-700 rounded-lg py-3 px-4 text-sm mb-5 flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>

</html>