@extends('layuots.dashboard')
 
@section('title','Categories')
@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Categories</li>
@endsection
@section('content')
<div class="mb-5">
    <a href="{{ route('dashboard.categories.create') }}" class="btn btn-sm btn-outline-primary">Create</a>
</div>
<x-alert type="success" /> 
<x-alert type="info" /> 
<x-alert type="danger" /> 

<form action="{{ URL::Current() }}" method="get" class="d-flex fustify-content-between mb-4 ">
    <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')"></x-form.input>
    <select name="status" class="form-control mx-2">
        <option value="">All</option>
        <option value="active" @selected(request('status') == 'active')>Active</option>
        <option value="archived"@selected(request('status')=='archived')>Archived</option>
    </select>
    <button class="btn btn-dark mx-2" >Filter</button>
</form>
{{-- //هلق بدي روح اربط مع الباك من خلال اني مرق الريكويست انا غي طؤيقتين --}}
<table class="table">
    <thead>
        <tr>
            <th>Image</th>
            <th>ID</th>
            <th>Name</th>
            <th>Parent</th>
            <th>Status</th>
            <th>Created_at</th>
            <th colspan="2">Action</th>
        </tr>
    </thead>
    <tbody>
        
        @forelse ($categories as $category)
        <tr>
            <td><img src="{{asset('storage/'.$category->image)}}" alt="" height="50"></td>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name}}</td>
            <td>{{ $category->parent_id }}</td>
            <td>{{ $category->status }}</td>
            <td>{{ $category->created_at }}</td>
            <td>
            <a href={{ route('dashboard.categories.edit' ,$category->id) }} class=" btn btn-sm btn-outline-success">Edit</a> 
            </td>
            <td>
                <form action={{ route('dashboard.categories.destroy' ,$category->id) }}  method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                  
                    
                </form>
            </td>
        </tr>
        @empty
            <tr>
                <td colspan="7">No Categories Defined.</td>
            </tr>
       
        @endforelse
        
    </tbody>

</table>
{{ $categories->WithQueryString()->links() }}

@endsection
