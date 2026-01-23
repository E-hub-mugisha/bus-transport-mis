@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between mb-3">
        <h4>🛣️ Routes</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRoute">
            + Add Route
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Bus</th>
                <th>Pickup Points</th>
                <th>Dropoff Points</th>
                <th width="140">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($routes as $route)
            <tr>
                <td>{{ $route->name }}</td>
                <td>{{ $route->bus->plate_number }}</td>
                <td>{{ implode(', ', $route->pickup_points) }}</td>
                <td>{{ implode(', ', $route->dropoff_points) }}</td>
                <td>
                    <button class="btn btn-sm btn-warning"
                        data-bs-toggle="modal"
                        data-bs-target="#editRoute{{ $route->id }}">
                        Edit
                    </button>

                    <form action="{{ route('routes.destroy', $route) }}"
                          method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger"
                            onclick="return confirm('Delete this route?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>

            {{-- Edit Modal --}}
            <div class="modal fade" id="editRoute{{ $route->id }}">
                <div class="modal-dialog">
                    <form class="modal-content" method="POST"
                        action="{{ route('routes.update', $route) }}">
                        @csrf @method('PUT')

                        <div class="modal-header">
                            <h5>Edit Route</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <input class="form-control mb-2" name="name"
                                value="{{ $route->name }}" required>

                            <select class="form-control mb-2" name="bus_id">
                                @foreach($buses as $bus)
                                    <option value="{{ $bus->id }}"
                                        @selected($bus->id == $route->bus_id)>
                                        {{ $bus->plate_number }}
                                    </option>
                                @endforeach
                            </select>

                            <input class="form-control mb-2" name="pickup_points"
                                value="{{ implode(',', $route->pickup_points) }}">

                            <input class="form-control" name="dropoff_points"
                                value="{{ implode(',', $route->dropoff_points) }}">
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>

            @empty
            <tr>
                <td colspan="5" class="text-center">No routes found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Create Modal --}}
<div class="modal fade" id="createRoute">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('routes.store') }}">
            @csrf

            <div class="modal-header">
                <h5>Add Route</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input class="form-control mb-2" name="name" placeholder="Route name" required>

                <select class="form-control mb-2" name="bus_id" required>
                    <option value="">Select Bus</option>
                    @foreach($buses as $bus)
                        <option value="{{ $bus->id }}">{{ $bus->plate_number }}</option>
                    @endforeach
                </select>

                <input class="form-control mb-2" name="pickup_points"
                       placeholder="Pickup points (comma separated)">

                <input class="form-control" name="dropoff_points"
                       placeholder="Dropoff points (comma separated)">
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
