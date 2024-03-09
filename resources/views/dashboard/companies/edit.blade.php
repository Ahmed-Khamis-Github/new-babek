@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Edit Company')

@section('content')
    <form action="{{ route('companies.update', $company->id) }}" method="POST">
        @csrf
        @method('PUT')

        <h4>Edit Company</h4>

        <div class="col-12 col-lg-8">
            <!-- Product Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-tile mb-0">Company Information</h5>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="ecommerce-product-name">Unique ID </label>
                        <input type="text" class="form-control" id="ecommerce-product-name" placeholder="Company Name"
                            name="unique_id" aria-label="Product title" required
                            value="{{ old('unique_code', $company->unique_id) }}" />
                        @error('unique_id')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="ecommerce-product-name">Name</label>
                        <input type="text" class="form-control" id="ecommerce-product-name" placeholder="Company Name"
                            name="name" aria-label="Product title" required value="{{ old('name', $company->name) }}" />
                        @error('name')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="ecommerce-product-name">Email</label>
                        <input type="email" class="form-control" id="ecommerce-product-name" placeholder="Company Email"
                            name="email" aria-label="Company Email" value="{{ old('email', $company->email) }}"
                            required />
                        @error('email')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->

                </div>
                <button type="submit" class="btn btn-primary mb-2">
                    <span class="ti-xs ti ti-plus me-1"></span>Update Company
                </button>
            </div>

        </div>
    </form>

@endsection
