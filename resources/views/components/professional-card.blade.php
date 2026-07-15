@props(['professional'])

<x-card padding="p-6">
    <div class="flex items-center gap-4 mb-6">
        <div
            class="w-14 h-14 bg-blue-100 text-blue-700 rounded-full flex items-center justify-center font-bold text-xl shrink-0">
            {{ strtoupper(substr($professional->user->name, 0, 1)) }}
        </div>
        <div>
            <h3 class="text-lg font-bold text-slate-900 leading-tight">{{ $professional->user->name }}</h3>
            <p class="text-blue-600 font-medium text-sm">{{ $professional->serviceCategory->name }}</p>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row gap-6">
        <div class="flex-1 grid grid-cols-2 gap-y-4 gap-x-2 text-sm text-slate-600">
            <div>
                <span class="block text-slate-500 text-xs font-medium mb-0.5">Valor/Hora</span>
                <span class="font-semibold text-slate-800">R$
                    {{ number_format($professional->hourly_price, 2, ',', '.') }}</span>
            </div>
            <div>
                <span class="block text-slate-500 text-xs font-medium mb-0.5">Taxa de Aceite</span>
                <span class="font-semibold text-slate-800">{{ $professional->acceptance_rate }}%</span>
            </div>
            <div>
                <span class="block text-slate-500 text-xs font-medium mb-0.5">Experiência</span>
                <span class="font-semibold text-slate-800">{{ $professional->experience_years }} anos</span>
            </div>
            <div>
                <span class="block text-slate-500 text-xs font-medium mb-0.5">Tempo Resposta</span>
                <span class="font-semibold text-slate-800">{{ $professional->response_time }} min</span>
            </div>
        </div>

        <div class="sm:border-l sm:border-slate-100 sm:pl-6 flex flex-col items-center justify-center shrink-0">
            <span
                class="font-bold text-slate-800 text-3xl mb-1">{{ $professional->average_rating ? number_format($professional->average_rating, 1) : 'S/A' }}</span>
            <span class="text-slate-400 text-xs">({{ $professional->reviews_count }} avaliações)</span>
        </div>
    </div>
</x-card>
