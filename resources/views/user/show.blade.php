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

                @if($user->latitude && $user->longitude)
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <div class="w-full h-64 bg-slate-100 rounded-lg overflow-hidden border border-slate-200">
                            <iframe 
                                width="100%" 
                                height="100%" 
                                frameborder="0" 
                                scrolling="no" 
                                marginheight="0" 
                                marginwidth="0" 
                                src="https://maps.google.com/maps?q={{ $user->latitude }},{{ $user->longitude }}&z=15&output=embed"
                            ></iframe>
                        </div>
                    </div>
                @endif
            </div>
        </x-card>
    </div>
@endsection