@props([
    'label',
    'name',
    'value' => '0',
    'min' => '0',
    'max' => '1',
    'step' => '0.01',
    'required' => false,
    'hint' => null,
])

<div>
    <div class="flex items-center justify-between mb-1.5">
        <label for="{{ $name }}" class="block text-sm font-medium text-slate-700">
            {{ $label }}
            @if($required)
                <span class="text-red-500 ml-0.5">*</span>
            @endif
        </label>
        <output
            id="{{ $name }}-output"
            class="text-sm font-semibold text-blue-600 tabular-nums min-w-[3rem] text-right"
        >{{ old($name, $value) }}</output>
    </div>

    <input
        id="{{ $name }}"
        type="range"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        min="{{ $min }}"
        max="{{ $max }}"
        step="{{ $step }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge([
            'class' => 'w-full h-2 rounded-lg appearance-none cursor-pointer
                        bg-slate-200 accent-blue-600'
        ]) }}
    />

    <div class="flex justify-between text-[10px] text-slate-400 mt-1 select-none">
        <span>{{ $min }}</span>
        <span>{{ $max }}</span>
    </div>

    @if($hint)
        <p class="mt-1 text-xs text-slate-500">{{ $hint }}</p>
    @endif

    @error($name)
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
