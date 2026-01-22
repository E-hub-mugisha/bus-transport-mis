@extends('layouts.app')
@section('title', 'Live Bus Tracking')
@section('content')

<div class="container mt-4">
    <h3>Live Bus Tracking</h3>
    <div id="map" style="height:600px;width:100%;"></div>
</div>

@endsection

@section('scripts')
<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
let map = L.map('map').setView([-1.944, 30.061], 12); // Center Rwanda

// OpenStreetMap tiles
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

// Marker storage
let markers = {};

// Function to fetch latest bus positions
function fetchBuses() {
    fetch('/api/buses') // API endpoint returning bus locations
        .then(res => res.json())
        .then(buses => {
            buses.forEach(bus => {
                if (!bus.latitude || !bus.longitude) return;

                let pos = [parseFloat(bus.latitude), parseFloat(bus.longitude)];

                // Update existing marker or create new
                if (markers[bus.id]) {
                    markers[bus.id].setLatLng(pos);
                } else {
                    markers[bus.id] = L.marker(pos)
                        .addTo(map)
                        .bindPopup(`<b>Bus:</b> ${bus.plate_number}`);
                }
            });
        })
        .catch(err => console.error(err));
}

// Refresh every 5 seconds
setInterval(fetchBuses, 5000);
fetchBuses();
</script>
@endsection
