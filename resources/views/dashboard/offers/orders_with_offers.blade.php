@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Offers')

@section('content')
    <h4>Offers</h4>

    <div class="card">
        <h5 class="card-header">Offers Table</h5>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered table-hover">

                    <thead class="table-dark">
                        <tr>

                            <th>#</th>
                            <th>Seller Name</th>
                            <th>Location</th>
                            <th>Customer Name</th>
                            <th>Destination</th>
                            <th>Number Of Offers</th>
                            <th>Show Offers</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($ordersWithOffers as $order)
                            <tr>

                                <td>
                                    {{ ($ordersWithOffers->currentPage() - 1) * $ordersWithOffers->perPage() + $loop->iteration }}
                                </td>
                                <td>{{ $order->seller_name }}</td>
                                <td>
                                    {{ $order->location }}
                                </td>

                                <td>
                                    {{ $order->customer_name }}
                                </td>
                                <td>
                                    {{ $order->destination }}
                                </td>
                                <td class="text-center">
                                    <span class="">@php

                                        $orderCount = \App\Models\OrderUser::where('order_id', $order->id)->count();
                                        echo $orderCount;

                                    @endphp</span>
                                </td>







                                <td>
                                    <a c class="btn btn-primary"
                                        href="{{ route('offers.show_for_order', ['order' => $order->id]) }}">
                                        Order {{ $order->id }}
                                    </a>

                                </td>
                            </tr>
                        @endforeach




                    </tbody>

                </table>

            </div>

        </div>
        {{ $ordersWithOffers->links() }}

    </div>

@endsection
