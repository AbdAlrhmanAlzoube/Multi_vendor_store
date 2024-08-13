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
    <x-form.input label="Product Name" name="name" :value="$product->name" class="form-control-lg" role="input"></x-form.input>
</div>

<div class="form-group">
    <label>Category Parent</label>
    <select name="category_id" class="form-control form-select">
        <option value="">Primary Category</option>
        @foreach (App\Models\Category::all() as $category)
            <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <x-form.textarea label="Description" name="description" :value="$product->description"></x-form.textarea>
</div>

<div class="form-group">
    <x-form.label for="image">Image</x-form.label>
    <x-form.input type="file" name="image" accept="image/*"></x-form.input>
    @if ($product->image)
        <img src="{{ asset('storage/' . $product->image) }}" alt="" height="50">
    @endif
</div>

<div class="form-group">
    <x-form.input label="Price" name="price" type="number" step="0.01" :value="$product->price"></x-form.input>
</div>

<div class="form-group">
    <x-form.input label="Compare Price" name="compare_price" type="number" step="0.01" :value="$product->compare_price"></x-form.input>
</div>

{{-- <div class="form-group">
    <x-form.textarea label="Options (JSON format)" name="option" :value="$product->option"></x-form.textarea>
</div>

<div class="form-group">
    <x-form.input label="Rating" name="rating" type="number" step="0.1" :value="$product->rating"></x-form.input>
</div> --}}

<div class="form-group">
    <x-form.input label="Tags" name="tags" :value="$tags"></x-form.input>
</div>


<div class="form-group">
    <x-form.label for="status">Status</x-form.label>
    <x-form.radio name="status" :checked="$product->status" :option="['active' => 'Active', 'draft' => 'Draft', 'archived' => 'Archived']"></x-form.radio>
</div>

<div>
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
</div>
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>

 <script>
      var inputElm = document.querySelector('[name=tags]'),
      tagify = new Tagify (inputElm);
    </script>
@endpush