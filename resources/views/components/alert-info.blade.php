@props([
    'title',
    'message',
    'variant' => 'info',
])

@php
    $styles = [
        'info' => 'bg-blue-50 border-blue-200 text-blue-900',
        'success' => 'bg-green-50 border-green-200 text-green-900',
        'warning' => 'bg-amber-50 border-amber-200 text-amber-900',
        'danger' => 'bg-red-50 border-red-200 text-red-900',
    ];
    $iconStyles = [
        'info' => 'bg-blue-100 text-blue-600',
        'success' => 'bg-green-100 text-green-600',
        'warning' => 'bg-amber-100 text-amber-600',
        'danger' => 'bg-red-100 text-red-600',
    ];
@endphp

<div class="border rounded-xl p-5 flex items-start gap-4 {{ $styles[$variant] }}">
    <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0 {{ $iconStyles[$variant] }}">
        {{ $icon ?? '' }}
        @unless(isset($icon))
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
            </svg>
        @endunless
    </div>
    <div>
        @if($title)
            <p class="text-sm font-semibold mb-0.5">{{ $title }}</p>
        @endif
        <p class="text-sm opacity-80">{{ $message }}</p>
    </div>
</div>
