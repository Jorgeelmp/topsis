@extends('layouts.app')

@section('title', 'Meu Perfil')
@section('page_heading', 'Meu Perfil')

@section('topbar_actions')
    @if (auth()->user()->role === \App\Enums\RolesEnum::CLIENT)
        <a href="{{ route('professional.become') }}"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium shadow-sm hover:shadow-xl hover:bg-blue-700">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Quero divulgar meus serviços
        </a>
    @endif
@endsection

@section('content')
    <div class="max-w-5xl mx-auto space-y-6">

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="bg-blue-600 px-8 py-10 flex items-center gap-6">
                <div
                    class="w-20 h-20 rounded-full bg-white/20 flex items-center justify-center text-white font-bold text-3xl shrink-0 ring-4 ring-white/30">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-white">{{ $user->name }}</h2>
                    <p class="text-blue-200 text-sm mt-0.5">{{ $user->email }}</p>
                </div>
            </div>

            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
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
                    <p class="text-slate-800 font-medium">{{ $user->latitude ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1">Longitude</p>
                    <p class="text-slate-800 font-medium">{{ $user->longitude ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1">Membro desde</p>
                    <p class="text-slate-800 font-medium">{{ $user->created_at->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1">Perfil</p>
                    <p class="text-slate-800 font-medium capitalize">
                        {{ $user->role === \App\Enums\RolesEnum::PROFESSIONAL ? 'Profissional' : 'Cliente' }}</p>
                </div>
            </div>
        </div>

        @if ($user->role === \App\Enums\RolesEnum::PROFESSIONAL && $user->professionalProfile)
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-8 py-5 border-b border-slate-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-slate-900">Dados Profissionais</h3>
                </div>

                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1">Categoria</p>
                        <p class="text-slate-800 font-medium">{{ $user->professionalProfile->category }}</p>
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
                            {{ $user->professionalProfile->experience_years == 1 ? 'ano' : 'anos' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1">Tempo de Resposta</p>
                        <p class="text-slate-800 font-medium">{{ $user->professionalProfile->response_time_hours }}
                            {{ $user->professionalProfile->response_time_hours == 1 ? 'hora' : 'horas' }}</p>
                    </div>
                </div>
            </div>
        @elseif($user->role === \App\Enums\RolesEnum::CLIENT)
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 flex items-start gap-4">
                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-blue-900 mb-0.5">Você ainda não divulga serviços</p>
                    <p class="text-sm text-blue-700">Clique em <strong>"Quero divulgar meus serviços"</strong> no topo da
                        página para se cadastrar como profissional e aparecer nas recomendações TOPSIS.</p>
                </div>
            </div>
        @endif

    </div>
@endsection
