@extends('layouts.app')

@section('title', 'Detalhes do Usuário')
@section('page_heading', 'Detalhes do Usuário')

@section('topbar_actions')
    <x-btn-secondary href="{{ route('users.index') }}">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
        </svg>
        Voltar para Lista
    </x-btn-secondary>
@endsection

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <x-card>
            <x-slot:header>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-slate-900">Informações Pessoais</h3>
                        <p class="text-xs text-slate-500">Dados principais do usuário</p>
                    </div>
                </div>
            </x-slot:header>

            <div class="space-y-4">
                <div>
                    <span class="block text-xs font-medium text-slate-500 uppercase tracking-wider">Nome</span>
                    <span class="block mt-1 text-sm font-medium text-slate-900">{{ $user->name }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-500 uppercase tracking-wider">Email</span>
                    <span class="block mt-1 text-sm text-slate-700">{{ $user->email }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-500 uppercase tracking-wider">Papel</span>
                    <span class="block mt-1">
                        <span
                            class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                            {{ $user->role?->label() ?? $user->role }}
                        </span>
                    </span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-500 uppercase tracking-wider">Data de Cadastro</span>
                    <span class="block mt-1 text-sm text-slate-700">{{ $user->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </x-card>

        <x-card>
            <x-slot:header>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-slate-900">Localização</h3>
                        <p class="text-xs text-slate-500">Coordenadas geográficas</p>
                    </div>
                </div>
            </x-slot:header>

            <div class="space-y-4">
                <div>
                    <span class="block text-xs font-medium text-slate-500 uppercase tracking-wider">Latitude</span>
                    <span
                        class="block mt-1 text-sm font-medium text-slate-900">{{ $user->latitude ?? 'Não informada' }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-500 uppercase tracking-wider">Longitude</span>
                    <span
                        class="block mt-1 text-sm font-medium text-slate-900">{{ $user->longitude ?? 'Não informada' }}</span>
                </div>

                @if ($user->latitude && $user->longitude)
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <div class="w-full h-64 bg-slate-100 rounded-lg overflow-hidden border border-slate-200">
                            <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0"
                                marginwidth="0"
                                src="https://maps.google.com/maps?q={{ $user->latitude }},{{ $user->longitude }}&z=15&output=embed"></iframe>
                        </div>
                    </div>
                @endif
            </div>
        </x-card>
    </div>

    @if ($user->role === \App\Enums\RolesEnum::PROFESSIONAL && $user->professionalProfile)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
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
                        <div>
                            <h3 class="text-base font-semibold text-slate-900">Dados Profissionais</h3>
                            <p class="text-xs text-slate-500">Informações do perfil profissional</p>
                        </div>
                    </div>
                </x-slot:header>

                <div class="space-y-4">
                    <div>
                        <span class="block text-xs font-medium text-slate-500 uppercase tracking-wider">Categoria</span>
                        <span class="block mt-1 text-sm font-medium text-slate-900">
                            {{ $profile->serviceCategory->name ?? '—' }}
                        </span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-500 uppercase tracking-wider">Preço Base</span>
                        <span class="block mt-1 text-sm font-medium text-slate-900">
                            R$ {{ number_format($profile->hourly_price, 2, ',', '.') }}
                        </span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-500 uppercase tracking-wider">Experiência</span>
                        <span class="block mt-1 text-sm font-medium text-slate-900">
                            {{ $profile->experience_years }} {{ $profile->experience_years == 1 ? 'ano' : 'anos' }}
                        </span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-500 uppercase tracking-wider">Tempo de
                            Resposta</span>
                        <span class="block mt-1 text-sm font-medium text-slate-900">
                            {{ $profile->response_time }}
                            {{ $profile->response_time == 1 ? 'hora' : 'horas' }}
                        </span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-500 uppercase tracking-wider">Taxa de
                            Aceitação</span>
                        <span class="block mt-1 text-sm font-medium text-slate-900">
                            {{ number_format($profile->acceptance_rate, 1, ',', '') }}%
                        </span>
                    </div>
                </div>
            </x-card>

            <x-card>
                <x-slot:header>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-amber-500" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-slate-900">Avaliações</h3>
                            <p class="text-xs text-slate-500">Notas recebidas de clientes</p>
                        </div>
                    </div>
                </x-slot:header>

                <div class="space-y-6">
                    <div class="flex flex-col items-center justify-center py-4 bg-slate-50 rounded-xl">
                        @if ($averageRating !== null)
                            <span
                                class="text-5xl font-bold text-slate-800">{{ number_format($averageRating, 1, ',', '') }}</span>
                            <div class="flex items-center gap-1 mt-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= round($averageRating))
                                        <svg class="w-5 h-5 text-amber-400" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-slate-200" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="mt-1 text-xs text-slate-500">
                                {{ $reviewsCount }} {{ $reviewsCount == 1 ? 'avaliação' : 'avaliações' }}
                            </span>
                        @else
                            <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                            </svg>
                            <p class="text-sm text-slate-400">Nenhuma avaliação ainda</p>
                        @endif
                    </div>

                    @if ($reviewsCount > 0)
                        <div class="space-y-2">
                            @for ($star = 5; $star >= 1; $star--)
                                @php
                                    $count = $profile->reviews->where('rating', $star)->count();
                                    $pct = $reviewsCount > 0 ? round(($count / $reviewsCount) * 100) : 0;
                                @endphp
                                <div class="flex items-center gap-2 text-xs">
                                    <span class="w-4 text-right text-slate-600 font-medium">{{ $star }}</span>
                                    <svg class="w-3.5 h-3.5 text-amber-400 shrink-0" viewBox="0 0 24 24"
                                        fill="currentColor">
                                        <path
                                            d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                    </svg>
                                    <div class="flex-1 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                        <div class="bg-amber-400 h-full rounded-full transition-all"
                                            style="width: {{ $pct }}%"></div>
                                    </div>
                                    <span class="w-8 text-slate-500">{{ $count }}</span>
                                </div>
                            @endfor
                        </div>
                    @endif
                </div>
            </x-card>
        </div>
    @endif
@endsection
