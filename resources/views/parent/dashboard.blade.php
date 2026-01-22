@extends('layouts.app')
@section('title','Parent Dashboard')
@section('content')

<div class="container mt-4">
    <h3>Welcome, {{ auth()->user()->name }}</h3>

    <h5>Your Children</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student</th>
                <th>Assigned Bus</th>
                <th>Last Pickup</th>
                <th>Last Drop-off</th>
            </tr>
        </thead>
        <tbody>
        @foreach($students as $student)
            <tr>
                <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                <td>{{ $student->buses->pluck('plate_number')->join(', ') ?? 'Not Assigned' }}</td>
                <td>{{ optional($student->trips->where('status','picked_up')->last())->recorded_at ?? '-' }}</td>
                <td>{{ optional($student->trips->where('status','dropped_off')->last())->recorded_at ?? '-' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <a href="{{ route('parent.bus.track') }}" class="btn btn-primary mt-3">Track Bus Live</a>
</div>

@endsection
