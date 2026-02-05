@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between mb-3">
        <h4 class="fw-bold">👩‍🎓 Student Trips</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTripModal">
            + Record Trip
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
                        <th>Student</th>
                        <th>Bus</th>
                        <th>Status</th>
                        <th>Recorded At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($studentTrips as $trip)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $trip->student->first_name }} {{ $trip->student->last_name }}</td>
                        <td>{{ $trip->bus->plate_number }}</td>
                        <td>
                            <span class="badge bg-{{ $trip->status === 'picked_up' ? 'success' : 'secondary' }}">
                                {{ ucfirst(str_replace('_',' ', $trip->status ?? '—')) }}
                            </span>
                        </td>
                        <td>{{ $trip->recorded_at ?? '—' }}</td>
                        <td class="d-flex gap-2">

                            <!-- Edit -->
                            <button class="btn btn-sm btn-warning"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editTrip{{ $trip->id }}">
                                Edit
                            </button>

                            <!-- Delete -->
                            <form method="POST" action="{{ route('student-trips.destroy', $trip) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete this record?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editTrip{{ $trip->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <form method="POST" action="{{ route('student-trips.update', $trip) }}" class="modal-content">
                                @csrf
                                @method('PUT')

                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Student Trip</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body row g-3">
                                    <div class="col-md-6">
                                        <label>Student</label>
                                        <select name="student_id" class="form-select">
                                            @foreach($students as $student)
                                                <option value="{{ $student->id }}"
                                                    @selected($student->id == $trip->student_id)>
                                                    {{ $student->first_name }} {{ $student->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label>Bus</label>
                                        <select name="bus_id" class="form-select">
                                            @foreach($buses as $bus)
                                                <option value="{{ $bus->id }}"
                                                    @selected($bus->id == $trip->bus_id)>
                                                    {{ $bus->plate_number }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label>Status</label>
                                        <select name="status" class="form-select">
                                            <option value="">—</option>
                                            <option value="picked_up"  @selected($trip->status=='picked_up')>Picked Up</option>
                                            <option value="dropped_off" @selected($trip->status=='dropped_off')>Dropped Off</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label>Recorded At</label>
                                        <input type="datetime-local" name="recorded_at" class="form-control"
                                            value="{{ $trip->recorded_at ? \Carbon\Carbon::parse($trip->recorded_at)->format('Y-m-d\TH:i') : '' }}">
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
        <form method="POST" action="{{ route('student-trips.store') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Record Student Trip</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body row g-3">
                <div class="col-md-6">
                    <label>Student</label>
                    <select name="student_id" class="form-select" required>
                        <option value="">Select student</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">
                                {{ $student->first_name }} {{ $student->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

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
                    <label>Status</label>
                    <select name="status" class="form-select">
                        <option value="">—</option>
                        <option value="picked_up">Picked Up</option>
                        <option value="dropped_off">Dropped Off</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Recorded At</label>
                    <input type="datetime-local" name="recorded_at" class="form-control">
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary">Save Record</button>
            </div>
        </form>
    </div>
</div>
@endsection
