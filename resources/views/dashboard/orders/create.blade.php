@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Create Order')

@section('content')
    <form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h4>Create Order</h4>

        <div class="col-12 col-lg-8">
            <!-- Product Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-tile mb-0">Order Information</h5>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="ecommerce-product-name">Company Name</label>
                        <select id="defaultSelect" class="form-select" name="company_id" >
                            <option>Select Company Name</option>

                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}"> {{ $company->name }}</option>
                            @endforeach

                        </select>
                        @error('company_id')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="ecommerce-product-name">Seller Name</label>
                        <input type="text" class="form-control" id="ecommerce-product-name" placeholder="Seller Name"
                            name="seller_name" aria-label="Product title" value="{{ old('seller_name') }}" required />
                        @error('seller_name')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="ecommerce-product-name">Location</label>
                        <input type="text" class="form-control" id="ecommerce-product-name" placeholder="Location"
                            name="location" aria-label="Product title" value="{{ old('location') }}" required />
                        @error('location')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="ecommerce-product-name">Customer Name</label>
                        <input type="text" class="form-control" id="ecommerce-product-name" placeholder="Customer Name"
                            name="customer_name" aria-label="Product title" value="{{ old('customer_name') }}" required />
                        @error('customer_name')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="ecommerce-product-name">Destination</label>
                        <input type="text" class="form-control" id="ecommerce-product-name" placeholder="Destination"
                            name="destination" aria-label="Product title" value="{{ old('destination') }}" required />
                        @error('destination')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="ecommerce-product-name">Notes</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Notes"></textarea>
                        @error('customer_notes')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="ecommerce-product-name">Attachments</label>
                        <input type="file" name="attachment" class="form-control" id="inputGroupFile01" />
                        @error('attachments')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>


                    <!-- Description -->

                </div>
                <button type="submit" class="btn btn-primary mb-2">
                    <span class="ti-xs ti ti-plus me-1"></span>Add New Order
                </button>
            </div>

        </div>
    </form>

@endsection
