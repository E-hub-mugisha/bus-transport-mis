@extends('layouts.app')

@section('content')
<div class="container">

    <!-- Student Header -->
    <div class="card mb-4">
        <div class="card-body d-flex align-items-center">
            <img src="{{ asset($student->profile_photo ?? 'images/avatar.png') }}"
                 class="rounded-circle me-4" width="90">

            <div>
                <h4>{{ $student->first_name }} {{ $student->last_name }}</h4>
                <p class="mb-1">🎓 Parent: {{ $student->parent->name }}</p>
                <p class="mb-1">🚍 Bus: {{ $student->buses->plate_number ?? 'Not Assigned' }}</p>
                <p class="mb-0">🧑‍✈️ Driver: {{ $student->bus->driver->name ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#trips">Trip History</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#activity">Activity</a>
        </li>
    </ul>

    <div class="tab-content">

        <!-- Trip History -->
        <div class="tab-pane fade show active" id="trips">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Route</th>
                        <th>Pickup</th>
                        <th>Drop</th>
                        <th>Status</th>
                        <th>Map</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($student->trips as $trip)
                    <tr>
                        <td>{{ $trip->created_at->format('d M Y') }}</td>
                        <td>{{ $trip->trip->route->name ?? '-' }}</td>
                        <td>{{ $trip->pickup_time ?? '—' }}</td>
                        <td>{{ $trip->drop_time ?? '—' }}</td>
                        <td>
                            <span class="badge bg-{{ $trip->status === 'dropped' ? 'success' : 'warning' }}">
                                {{ ucfirst($trip->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('student.trip.map', $trip) }}" class="btn btn-sm btn-primary">
                                View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No trips found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Activity -->
        <div class="tab-pane fade" id="activity">
            <ul class="list-group">
                <li class="list-group-item">✔ Assigned to Bus</li>
                <li class="list-group-item">📍 Pickup Recorded</li>
                <li class="list-group-item">🚍 Dropped at School</li>
            </ul>
        </div>

    </div>
</div>
@endsection
