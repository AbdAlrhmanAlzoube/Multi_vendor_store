@extends('layuots.dashboard')
 
@section('title','Roles')
@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Roles</li>
@endsection
@section('content')
<div class="mb-5">
    {{-- @if(Auth::user()->can('roles.create')) --}}
    <a href="{{ route('dashboard.roles.create') }}" class="btn btn-sm btn-outline-primary mr-2">Create</a>
        
    {{-- @endif --}}
    {{-- <a href="{{ route('dashboard.roles.trash') }}" class="btn btn-sm btn-outline-dark">Trash</a> --}}
</div>
<x-alert type="success" /> 
<x-alert type="info" /> 
<x-alert type="danger" /> 

{{-- <form action="{{ URL::Current() }}" method="get" class="d-flex fustify-content-between mb-4 ">
    <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')"></x-form.input>
    <select name="status" class="form-control mx-2">
        <option value="">All</option>
        <option value="active" @selected(request('status') == 'active')>Active</option>
        <option value="archived"@selected(request('status')=='archived')>Archived</option>
    </select>
    <button class="btn btn-dark mx-2" >Filter</button>
</form> --}}
{{-- //هلق بدي روح اربط مع الباك من خلال اني مرق الريكويست انا غي طؤيقتين --}}
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Created_at</th>
            <th colspan="2">Action</th>
        </tr>
    </thead>
    <tbody>
        
        @forelse ($roles as $role)
        <tr>
            <td>{{ $role->id }}</td>
            <td><a href="{{ route('dashboard.roles.show',$role->id) }}">{{ $role->name}}</a></td>
            <td>{{ $role->created_at }}</td>
            <td>
                @can('roles.update')
            <a href={{ route('dashboard.roles.edit' ,$role->id) }} class=" btn btn-sm btn-outline-success">Edit</a> 
                    
                @endcan
            </td>
            <td>
                @can('roles.delete')
                <form action={{ route('dashboard.roles.destroy' ,$role->id) }}  method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                  
                @endcan
                  
                    
                </form>
            </td>
        </tr>
        @empty
            <tr>
                <td colspan="4">No Roles Defined.</td>
            </tr>
       
        @endforelse
        
    </tbody>

</table>
{{ $roles->WithQueryString()->links() }}


@endsection
