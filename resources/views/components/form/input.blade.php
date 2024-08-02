@props([
    'type'=>'text','name','value'=>'','label'=>false,
]) 
{{-- @props() بحط فبا شو متوقع بصلني  --}}
@if ($label)
<label for="">{{ $label }}</label>
    
@endif
<input 
    type="{{ $type ?? 'text'}}"
    name="{{ $name }}"
    {{ $attributes->class([
        'form-control',
        'is-invalid'=>$errors->has($name)
    ]) }} 
    {{-- $attributes شغلتها تضمن اي متحول ببعنو حتى لو ماني معرفو --}}
 {{-- @class([
    'form-control',
    'is-invalid'=>$errors->has( $name)
]) --}}
value="{{ old($name,$value) }}">

@error($name)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror