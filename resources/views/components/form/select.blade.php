<!-- resources/views/components/form/select.blade.php -->

@props([
    'name' => '',          // The name attribute for the select element
    'options' => [],       // The options to display in the select (array)
    'selected' => null,    // The selected option (if any)
    'placeholder' => null, // Optional placeholder option
])

<div>
    <select name="{{ $name }}" {{ $attributes->merge(['class' => 'form-select']) }}>
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif

        @foreach($options as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>

    @error($name)
        <div class="text-red-600 text-sm">{{ $message }}</div>
    @enderror
</div>
