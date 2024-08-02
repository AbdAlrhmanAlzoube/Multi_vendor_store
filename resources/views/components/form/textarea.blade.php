@props([
   'name','value','label'=>false,
]) 
{{-- @props() بحط فبا شو متوقع بصلني  --}}
@if ($label)
<label for="">{{ $label }}</label>
    
@endif
<textarea 
    name="{{ $name }}"
    {{ $attributes->class([
        'form-control',
        'is-invalid'=>$errors->has($name)
    ]) 
    }} 
    value="{{ old($name,$value) }}">
</textarea>

@error($name)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror