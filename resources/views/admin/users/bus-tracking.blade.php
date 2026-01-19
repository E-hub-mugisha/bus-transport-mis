@extends('layouts.app')
@section('title','Bus Tracking & Schedules')

@section('content')
<div class="container-fluid mt-4">

    <h4 class="fw-bold mb-3">🎓 Live Bus Location & Schedules</h4>

    <!-- Schedule Table -->
    <div class="card mb-4">
        <div class="card-header fw-bold">📅 Today’s Bus Schedule</div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Bus</th>
                        <th>Route</th>
                        <th>Departure</th>
                        <th>Status</th>
                        <th>Last Update</th>
                    </tr>
                </thead>
                <tbody id="scheduleTable"></tbody>
            </table>
        </div>
    </div>

    <!-- Map -->
    <div class="card">
        <div class="card-header fw-bold">📍 Live Bus Map</div>
        <div class="card-body p-0">
            <div id="map" style="height: 550px;"></div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
const map = L.map('map').setView([-1.9500, 30.0588], 12);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

let markers = {};

function loadUserBusData() {
    fetch('{{ route('user.bus.tracking.data') }}')
        .then(res => res.json())
        .then(trips => {

            document.getElementById('scheduleTable').innerHTML = '';

            trips.forEach(trip => {

                // ====== TABLE ======
                const lastUpdate = trip.latest_location
                    ? new Date(trip.latest_location.recorded_at).toLocaleTimeString()
                    : 'N/A';

                document.getElementById('scheduleTable').innerHTML += `
                    <tr>
                        <td>${trip.bus.bus_number}</td>
                        <td>${trip.route.name}</td>
                        <td>${trip.departure_time}</td>
                        <td><span class="badge bg-success">Ongoing</span></td>
                        <td>${lastUpdate}</td>
                    </tr>
                `;

                // ====== MAP ======
                if (!trip.latest_location) return;

                const lat = parseFloat(trip.latest_location.latitude);
                const lng = parseFloat(trip.latest_location.longitude);

                const popup = `
                    <strong>Bus:</strong> ${trip.bus.bus_number}<br>
                    <strong>Route:</strong> ${trip.route.name}<br>
                    <strong>Departure:</strong> ${trip.departure_time}<br>
                    <small>Updated: ${lastUpdate}</small>
                `;

                if (markers[trip.id]) {
                    markers[trip.id].setLatLng([lat, lng]).setPopupContent(popup);
                } else {
                    markers[trip.id] = L.marker([lat, lng])
                        .addTo(map)
                        .bindPopup(popup);
                }
            });
        });
}

// Load initially
loadUserBusData();

// Auto refresh every 20 seconds
setInterval(loadUserBusData, 20000);
</script>
@endsection
