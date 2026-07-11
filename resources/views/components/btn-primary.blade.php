@props([
    'type' => 'submit',
    'href' => null,
])

@if($href)
    <a
        href="{{ $href }}"
        {{ $attributes->merge([
            'class' => 'inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg
                        bg-blue-600 text-white text-sm font-medium
                        hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-600/20
                        transition-all duration-150 cursor-pointer'
        ]) }}
    >
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        {{ $attributes->merge([
            'class' => 'inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg
                        bg-blue-600 text-white text-sm font-medium
                        hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-600/20
                        transition-all duration-150 cursor-pointer'
        ]) }}
    >
        {{ $slot }}
    </button>
@endif
