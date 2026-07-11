@props([
    'padding' => 'p-8',
])

<div {{ $attributes->merge(['class' => 'bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden']) }}>
    @isset($header)
        <div class="px-8 py-5 border-b border-slate-100">
            {{ $header }}
        </div>
    @endisset

    <div class="{{ $padding }}">
        {{ $slot }}
    </div>
</div>
