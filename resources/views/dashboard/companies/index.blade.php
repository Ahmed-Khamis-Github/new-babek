@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Companys')


@section('content')

    <h4>Companys</h4>
    <div class="card">
        <h5 class="card-header">Companys Table</h5>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered table-hover">

                    <thead class="table-dark">
                        <tr>

                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>unique id</th>
                            <th>created at</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($companies as $company)
                            <tr>

                                <td>
                                    {{ ($companies->currentPage() - 1) * $companies->perPage() + $loop->iteration }}
                                </td>
                                <td>{{ $company->name }}</td>
                                <td>
                                    {{ $company->email }}
                                </td>

                                <td>
                                    {{ $company->unique_id }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($company->created_at)->format('Y-m-d') }}
                                </td>



                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('companies.edit', $company->id) }}">
                                                <i class="ti ti-pencil me-1"></i>
                                                Edit
                                            </a>
                                
                                            <form action="{{ route('companies.destroy', $company->id) }}" method="POST" class="d-inline" id="deleteForm">
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
                                                text: 'You want to delete this company!',
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
        {{ $companies->links() }}

    </div>


@endsection
