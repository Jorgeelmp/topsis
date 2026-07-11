@props([
    'href' => null,
    'type' => 'button',
])

@if($href)
    <a
        href="{{ $href }}"
        {{ $attributes->merge([
            'class' => 'inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg
                        text-slate-600 text-sm font-medium
                        hover:bg-slate-100 transition-colors duration-150 cursor-pointer'
        ]) }}
    >
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        {{ $attributes->merge([
            'class' => 'inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg
                        text-slate-600 text-sm font-medium
                        hover:bg-slate-100 transition-colors duration-150 cursor-pointer'
        ]) }}
    >
        {{ $slot }}
    </button>
@endif
