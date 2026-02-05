@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-3">📍 Live Tracking – Bus {{ $bus->plate_number }}</h4>

    <div id="map" style="height: 500px;" class="rounded shadow-sm"></div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    const map = L.map('map').setView([-2.0200, 29.3200], 13); // Kamonyi approx

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19
    }).addTo(map);

    let marker = L.marker([-2.0200, 29.3200]).addTo(map);

    async function fetchLocation() {
        const res = await fetch('/api/bus/{{ $bus->id }}/location');
        const data = await res.json();

        if (data) {
            marker.setLatLng([data.latitude, data.longitude]);
            map.setView([data.latitude, data.longitude], 15);
        }
    }

    setInterval(fetchLocation, 5000); // update every 5 seconds
</script>
@endsection
