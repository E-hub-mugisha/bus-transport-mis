@extends('layouts.app')
@section('title','Student Pickup')

@section('content')
<div class="container-fluid mt-4">
    <h4 class="fw-bold">
        🎯 Pickup Location – {{ $student->names }}
    </h4>

    <div id="map" style="height: 550px;"></div>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
const map = L.map('map').setView(
    [{{ $student->pickupPoint->latitude }}, {{ $student->pickupPoint->longitude }}],
    15
);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

// Student pickup marker
L.marker([
    {{ $student->pickupPoint->latitude }},
    {{ $student->pickupPoint->longitude }}
])
.addTo(map)
.bindPopup("{{ $student->name }} Pickup Point")
.openPopup();
</script>
@endsection
