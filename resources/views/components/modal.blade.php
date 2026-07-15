@props(['id', 'title', 'width' => 'sm:max-w-lg'])

<div id="{{ $id }}" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog"
    aria-modal="true" data-modal>
    <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity opacity-0" data-modal-backdrop></div>

    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-xl transition-all sm:my-8 w-full {{ $width }} opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                data-modal-panel>
                <div class="bg-white px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-slate-900" id="modal-title">
                        {{ $title }}
                    </h3>
                    <button type="button" class="text-slate-400 hover:text-slate-500 transition-colors"
                        data-modal-close>
                        <span class="sr-only">Fechar</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="px-6 py-6">
                    {{ $slot }}
                </div>

                @isset($footer)
                    <div class="bg-slate-50 px-6 py-4 flex justify-end gap-3 border-t border-slate-100">
                        {{ $footer }}
                    </div>
                @endisset
            </div>
        </div>
    </div>
</div>
