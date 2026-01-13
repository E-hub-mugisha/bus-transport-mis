@extends('layouts.app')
@section('title','Route Management')
@section('content')

<div class="container mt-4">
    <h3>Route Management</h3>

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createRouteModal">
        Add New Route
    </button>

    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Start Point</th>
                <th>End Point</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($routes as $route)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $route->name }}</td>
                <td>{{ $route->start_point }}</td>
                <td>{{ $route->end_point }}</td>
                <td>
                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editRouteModal{{ $route->id }}">Edit</button>

                    <form action="{{ route('routes.destroy', $route->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this route?')">Delete</button>
                    </form>

                    <!-- Edit Modal per route -->
                    <div class="modal fade" id="editRouteModal{{ $route->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form action="{{ route('routes.update', $route->id) }}" method="POST" class="modal-content">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Route</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control" value="{{ $route->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Start Point</label>
                                        <input type="text" name="start_point" class="form-control" value="{{ $route->start_point }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>End Point</label>
                                        <input type="text" name="end_point" class="form-control" value="{{ $route->end_point }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Create Route Modal -->
<div class="modal fade" id="createRouteModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('routes.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Add Route</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Start Point</label>
                    <input type="text" name="start_point" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>End Point</label>
                    <input type="text" name="end_point" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Toast Notifications -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    @if(session('success'))
        <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif
</div>

@endsection
