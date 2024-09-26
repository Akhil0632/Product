@extends('layouts.app')

@section('content')
    <form id="productForm" enctype="multipart/form-data">
        @csrf
        @isset($product)
            @method('PUT')
        @endisset

        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="category">Category</label>
            <select name="category_id" class="form-control" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ (isset($product) && $product->category_id == $category->id) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="text" name="price" class="form-control" value="{{ old('price', $product->price ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="image">Product Image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Save</button>
    </form>

    <script>
        document.getElementById('productForm').addEventListener('submit', function(event) {
            event.preventDefault();

            let formData = new FormData(this);
            let method = '{{ isset($product) ? 'PUT' : 'POST' }}';
            let url = '{{ isset($product) ? route('products.update', $product) : route('products.store') }}';

            fetch(url, {
                method: method,
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '{{ route('products.index') }}';
                } else {
                    alert('Error: ' + data.error);
                }
            });
        });
    </script>
@endsection
