@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Create Company')

@section('content')
    <form action="{{ route('companies.store') }}" method="POST">
        @csrf
        <h4>Create Company</h4>

        <div class="col-12 col-lg-8">
            <!-- Product Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-tile mb-0">Company Information</h5>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="ecommerce-product-name">Name</label>
                        <input type="text" class="form-control" id="ecommerce-product-name" placeholder="Company Name"
                            name="name" aria-label="Product title" value="{{ old('name') }}" required />
                        @error('name')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="ecommerce-product-name">Email</label>
                        <input type="email" class="form-control" id="ecommerce-product-name" placeholder="Company Email"
                            name="email" aria-label="Company Email" value="{{ old('email') }}" required />
                        @error('email')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label" for="ecommerce-product-sku">Password</label>
                            <input type="password" class="form-control" id="ecommerce-product-name" placeholder="Password"
                                name="password" aria-label="Password" required />
                            @error('password')
                                <div style="color: red; font-weight: bold"> {{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col">
                            <label class="form-label" for="ecommerce-product-barcode">Password Confirmation</label>
                            <input type="password" class="form-control" id="ecommerce-product-name"
                                placeholder="Password Confirmation" name="password_confirmation"
                                aria-label="Password Confirmation" required />
                            @error('password_confirmation')
                                <div style="color: red; font-weight: bold"> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- Description -->

                </div>
                <button type="submit" class="btn btn-primary mb-2">
                    <span class="ti-xs ti ti-plus me-1"></span>Add New Company
                </button>
            </div>

        </div>
    </form>

@endsection
