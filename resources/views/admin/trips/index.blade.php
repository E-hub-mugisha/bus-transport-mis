@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between mb-3">
        <h4 class="fw-bold">🚌 Bus Trips</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTripModal">
            + New Trip
        </button>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Bus</th>
                        <th>Driver</th>
                        <th>Status</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($busTrips as $trip)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $trip->bus->plate_number }}</td>
                        <td>{{ $trip->driver->name }}</td>
                        <td>
                            <span class="badge bg-{{ $trip->status === 'started' ? 'success' : 'secondary' }}">
                                {{ ucfirst($trip->status) }}
                            </span>
                        </td>
                        <td>{{ $trip->start_time ?? '—' }}</td>
                        <td>{{ $trip->end_time ?? '—' }}</td>
                        <td class="d-flex gap-2">
                            <form method="POST" action="{{ route('bus-trips.update', $trip) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="started">
                                <input type="hidden" name="start_time" value="{{ now() }}">
                                <button class="btn btn-sm btn-success">Start Trip</button>
                            </form>
                            <form method="POST" action="{{ route('bus-trips.update', $trip) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="ended">
                                <input type="hidden" name="end_time" value="{{ now() }}">
                                <button class="btn btn-sm btn-danger">End Trip</button>
                            </form>

                            <!-- Edit -->
                            <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#editTrip{{ $trip->id }}">
                                Edit
                            </button>

                            <!-- Delete -->
                            <form method="POST" action="{{ route('trips.destroy', $trip) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete this trip?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editTrip{{ $trip->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <form method="POST" action="{{ route('trips.update', $trip) }}" class="modal-content">
                                @csrf
                                @method('PUT')

                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Trip</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Bus</label>
                                        <select name="bus_id" class="form-select" required>
                                            @foreach($buses as $bus)
                                            <option value="{{ $bus->id }}"
                                                @selected($bus->id == $trip->bus_id)>
                                                {{ $bus->plate_number }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Driver</label>
                                        <select name="driver_id" class="form-select" required>
                                            @foreach($drivers as $driver)
                                            <option value="{{ $driver->id }}"
                                                @selected($driver->id == $trip->driver_id)>
                                                {{ $driver->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label>Status</label>
                                        <select name="status" class="form-select">
                                            <option value="started" @selected($trip->status=='started')>Started</option>
                                            <option value="ended" @selected($trip->status=='ended')>Ended</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label>Start Time</label>
                                        <input type="datetime-local" name="start_time" class="form-control"
                                            value="{{ $trip->start_time ? \Carbon\Carbon::parse($trip->start_time)->format('Y-m-d\TH:i') : '' }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label>End Time</label>
                                        <input type="datetime-local" name="end_time" class="form-control"
                                            value="{{ $trip->end_time ? \Carbon\Carbon::parse($trip->end_time)->format('Y-m-d\TH:i') : '' }}">
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createTripModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('trips.store') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">New Trip</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body row g-3">
                <div class="col-md-6">
                    <label>Bus</label>
                    <select name="bus_id" class="form-select" required>
                        <option value="">Select bus</option>
                        @foreach($buses as $bus)
                        <option value="{{ $bus->id }}">{{ $bus->plate_number }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Driver</label>
                    <select name="driver_id" class="form-select" required>
                        <option value="">Select driver</option>
                        @foreach($drivers as $driver)
                        <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Status</label>
                    <select name="status" class="form-select">
                        <option value="started">Started</option>
                        <option value="ended">Ended</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Start Time</label>
                    <input type="datetime-local" name="start_time" class="form-control">
                </div>

                <div class="col-md-6">
                    <label>End Time</label>
                    <input type="datetime-local" name="end_time" class="form-control">
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary">Save Trip</button>
            </div>
        </form>
    </div>
</div>
@endsection