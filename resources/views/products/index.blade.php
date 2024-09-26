@extends('layouts.app')

@section('content')
    <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="product-list">
            @foreach ($products as $product)
                <tr id="product-{{ $product->id }}">
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->price }}</td>
                    <td>
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="50">
                        @else
                            No image
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Edit</a>
                        <button class="btn btn-danger" onclick="deleteProduct({{ $product->id }})">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        function deleteProduct(productId) {
            if (confirm('Are you sure?')) {
                fetch(`/products/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(response => response.json())
                  .then(data => {
                      if (data.success) {
                          document.getElementById(`product-${productId}`).remove();
                      } else {
                          alert('Something went wrong');
                      }
                  });
            }
        }
    </script>
@endsection
