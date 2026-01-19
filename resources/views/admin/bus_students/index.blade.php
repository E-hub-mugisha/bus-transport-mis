@extends('layouts.app')
@section('title','Assign Students to Buses')

@section('content')
<div class="container-fluid mt-4">

    <h4 class="fw-bold mb-3">🚌 Assign Students to Buses</h4>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <!-- Assignment Form -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header fw-bold">➕ Assign Student</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('bus-students.assign') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Select Bus</label>
                            <select name="bus_id" class="form-select" required>
                                <option value="">-- Choose Bus --</option>
                                @foreach($buses as $bus)
                                <option value="{{ $bus->id }}">
                                    {{ $bus->bus_number }} ({{ $bus->plate_number }})
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Select Student</label>
                            <select name="student_id" class="form-select" required>
                                <option value="">-- Choose Student --</option>
                                @foreach($students as $student)
                                <option value="{{ $student->id }}">
                                    {{ $student->names }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <button class="btn btn-success w-100">
                            ✅ Assign Student
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Bus Student List -->
        <div class="col-md-8">
            @foreach($buses as $bus)
            <div class="card mb-3">
                <div class="card-header fw-bold">
                    🚍 {{ $bus->bus_number }} — {{ $bus->plate_number }}
                </div>
                <div class="card-body p-0">
                    @if($bus->students->count())
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Student</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bus->students as $student)
                            <tr>
                                <td>{{ $student->names }}</td>
                                <td>
                                    <form method="POST"
                                        action="{{ route('bus-students.remove', [$bus->id, $student->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            ❌ Remove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p class="text-muted p-3">No students assigned</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection