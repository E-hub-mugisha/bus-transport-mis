@extends('layouts.app')
@section('title','Bus Management')
@section('content')

<div class="container mt-4">
    <h3>Bus Management</h3>

    <!-- Add Bus Button -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createBusModal">
        Add New Bus
    </button>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <!-- Bus Table -->
    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Bus Number</th>
                <th>Plate Number</th>
                <th>Capacity</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($buses as $bus)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $bus->bus_number }}</td>
                <td>{{ $bus->plate_number }}</td>
                <td>{{ $bus->capacity }}</td>
                <td>{{ ucfirst($bus->status) }}</td>
                <td>
                    <!-- Edit Button triggers modal -->
                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editBusModal{{ $bus->id }}">Edit</button>

                    <!-- Delete Form -->
                    <form action="{{ route('buses.destroy', $bus->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this bus?')">Delete</button>
                    </form>

                    <!-- Edit Modal per bus -->
                    <div class="modal fade" id="editBusModal{{ $bus->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form action="{{ route('buses.update', $bus->id) }}" method="POST" class="modal-content">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Bus</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Plate Number</label>
                                        <input type="text" name="plate_number" class="form-control" value="{{ $bus->plate_number }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Capacity</label>
                                        <input type="text" name="capacity" class="form-control" value="{{ $bus->capacity }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Status</label>
                                        <select name="status" class="form-control" required>
                                            <option value="active" {{ $bus->status=='active'?'selected':'' }}>Active</option>
                                            <option value="inactive" {{ $bus->status=='inactive'?'selected':'' }}>Inactive</option>
                                            <option value="maintenance" {{ $bus->status=='maintenance'?'selected':'' }}>Maintenance</option>
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

<!-- Create Bus Modal -->
<div class="modal fade" id="createBusModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('buses.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Add Bus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">driver</label>
                    <select class="form-select" name="driver_id" required>
                        @foreach($drivers as $driver)
                        <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Plate Number</label>
                    <input type="text" name="plate_number" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Capacity</label>
                    <input type="text" name="capacity" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="maintenance">Maintenance</option>
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

    @if(session('error'))
    <div class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                {{ session('error') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    @endif
</div>

@endsection