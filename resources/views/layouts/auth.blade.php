<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Entrar') - TOPSIS</title>
    <meta name="description" content="@yield('meta_description', 'Acesse a plataforma de recomendação de profissionais autônomos.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="font-sans text-slate-900 bg-slate-50">

    <div class="min-h-screen flex">

        <div
            class="hidden lg:flex lg:w-1/2 xl:w-[55%] relative overflow-hidden
                    bg-gradient-to-br from-blue-900 via-blue-700 to-blue-600
                    flex-col items-center justify-center px-12">

            <div class="absolute inset-0 opacity-10"
                style="background-image: radial-gradient(circle at 25% 25%, white 1px, transparent 0),
                                          radial-gradient(circle at 75% 75%, white 1px, transparent 0);
                        background-size: 48px 48px;">
            </div>

            <div class="relative z-10 text-white max-w-md text-center">
                <div class="flex items-center justify-center gap-3 mb-10">
                    <span class="text-3xl font-bold tracking-tight">TOPSIS</span>
                </div>

                <h2 class="text-3xl font-bold leading-snug mb-4">
                    Encontre o profissional<br>
                    <span class="text-blue-300">ideal para você.</span>
                </h2>
                <p class="text-white/70 text-base leading-relaxed">
                    A plataforma utiliza o método multicritério <strong class="text-white">TOPSIS</strong>
                    para recomendar os melhores profissionais autônomos de acordo com suas necessidades.
                </p>
            </div>
        </div>

        <div
            class="flex-1 flex flex-col items-center justify-center
                    px-6 py-12 bg-slate-50 min-h-screen">

            <div class="lg:hidden mb-10 flex items-center gap-3">
                <span class="text-2xl font-bold text-blue-900 tracking-tight">TOPSIS</span>
            </div>

            <div class="w-full max-w-md">
                @yield('content')
            </div>
        </div>
    </div>
</body>

</html>
