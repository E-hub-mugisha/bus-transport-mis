@extends('layouts.app')
@section('title','Live Bus & Student Pickup Points')

@section('content')
<div class="container-fluid mt-4">
    <h4 class="fw-bold mb-3" >🚍 Live Bus Tracking & Student Pickup </h4>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div id="map" style="height: 600px;"></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
const map = L.map('map').setView([-1.9500, 30.0588], 12);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

let busMarkers = {};
let pickupMarkers = [];

function clearPickupMarkers() {
    pickupMarkers.forEach(m => map.removeLayer(m));
    pickupMarkers = [];
}

function loadLiveData() {
    fetch('{{ route('gps.live.pickups') }}')
        .then(res => res.json())
        .then(trips => {

            clearPickupMarkers();

            trips.forEach(trip => {

                if (!trip.latest_location) return;

                const busLat = parseFloat(trip.latest_location.latitude);
                const busLng = parseFloat(trip.latest_location.longitude);

                // ===== BUS MARKER =====
                if (busMarkers[trip.id]) {
                    busMarkers[trip.id].setLatLng([busLat, busLng]);
                } else {
                    busMarkers[trip.id] = L.marker([busLat, busLng], {
                        icon: L.icon({
                            iconUrl: 'https://cdn-icons-png.flaticon.com/512/61/61212.png',
                            iconSize: [40, 40]
                        })
                    })
                    .addTo(map)
                    .bindPopup(`
                        <strong>Bus:</strong> ${trip.bus.bus_number}<br>
                        <strong>Route:</strong> ${trip.route.name}
                    `);
                }

                // ===== STUDENT PICKUP POINTS =====
                trip.bus.students.forEach(student => {

                    if (!student.pickup_point) return;

                    const lat = parseFloat(student.pickup_point.latitude);
                    const lng = parseFloat(student.pickup_point.longitude);

                    const marker = L.circleMarker([lat, lng], {
                        radius: 7,
                        color: 'blue',
                        fillColor: '#007bff',
                        fillOpacity: 0.9
                    })
                    .addTo(map)
                    .bindPopup(`
                        <strong>Student:</strong> ${student.name}<br>
                        <small>Pickup Point</small>
                    `);

                    pickupMarkers.push(marker);
                });
            });
        });
}

// Initial load
loadLiveData();

// Auto refresh every 15 seconds
setInterval(loadLiveData, 15000);
</script>
@endsection
