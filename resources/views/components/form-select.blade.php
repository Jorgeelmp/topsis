@props([
    'label',
    'name',
    'options' => [],
    'selected' => null,
    'required' => false,
    'hint' => null,
    'placeholder' => 'Selecione uma opção...',
])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-slate-700 mb-1.5">
        {{ $label }}
        @if($required)
            <span class="text-red-500 ml-0.5">*</span>
        @endif
    </label>

    <select
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge([
            'class' => 'w-full px-4 py-2.5 rounded-lg border border-slate-300 bg-slate-50
                        focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20
                        hover:bg-white transition-all text-slate-800 text-sm'
        ]) }}
    >
        <option value="" disabled {{ old($name, $selected) === null ? 'selected' : '' }}>
            {{ $placeholder }}
        </option>

        @foreach($options as $option)
            @php
                $val = is_array($option) ? $option['value'] : $option->id;
                $lbl = is_array($option) ? $option['label'] : $option->name;
            @endphp
            <option value="{{ $val }}" {{ old($name, $selected) == $val ? 'selected' : '' }}>
                {{ $lbl }}
            </option>
        @endforeach
    </select>

    @if($hint)
        <p class="mt-1 text-xs text-slate-500">{{ $hint }}</p>
    @endif

    @error($name)
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
