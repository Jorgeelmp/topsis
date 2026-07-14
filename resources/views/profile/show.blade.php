@extends('layouts.app')

@section('title', 'Meu Perfil')
@section('page_heading', 'Meu Perfil')

@section('topbar_actions')
    @if (auth()->user()->role === \App\Enums\RolesEnum::CLIENT)
        <x-btn-primary href="{{ route('professional.become') }}">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Quero divulgar meus serviços
        </x-btn-primary>
    @endif
@endsection

@section('content')
    <div class="space-y-6">

        <x-card padding="">
            <div class="bg-blue-600 px-8 py-10 flex items-center gap-6 rounded-t-xl">
                <div
                    class="w-20 h-20 rounded-full bg-white/20 flex items-center justify-center text-white font-bold text-3xl shrink-0 ring-4 ring-white/30">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-white">{{ $user->name }}</h2>
                    <p class="text-blue-200 text-sm mt-0.5">{{ $user->email }}</p>
                    <span class="mt-2 inline-block text-xs font-semibold bg-white/20 text-white px-2.5 py-0.5 rounded-full">
                        {{ $user->role->label() }}
                    </span>
                </div>
            </div>

            <div class="p-8 grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1">Nome completo</p>
                    <p class="text-slate-800 font-medium">{{ $user->name }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1">E-mail</p>
                    <p class="text-slate-800 font-medium">{{ $user->email }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1">Latitude</p>
                    <p class="text-slate-800 font-medium">{{ $user->latitude ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1">Longitude</p>
                    <p class="text-slate-800 font-medium">{{ $user->longitude ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1">Membro desde</p>
                    <p class="text-slate-800 font-medium">{{ $user->created_at->format('d/m/Y') }}</p>
                </div>
            </div>

            @if ($user->latitude && $user->longitude)
                <div class="px-8 pb-8">
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <div class="w-full h-64 bg-slate-100 rounded-lg overflow-hidden border border-slate-200">
                            <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0"
                                marginwidth="0"
                                src="https://maps.google.com/maps?q={{ $user->latitude }},{{ $user->longitude }}&z=15&output=embed"></iframe>
                        </div>
                    </div>
                </div>
            @endif
        </x-card>

        @if ($user->role === \App\Enums\RolesEnum::PROFESSIONAL && $user->professionalProfile)
            <x-card>
                <x-slot:header>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-semibold text-slate-900">Dados Profissionais</h3>
                    </div>
                </x-slot:header>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1">Categoria</p>
                        <p class="text-slate-800 font-medium">
                            {{ $user->professionalProfile->serviceCategory->name ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1">Preço Base</p>
                        <p class="text-slate-800 font-medium">R$
                            {{ number_format($user->professionalProfile->hourly_price, 2, ',', '.') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1">Experiência</p>
                        <p class="text-slate-800 font-medium">{{ $user->professionalProfile->experience_years }}
                            {{ $user->professionalProfile->experience_years == 1 ? 'ano' : 'anos' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1">Tempo de Resposta</p>
                        <p class="text-slate-800 font-medium">{{ $user->professionalProfile->response_time }}
                            {{ $user->professionalProfile->response_time == 1 ? 'minuto' : 'minutos' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1">Avaliações</p>
                        @if ($user->professionalProfile->reviews_count > 0)
                            <p class="text-slate-800 font-medium">
                                {{ $user->professionalProfile->reviews_count }}
                                {{ $user->professionalProfile->reviews_count == 1 ? 'avaliação' : 'avaliações' }}
                            </p>
                        @else
                            <p class="text-slate-400 text-sm">Nenhuma avaliação ainda</p>
                        @endif
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1">Média de Notas</p>
                        @if ($user->professionalProfile->average_rating !== null)
                            <div class="flex items-center gap-2">
                                <span
                                    class="text-slate-800 font-semibold text-lg">{{ number_format($user->professionalProfile->average_rating, 1, ',', '') }}</span>
                                <div class="flex items-center gap-0.5">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= round($user->professionalProfile->average_rating))
                                            <svg class="w-4 h-4 text-amber-400" viewBox="0 0 24 24" fill="currentColor">
                                                <path
                                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 text-slate-200" viewBox="0 0 24 24" fill="currentColor">
                                                <path
                                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        @else
                            <p class="text-slate-400 text-sm">—</p>
                        @endif
                    </div>
                </div>
            </x-card>
        @elseif($user->role === \App\Enums\RolesEnum::CLIENT)
            <x-alert-info title="Você ainda não divulga serviços"
                message='Clique em "Quero divulgar meus serviços" no topo da página para se cadastrar como profissional e aparecer nas recomendações TOPSIS.' />
        @endif

    </div>
@endsection
