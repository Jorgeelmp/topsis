@props([
    'label',
    'name',
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'hint' => null,
    'prefix' => null,
])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-slate-700 mb-1.5">
        {{ $label }}
        @if($required)
            <span class="text-red-500 ml-0.5">*</span>
        @endif
    </label>

    <div class="relative">
        @if($prefix)
            <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 font-medium text-sm select-none">
                {{ $prefix }}
            </span>
        @endif

        <input
            id="{{ $name }}"
            type="{{ $type }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge([
                'class' => 'w-full py-2.5 rounded-lg border border-slate-300 bg-slate-50
                            focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20
                            hover:bg-white transition-all text-slate-800 text-sm
                            ' . ($prefix ? 'pl-10 pr-4' : 'px-4')
            ]) }}
        />
    </div>

    @if($hint)
        <p class="mt-1 text-xs text-slate-500">{{ $hint }}</p>
    @endif

    @error($name)
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
