@extends('layouts.app')
@section('title','My Students')

@section('content')
<div class="container mt-4">
    <h4 class="fw-bold">👨‍🎓 Students Assigned to My Bus</h4>

    @if(!$trip)
        <div class="alert alert-warning">No active trip</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Pickup Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trip->bus->students as $student)
                    <tr>
                        <td>{{ $student->names }}</td>
                        <td>
                            <span class="badge bg-secondary">Pending</span>
                        </td>
                        <td>
                            <a href="{{ route('driver.students.show', $student->id) }}"
                               class="btn btn-sm btn-primary">
                                📍 View Pickup
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
