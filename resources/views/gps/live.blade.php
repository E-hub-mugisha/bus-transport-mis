@extends('layouts.app')
@section('title','Live Bus Tracking')

@section('content')
<div class="container-fluid mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">🚍 Live Bus GPS Tracking</h4>
        <span class="badge bg-success">Live</span>
    </div>

    <!-- Bus Selector -->
    <div class="mb-3">
        <label for="busSelect" class="form-label">Select a Bus:</label>
        <select id="busSelect" class="form-select">
            <option value="">-- All Ongoing Buses --</option>
            @foreach($buses as $bus)
                <option value="{{ $bus->id }}">{{ $bus->bus_number }} ({{ $bus->plate_number }})</option>
            @endforeach
        </select>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div id="map" style="height: 550px; width: 100%;"></div>
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

let markers = [];
let polylines = {};

function loadOngoingBusLocations(busId = null) {
    let url = '{{ route('gps.live.data') }}';
    if(busId) url += '?bus_id=' + busId;

    fetch(url)
        .then(res => res.json())
        .then(trips => {

            // Clear previous markers
            markers.forEach(m => map.removeLayer(m));
            markers = [];

            // Prepare bus paths
            let busPaths = {};

            trips.forEach(trip => {
                const bus = trip.bus;
                const latest = trip.latest_location;

                if (!bus || !latest) return; // skip if no latest location

                const lat = parseFloat(latest.latitude);
                const lng = parseFloat(latest.longitude);

                if (!lat || !lng) return;

                // Add marker
                const popup = `
                    <strong>Bus:</strong> ${bus.bus_number}<br>
                    <strong>Plate:</strong> ${bus.plate_number}<br>
                    <strong>Route:</strong> ${trip.route ? trip.route.name : '-'}<br>
                    <strong>Status:</strong> ${trip.status}<br>
                    <small>Updated: ${latest.recorded_at}</small>
                `;

                const marker = L.marker([lat, lng]).addTo(map).bindPopup(popup);
                markers.push(marker);

                // Add to bus path
                if (!busPaths[bus.id]) busPaths[bus.id] = [];
                busPaths[bus.id].push([lat, lng]);
            });

            // Clear previous polylines
            Object.values(polylines).forEach(line => map.removeLayer(line));
            polylines = {};

            // Draw new polylines per bus
            Object.keys(busPaths).forEach(busId => {
                polylines[busId] = L.polyline(busPaths[busId], {
                    color: getBusColor(busId),
                    weight: 4,
                    opacity: 0.7
                }).addTo(map);
            });

            // If busId is provided, zoom to its latest location
            if(busId && trips.length) {
                const latest = trips[0].latest_location;
                if(latest) map.setView([parseFloat(latest.latitude), parseFloat(latest.longitude)], 15);
            }
        })
        .catch(err => console.error('Error loading bus locations:', err));
}

// Function to assign color per bus
function getBusColor(busId) {
    const colors = ['red','blue','green','orange','purple','cyan','magenta','brown'];
    return colors[busId % colors.length];
}

// Initial load (all ongoing buses)
loadOngoingBusLocations();

// Refresh every 15s
setInterval(() => loadOngoingBusLocations(document.getElementById('busSelect').value), 15000);

// Handle bus selection
document.getElementById('busSelect').addEventListener('change', function() {
    loadOngoingBusLocations(this.value || null);
});
</script>
@endsection
