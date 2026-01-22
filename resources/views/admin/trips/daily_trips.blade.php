@extends('layouts.app')
@section('title','Daily Transport Activities')
@section('content')

<div class="container mt-4">
    <h3>Daily Transport Activities</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Bus</th>
                <th>Driver</th>
                <th>Status</th>
                <th>Start Time</th>
                <th>End Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach($trips as $trip)
            <tr>
                <td>{{ $trip->bus->plate_number }}</td>
                <td>{{ $trip->driver->name }}</td>
                <td>{{ ucfirst($trip->status) }}</td>
                <td>{{ $trip->start_time ?? '-' }}</td>
                <td>{{ $trip->end_time ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
