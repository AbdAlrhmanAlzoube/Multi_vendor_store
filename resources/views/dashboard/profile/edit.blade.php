@extends('layuots.dashboard')

@section('title', 'Profile')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Edit Profile</li>
@endsection

@section('content')
<form action="{{ route('dashboard.profile.update') }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('patch')
    <x-alert type="success" />

    <div class="form-row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input 
                    type="text" 
                    name="first_name" 
                    id="first_name" 
                    class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}" 
                    value="{{ old('first_name', $user->profile->first_name) }}"
                >
                @error('first_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input 
                    type="text" 
                    name="last_name" 
                    id="last_name" 
                    class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" 
                    value="{{ old('last_name', $user->profile->last_name) }}"
                >
                @error('last_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="birth_day">Birth Day</label>
                <input 
                    type="date" 
                    name="birth_day" 
                    id="birth_day" 
                    class="form-control {{ $errors->has('birth_day') ? 'is-invalid' : '' }}" 
                    value="{{ old('birth_day', $user->profile->birth_day) }}"
                >
                @error('birth_day')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Gender</label>
                @foreach(['male' => 'Male', 'female' => 'Female'] as $value => $display)
                    <div class="form-check">
                        <input 
                            type="radio" 
                            name="gender" 
                            id="gender_{{ $value }}" 
                            value="{{ $value }}" 
                            class="form-check-input {{ $errors->has('gender') ? 'is-invalid' : '' }}" 
                            {{ old('gender', $user->profile->gender) == $value ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="gender_{{ $value }}">
                            {{ $display }}
                        </label>
                    </div>
                @endforeach
                @error('gender')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="city">City</label>
                <input 
                    type="text" 
                    name="city" 
                    id="city" 
                    class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" 
                    value="{{ old('city', $user->profile->city) }}"
                >
                @error('city')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="state">State</label>
                <input 
                    type="text" 
                    name="state" 
                    id="state" 
                    class="form-control {{ $errors->has('state') ? 'is-invalid' : '' }}" 
                    value="{{ old('state', $user->profile->state) }}"
                >
                @error('state')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="form-group">
                <label for="street_address">Street Address</label>
                <input 
                    type="text" 
                    name="street_address" 
                    id="street_address" 
                    class="form-control {{ $errors->has('street_address') ? 'is-invalid' : '' }}" 
                    value="{{ old('street_address', $user->profile->street_address) }}"
                >
                @error('street_address')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>

    

    <div class="form-row">

        <div class="col-md-4">
            <div class="form-group">
                <label for="postal_code">Postal Code</label>
                <input 
                    type="text" 
                    name="postal_code" 
                    id="postal_code" 
                    class="form-control {{ $errors->has('postal_code') ? 'is-invalid' : '' }}" 
                    value="{{ old('postal_code', $user->profile->postal_code) }}"
                >
                @error('postal_code')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="country">Country</label>
                <select 
                    name="country" 
                    id="country" 
                    class="form-control {{ $errors->has('country') ? 'is-invalid' : '' }}">
                    <option value="">Select an option</option>
                    @foreach ($countries as $value => $display)
                        <option value="{{ $value }}" {{ old('country', $user->profile->country) == $value ? 'selected' : '' }}>
                            {{ $display }}
                        </option>
                    @endforeach
                </select>
                @error('country')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="locale">Locale</label>
                <select 
                    name="locale" 
                    id="locale" 
                    class="form-control {{ $errors->has('locale') ? 'is-invalid' : '' }}">
                    <option value="">Select an option</option>
                    @foreach ($locales as $value => $display)
                        <option value="{{ $value }}" {{ old('locale', $user->profile->locale) == $value ? 'selected' : '' }}>
                            {{ $display }}
                        </option>
                    @endforeach
                </select>
                @error('locale')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
    </div>

</form>
@endsection
