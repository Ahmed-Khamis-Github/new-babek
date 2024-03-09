@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Show Offers')

@section('content')
    <h4>Show Offers</h4>
    <div class="row g-4">

        @foreach ($offers as $offer)
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body text-center">

                        <div class="mx-auto my-3">
                            <img src="../../assets/img/avatars/3.png" alt="Avatar Image" class="rounded-circle w-px-100" />
                        </div>
                        <h4 class="mb-1 card-title">{{ $offer->name }}</h4>
                        <span class="pb-1">{{ $offer->unique_id }}</span>
                        <div class="d-flex align-items-center justify-content-center my-3 gap-2">

                            @if ($offer->pivot->chosen)
                                <a href="javascript:;"><span class="badge bg-label-primary">Selected</span></a>
                            @else
                                <a href="javascript:;"><span class="badge bg-label-warning">Not Selected</span></a>
                            @endif
                        </div>

                        <div class="d-flex align-items-center justify-content-around my-3 py-1">
                            <div>
                                <h4 class="mb-0">500m</h4>
                                <span>Away</span>
                            </div>
                            <div>
                                <h4 class="mb-0">@php

                                    // Count the number of orders the user has placed
                                    $numberOfOrders = $offer->orders()->count();
                                    echo $numberOfOrders;
                                @endphp</h4>
                                <span>In Hold</span>
                            </div>
                            <div>
                                <h4 class="mb-0">3</h4>
                                <span>Finished</span>
                            </div>
                        </div>



                        <form action="{{ route('offers.accept', ['offer' => $offer->id]) }}" method="POST">
                            @csrf
                            @method('PATCH') <!-- Use PATCH method for updating -->

                            <!-- Add hidden input fields for order_id and offer_id -->
                            <input type="hidden" name="order_id" value="{{ $order->id }}">

                            <div class="d-flex align-items-center justify-content-center">
                                @if ($chosenUserCount == 1)
                                    <button type="submit" class="btn btn-primary d-flex align-items-center me-3" disabled>
                                        <i class="ti-xs me-1 ti ti-user-check me-1"></i>Accept
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-primary d-flex align-items-center me-3">
                                        <i class="ti-xs me-1 ti ti-user-check me-1"></i>Accept
                                    </button>
                                @endif
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        @endforeach




    </div>

@endsection
