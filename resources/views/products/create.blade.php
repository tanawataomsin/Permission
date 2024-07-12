@extends('layouts.app')

@section('title', 'Create Product')

@section('contents')
    <h1 class="mb-0">Add Product</h1>
    <hr />
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <div class="col">
                <label><span class="text-danger">*</span> Title</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                    placeholder="Title" value="{{ old('title') }}">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col">
                <label><span class="text-danger">*</span> Price</label>
                <input type="text" name="price" class="form-control @error('price') is-invalid @enderror"
                    placeholder="Price" value="{{ old('price') }}">
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label><span class="text-danger">*</span> Product Code</label>
                <input type="text" name="product_code" class="form-control @error('product_code') is-invalid @enderror"
                    placeholder="Product Code" value="{{ old('product_code') }}">
                @error('product_code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col">
                <label>Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" name="description" placeholder="Description">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection
