@props([
    'label',
    'name',
    'options' => [],
    'selected' => null,
    'required' => false,
    'hint' => null,
    'hint' => null,
    'placeholder' => 'Selecione uma opção...',
    'searchable' => false,
])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-slate-700 mb-1.5">
        {{ $label }}
        @if ($required)
            <span class="text-red-500 ml-0.5">*</span>
        @endif
    </label>

    @if ($searchable)
        <div class="relative" data-custom-select>
            <input type="hidden" name="{{ $name }}" id="{{ $name }}" value="{{ old($name, $selected) }}"
                {{ $required ? 'required' : '' }}>

            <input type="text"
                {{ $attributes->merge([
                    'class' => 'w-full px-4 py-2.5 pr-10 rounded-lg border border-slate-300 bg-slate-50
                                                focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20
                                                hover:bg-white transition-all text-slate-800 text-sm',
                ]) }}
                placeholder="{{ $placeholder }}" autocomplete="off" data-search-input>

            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </div>

            <div class="absolute z-40 w-full mt-1 bg-white border border-slate-200 rounded-lg shadow-lg hidden max-h-60 overflow-y-auto"
                data-dropdown>
                @foreach ($options as $option)
                    @php
                        if ($option instanceof \UnitEnum) {
                            $val = $option instanceof \BackedEnum ? $option->value : $option->name;
                            $lbl = method_exists($option, 'label') ? $option->label() : $option->name;
                        } else {
                            $val = is_array($option) ? $option['value'] : $option->id;
                            $lbl = is_array($option) ? $option['label'] : $option->name;
                        }
                    @endphp
                    <div class="px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition-colors cursor-pointer"
                        data-value="{{ $val }}" data-label="{{ $lbl }}">
                        {{ $lbl }}
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <select id="{{ $name }}" name="{{ $name }}" {{ $required ? 'required' : '' }}
            {{ $attributes->merge([
                'class' => 'w-full px-4 py-2.5 pr-10 rounded-lg border border-slate-300 bg-slate-50
                                        focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20
                                        hover:bg-white transition-all text-slate-800 text-sm appearance-none',
            ]) }}
            style="background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'%3E%3Cpolyline points=\'6 9 12 15 18 9\'%3E%3C/polyline%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 1rem center; background-size: 1em;">
            <option value="" disabled {{ old($name, $selected) === null ? 'selected' : '' }}>
                {{ $placeholder }}
            </option>

            @foreach ($options as $option)
                @php
                    if ($option instanceof \UnitEnum) {
                        $val = $option instanceof \BackedEnum ? $option->value : $option->name;
                        $lbl = method_exists($option, 'label') ? $option->label() : $option->name;
                    } else {
                        $val = is_array($option) ? $option['value'] : $option->id;
                        $lbl = is_array($option) ? $option['label'] : $option->name;
                    }
                @endphp
                <option value="{{ $val }}" {{ old($name, $selected) == $val ? 'selected' : '' }}>
                    {{ $lbl }}
                </option>
            @endforeach
        </select>
    @endif

    @if ($hint)
        <p class="mt-1 text-xs text-slate-500">{{ $hint }}</p>
    @endif

    @error($name)
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
