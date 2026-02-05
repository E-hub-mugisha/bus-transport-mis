@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold">🚍 Live Trip Tracking</h4>
    <p>Bus: {{ $busTrip->bus->plate_number }}</p>

    <div class="alert alert-info">
        GPS is sending live location while trip is <strong>started</strong>.
    </div>

    <div id="status" class="text-muted mb-2">Waiting for GPS permission...</div>
</div>

<script>
let watchId = null;

function startTracking() {
    if (!navigator.geolocation) {
        document.getElementById('status').innerText = "Geolocation not supported";
        return;
    }

    watchId = navigator.geolocation.watchPosition(pos => {
        document.getElementById('status').innerText =
            "Sending location: " + pos.coords.latitude + ", " + pos.coords.longitude;

        fetch('/api/bus-location', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                bus_id: {{ $busTrip->bus_id }},
                latitude: pos.coords.latitude,
                longitude: pos.coords.longitude
            })
        });
    }, err => {
        document.getElementById('status').innerText = "GPS error: " + err.message;
    }, {
        enableHighAccuracy: true
    });
}

startTracking();
</script>
@endsection
