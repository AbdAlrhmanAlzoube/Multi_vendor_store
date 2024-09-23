<div class="form-group">
    <x-form.input label="Role Name" name="name" class="form-control-lg" role="input"></x-form.input>
</div>

<fieldset>
    <legend>
        {{ __('Abilities') }}

        @foreach (app('ability') as  $ability_name )
            <div class="row mb-2">
                <div class="col-md-6">
                    {{ is_collable($ability_name)? $ability_name() : $ability_name }}
                </div>
                <div class="col-md-2">
                    <input type="radio" name="abilities[{{ $ability_name }}]" value="allow" 
                   @checked(($role_abilities[$ability_name]?? '' ) == 'allow') >Allow 
                </div>
                <div class="col-md-2">
                    <input type="radio" name="abilities[{{ $ability_name }}]" value="deny" 
                     @checked(($role_abilities[$ability_name]?? '' ) == 'deny') >Deny
                </div>
                <div class="col-md-2">
                    <input type="radio" name="abilities[{{ $ability_name }}]" value="inherit"
                    @checked(($role_abilities[$ability_name]?? '' ) == 'inherit')>Inherit
                </div>
            </div>
        @endforeach
    </legend>
</fieldset>

<div>
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
</div>
