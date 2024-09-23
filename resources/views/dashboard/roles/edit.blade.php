@extends('layuots.dashboard')

@section('title', 'Roles')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Roles</li>
<li class="breadcrumb-item active">Edit Roles</li>
@endsection

@section('content')
<form action="{{ route('dashboard.roles.update' ,$role->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
   @include('dashboard.roles._form',[ 'button_label'=>'Update'])
</form>
@endsection
