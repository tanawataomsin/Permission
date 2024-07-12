@extends('layouts.app')

@section('title', 'Home Product')

@section('contents')

    <div class="d-flex align-items-center justify-content-between">
        @can('createProduct')
            <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
        @endcan

        @can('importProduct')
            <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data" style="display: inline;">
                @csrf
                <input type="file" name="file" required>
                <button type="submit" class="btn btn-info">Import from Excel</button>
            </form>
        @endcan
    </div>
    <hr />
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}


        </div>
    @endif
    <div>
        <form class="form-inline my-2 my-lg-0" method="GET" action="{{ route('products.index') }}">
            <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search"
                value="{{ request('search') }}">
            <button class="btn btn-primary my-2 my-sm-0" type="submit">
                <i class="fas fa-search"></i>
            </button>
            <div class="ml-auto">
                @can('exportProduct')
                    <a href="{{ route('products.export') }}" class="btn btn-success">Export to Excel</a>
                @endcan
            </div>
        </form>

        </br>
    </div>

    <table class="table table-hover text-center">
        <thead class="table-primary">
            <tr>
                <th>No.</th>
                <th>Title</th>
                <th>Price</th>
                <th>Product Code</th>
                <th>Description</th>
                <th>Create by</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody>
            @if ($product->count() > 0)
                @foreach ($product as $rs)
                    <tr>
                        <td class="align-middle">{{ $rs->id }}</td>
                        <td class="align-middle">{{ $rs->title }}</td>
                        <td class="align-middle">{{ $rs->price }}</td>
                        <td class="align-middle">{{ $rs->product_code }}</td>
                        <td class="align-middle">{{ $rs->description ?: 'None' }}</td>
                        <td class="align-middle">{{ $rs->user ? $rs->user->name : 'Unknown' }}</td>

                        <td class="align-middle">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                @can('viewProduct')
                                    <a href="{{ route('products.show', $rs->id) }}" type="button" class="btn btn-secondary">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                            <path
                                                d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                                        </svg></a>
                                @endcan

                                @can('updateProduct')
                                    <a href="{{ route('products.edit', $rs->id) }}" type="button" class="btn btn-warning">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                            <path fill-rule="evenodd"
                                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                        </svg></a>
                                @endcan

                                @can('DeleteProduct')
                                    <button type="button" class="btn btn-danger" onclick="btndelete({{ $rs->id }})">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                        </svg>
                                    </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="7">Product not found</td>
                </tr>
            @endif
        </tbody>

    </table>
    {!! $product->links('pagination::bootstrap-5') !!}


    <!-- Include jQuery from CDN -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        function btndelete(id) {
            console.log(id)

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('products.destroy') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id
                        },
                        cache: false,
                        success: function(data) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Product has been deleted.",
                                icon: "success"
                            }).then((result) => {
                                location.reload();
                            })
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr);
                            Swal.fire({
                                title: "Error!",
                                text: "There was a problem deleting the product: " + xhr
                                    .responseJSON.message,
                                icon: "error"
                            }).then((result) => {
                                location.reload();
                            })
                        }
                    });
                }
            });
        }
    </script>
@endsection
