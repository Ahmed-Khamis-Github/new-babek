@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Orders')


@section('content')

    <h4>Orders</h4>
    <div class="card">
        <h5 class="card-header">Orders Table</h5>
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
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($orders as $order)
                            <tr>

                                <td>
                                    {{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}
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

                                @if ($order->order_status == 'Accepted')
                                    <td><span class="badge bg-label-success me-1">{{ $order->order_status }}</span></td>
                                @else
                                    <td><span class="badge bg-label-primary me-1">{{ $order->order_status }}</span></td>
                                @endif


                                <td>
                                    {{ \Carbon\Carbon::parse($order->created_at)->format('Y-m-d') }}
                                </td>



                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('orders.edit', $order->id) }}">
                                                <i class="ti ti-pencil me-1"></i>
                                                Edit
                                            </a>

                                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST"
                                                class="d-inline" id="deleteForm">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="dropdown-item" onclick="confirmDelete()">
                                                    <i class="ti ti-trash me-1"></i>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- SweetAlert script -->
                                    <script>
                                        function confirmDelete() {
                                            Swal.fire({
                                                title: 'Are you sure?',
                                                text: 'You want to delete this order!',
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#d33',
                                                cancelButtonColor: '#3085d6',
                                                confirmButtonText: 'Yes, delete it!'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    document.getElementById('deleteForm').submit();
                                                }
                                            });
                                        }
                                    </script>
                                </td>
                            </tr>
                        @endforeach




                    </tbody>

                </table>

            </div>

        </div>
        {{ $orders->links() }}

    </div>


@endsection
