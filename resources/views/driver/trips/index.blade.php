@extends('layouts.app')
@section('title','My Trips')
@section('content')

<div class="container mt-4">
    <h3>My Trips</h3>

    <!-- Start Trip Form -->
    <form action="{{ route('driver.trips.start') }}" method="POST" class="mb-3">
        @csrf
        <select name="bus_id" class="form-control" required>
            <option value="">Select Bus</option>
            @foreach(auth()->user()->buses as $bus)
                <option value="{{ $bus->id }}">{{ $bus->plate_number }}</option>
            @endforeach
        </select>
        <button class="btn btn-success mt-2">Start Trip</button>
    </form>

    <!-- Trip History -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Bus</th>
                <th>Status</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($trips as $trip)
            <tr>
                <td>{{ $trip->bus->plate_number }}</td>
                <td>{{ ucfirst($trip->status) }}</td>
                <td>{{ $trip->start_time ?? '-' }}</td>
                <td>{{ $trip->end_time ?? '-' }}</td>
                <td>
                    @if($trip->status == 'started')
                    <form action="{{ route('driver.trips.end',$trip) }}" method="POST">
                        @csrf
                        <button class="btn btn-danger btn-sm">End Trip</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
