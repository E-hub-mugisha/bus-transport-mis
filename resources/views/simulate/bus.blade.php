@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h4>🚍 Simulate GPS for Bus {{ $bus->plate_number }}</h4>

    <form method="POST" action="{{ url('/api/bus-location') }}">
        @csrf
        <input type="hidden" name="bus_id" value="{{ $bus->id }}">

        <div class="row g-3">
            <div class="col-md-6">
                <label>Latitude</label>
                <input type="text" name="latitude" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label>Longitude</label>
                <input type="text" name="longitude" class="form-control" required>
            </div>
        </div>

        <button class="btn btn-primary mt-3">Send Location</button>
    </form>

    <small class="text-muted d-block mt-3">
        Example: -2.0189 , 29.3214 (Kamonyi)
    </small>
</div>
@endsection
