@extends('layouts.app')
@section('title','My Assigned Trip')

@section('content')
<div class="container-fluid mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">🧭 My Assigned Trip</h4>

        @if($trips && $trips->status === 'ongoing')
            <button id="startTrackingBtn" class="btn btn-success">
                ▶ Start Location Sharing
            </button>
        @endif
    </div>

    @if(!$trips)
        <div class="alert alert-warning">
            No active trip assigned to you.
        </div>
    @else

    <!-- Trip Info -->
    <div class="card mb-3">
        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-3"><strong>Bus:</strong><br>{{ $trips->bus->bus_number }}</div>
                <div class="col-md-3"><strong>Route:</strong><br>{{ $trips->route->name }}</div>
                <div class="col-md-3"><strong>Departure:</strong><br>{{ $trips->departure_time }}</div>
                <div class="col-md-3"><strong>Status:</strong><br>
                    <span class="badge bg-success">{{ ucfirst($trips->status) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Map -->
    <div class="card">
        <div class="card-body p-0">
            <div id="map" style="height: 550px;"></div>
        </div>
    </div>

    @endif
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
@if($trips)

const map = L.map('map').setView([-1.9500, 30.0588], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

let busMarker = null;
let studentMarkers = [];
let watchId = null;

// ===== STUDENT PICKUP POINTS =====
@foreach($trips->bus->students as $student)
    @if($student->pickupPoint)
        L.marker([
            {{ $student->pickupPoint->latitude }},
            {{ $student->pickupPoint->longitude }}
        ], {
            icon: L.icon({
                iconUrl: 'https://cdn-icons-png.flaticon.com/512/149/149071.png',
                iconSize: [25, 25]
            })
        })
        .addTo(map)
        .bindPopup(`
            <strong>{{ $student->name }}</strong><br>
            Pickup Point
        `);
    @endif
@endforeach

// ===== START GPS TRACKING =====
document.getElementById('startTrackingBtn')?.addEventListener('click', () => {

    if (!navigator.geolocation) {
        alert('Geolocation not supported');
        return;
    }

    watchId = navigator.geolocation.watchPosition(position => {

        const lat = position.coords.latitude;
        const lng = position.coords.longitude;

        if (busMarker) {
            busMarker.setLatLng([lat, lng]);
        } else {
            busMarker = L.marker([lat, lng]).addTo(map)
                .bindPopup('🚌 My Bus');
        }

        // Send to server
        fetch("{{ route('driver.bus.location') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                bus_id: {{ $trips->bus_id }},
                trip_id: {{ $trips->id }},
                latitude: lat,
                longitude: lng
            })
        });

    }, error => {
        alert('GPS Error: ' + error.message);
    }, {
        enableHighAccuracy: true,
        maximumAge: 0,
        timeout: 5000
    });

    document.getElementById('startTrackingBtn').disabled = true;
});

@endif
</script>
@endsection
