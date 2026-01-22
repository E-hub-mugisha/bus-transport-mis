@extends('layouts.app')
@section('title','Live Bus Tracking')
@section('content')

<div class="container mt-4">
    <h3>Live Bus Tracking</h3>
    <div id="map" style="height:600px;width:100%;"></div>
</div>

@endsection

@section('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
let map = L.map('map').setView([-1.944, 30.061], 12);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

let markers = {};

// Array of assigned bus IDs passed from controller
let assignedBusIds = @json($busIds);

function fetchBuses() {
    fetch('/api/buses')
        .then(res => res.json())
        .then(buses => {
            buses.forEach(bus => {
                // Only show buses assigned to this parent
                if(!assignedBusIds.includes(bus.id)) return;
                if(!bus.latitude || !bus.longitude) return;

                let pos = [parseFloat(bus.latitude), parseFloat(bus.longitude)];

                if(markers[bus.id]){
                    markers[bus.id].setLatLng(pos);
                } else {
                    markers[bus.id] = L.marker(pos)
                        .addTo(map)
                        .bindPopup(`<b>Bus:</b> ${bus.plate_number}`);
                }
            });
        });
}

setInterval(fetchBuses, 5000);
fetchBuses();
</script>
@endsection
