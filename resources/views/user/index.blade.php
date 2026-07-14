@extends('layouts.app')

@section('title', 'Usuários')
@section('page_heading', 'Gestão de Usuários')

@section('content')
    <x-card>
        <x-slot:header>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-slate-900">Lista de Usuários</h3>
                        <p class="text-xs text-slate-500">{{ $users->total() }}
                            {{ $users->total() === 1 ? 'usuário cadastrado' : 'usuários cadastrados' }}
                        </p>
                    </div>
                </div>

                <form action="{{ route('users.index') }}" method="GET" class="w-full sm:w-64">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Buscar por nome ou email..."
                            class="w-full pl-9 pr-3 py-2 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </form>
            </div>
        </x-slot:header>

        @if($users->isEmpty())
            <x-alert-info title="Nenhum usuário encontrado"
                message="Não há usuários correspondentes à sua busca ou cadastrados no momento." />
        @else
            <div class="overflow-x-auto -mx-8 -mb-8">
                <table class="w-full text-xs sm:text-sm">
                    <thead class="hidden sm:table-header-group">
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-8 py-3 text-left text-xs font-semibold uppercase tracking-widest text-slate-400">ID
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-widest text-slate-400">Nome
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-widest text-slate-400">Email
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-widest text-slate-400">Papel
                            </th>
                            <th class="px-8 py-3 text-right text-xs font-semibold uppercase tracking-widest text-slate-400">
                                Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 flex flex-col sm:table-row-group">
                        @foreach($users as $user)
                            <tr
                                class="hover:bg-slate-50 transition-colors flex flex-col sm:table-row p-4 sm:p-0 border-b border-slate-100 sm:border-0 relative">
                                <td
                                    class="px-4 sm:px-8 py-2 sm:py-4 text-slate-400 tabular-nums flex sm:table-cell justify-between items-center before:content-['ID'] before:sm:hidden before:font-semibold before:text-slate-500">
                                    {{ $user->id }}
                                </td>
                                <td
                                    class="px-4 py-2 sm:py-4 font-medium text-slate-800 flex sm:table-cell justify-between items-center before:content-['Nome'] before:sm:hidden before:font-semibold before:text-slate-500">
                                    {{ $user->name }}
                                </td>
                                <td
                                    class="px-4 py-2 sm:py-4 text-slate-500 flex sm:table-cell justify-between items-center before:content-['Email'] before:sm:hidden before:font-semibold before:text-slate-500">
                                    {{ $user->email }}
                                </td>
                                <td
                                    class="px-4 py-2 sm:py-4 flex sm:table-cell justify-between items-center before:content-['Papel'] before:sm:hidden before:font-semibold before:text-slate-500">
                                    <span
                                        class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                        {{ $user->role?->label() ?? $user->role }}
                                    </span>
                                </td>
                                <td
                                    class="px-4 sm:px-8 py-4 sm:py-4 flex sm:table-cell justify-end sm:justify-end items-center mt-2 sm:mt-0 pt-4 sm:pt-4 border-t border-slate-100 sm:border-0">
                                    <x-btn-secondary href="{{ route('users.show', $user) }}">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Ver
                                    </x-btn-secondary>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="px-8 py-4 mt-8 border-t border-slate-200">
                    {{ $users->withQueryString()->links() }}
                </div>
            @endif
        @endif
    </x-card>
@endsection