@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="form-group">
    <x-form.input label="Category Name" name="name" :value="$category->name" class="form-control-lg" role="input"  ></x-form.input>
</div>
<div class="form-group">
    <label>Category Parent</label>
    <select name="parent_id" class="form-control form-select">
        <option value="">Primary Category</option>
        @foreach ($parents as $parent)
            <option value="{{ $parent->id }}" @selected((old('parent_id',$category->parent_id))==$parent->id)>{{ $parent->name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <x-form.textarea  label="Description" name="description" :value="$category->description"  ></x-form.textarea>
</div>
<div class="form-group">
    <x-form.label for="image">Image</x-form.label>
    <x-form.input type="file" name="image" accept="image/*" ></x-form.input>
    @if ($category->image)
    <img src="{{asset('storage/'.$category->image)}}" alt="" height="50">
    @endif
</div>
<div class="form-group">
    <x-form.label  for="status">Status</x-form.label>
  <x-form.radio name="status" :checked="$category->status" :option="['active'=>'Active','archived'=>'Archived']" ></x-form.radio>
   
</div>
<div>
    <button type="submit" class="btn btn-primary" >{{ $button_label ??  'Save'}}</button>
</div>