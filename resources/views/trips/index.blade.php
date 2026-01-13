@extends('layouts.app')
@section('title','Trip Management')
@section('content')

<div class="container mt-4">
    <h3>Trip Management</h3>

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createTripModal">
        Add New Trip
    </button>

    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Bus</th>
                <th>Driver</th>
                <th>Route</th>
                <th>Trip Date</th>
                <th>Departure</th>
                <th>Arrival</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($trips as $trip)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $trip->bus->bus_number }}</td>
                <td>{{ $trip->driver->user->name }}</td>
                <td>{{ $trip->route->name }}</td>
                <td>{{ $trip->trip_date }}</td>
                <td>{{ $trip->departure_time }}</td>
                <td>{{ $trip->arrival_time ?? '-' }}</td>
                <td>{{ ucfirst($trip->status) }}</td>
                <td>
                    <!-- Edit Modal Trigger -->
                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editTripModal{{ $trip->id }}">Edit</button>

                    <!-- Delete Form -->
                    <form action="{{ route('trips.destroy', $trip->id) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this trip?')">Delete</button>
                    </form>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editTripModal{{ $trip->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form action="{{ route('trips.update', $trip->id) }}" method="POST" class="modal-content">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Trip</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Bus</label>
                                        <select name="bus_id" class="form-control" required>
                                            @foreach($buses as $bus)
                                                <option value="{{ $bus->id }}" {{ $bus->id == $trip->bus_id ? 'selected':'' }}>
                                                    {{ $bus->bus_number }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Driver</label>
                                        <select name="driver_id" class="form-control" required>
                                            @foreach($drivers as $driver)
                                                <option value="{{ $driver->id }}" {{ $driver->id == $trip->driver_id ? 'selected':'' }}>
                                                    {{ $driver->user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Route</label>
                                        <select name="route_id" class="form-control" required>
                                            @foreach($routes as $route)
                                                <option value="{{ $route->id }}" {{ $route->id == $trip->route_id ? 'selected':'' }}>
                                                    {{ $route->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Trip Date</label>
                                        <input type="date" name="trip_date" class="form-control" value="{{ $trip->trip_date }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Departure Time</label>
                                        <input type="time" name="departure_time" class="form-control" value="{{ $trip->departure_time }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Arrival Time</label>
                                        <input type="time" name="arrival_time" class="form-control" value="{{ $trip->arrival_time }}">
                                    </div>
                                    <div class="mb-3">
                                        <label>Status</label>
                                        <select name="status" class="form-control" required>
                                            @foreach(['scheduled','ongoing','completed','delayed'] as $status)
                                                <option value="{{ $status }}" {{ $status == $trip->status ? 'selected':'' }}>
                                                    {{ ucfirst($status) }}
                                                </option>
                                            @endforeach
                                        </select>
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

<!-- Create Trip Modal -->
<div class="modal fade" id="createTripModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('trips.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Add Trip</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Bus</label>
                    <select name="bus_id" class="form-control" required>
                        @foreach($buses as $bus)
                            <option value="{{ $bus->id }}">{{ $bus->bus_number }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Driver</label>
                    <select name="driver_id" class="form-control" required>
                        @foreach($drivers as $driver)
                            <option value="{{ $driver->id }}">{{ $driver->user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Route</label>
                    <select name="route_id" class="form-control" required>
                        @foreach($routes as $route)
                            <option value="{{ $route->id }}">{{ $route->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Trip Date</label>
                    <input type="date" name="trip_date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Departure Time</label>
                    <input type="time" name="departure_time" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Arrival Time</label>
                    <input type="time" name="arrival_time" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        @foreach(['scheduled','ongoing','completed','delayed'] as $status)
                            <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
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
