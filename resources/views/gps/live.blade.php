@extends('layouts.app')
@section('title','Live Bus Tracking')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">🚍 Live Bus GPS Tracking</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#searchBusModal">
            🔍 Find Bus
        </button>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div id="map" style="height: 550px; width: 100%;"></div>
        </div>
    </div>
</div>

<!-- Search Bus Modal -->
<div class="modal fade" id="searchBusModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="searchBusForm" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Search Bus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <label>Bus Number</label>
                <input type="text" id="busNumberInput" class="form-control" placeholder="BUS-002" required>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">Show on Map</button>
            </div>
        </form>
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

let markers = {};
let allLocations = [];

// Load latest bus locations
function loadBusLocations() {
    fetch('{{ route('gps.all') }}')
        .then(res => res.json())
        .then(data => {
            allLocations = data;
            renderLocations(data);
        });
}

// Render markers
function renderLocations(locations) {
    Object.values(markers).forEach(m => map.removeLayer(m));
    markers = {};

    locations.forEach(loc => {
        const lat = parseFloat(loc.latitude);
        const lng = parseFloat(loc.longitude);

        if (!lat || !lng) return;

        const popup = `
            <strong>Bus:</strong> ${loc.bus.bus_number}<br>
            <strong>Plate:</strong> ${loc.bus.plate_number}<br>
            <strong>Route:</strong> ${loc.trip?.route?.name ?? '-'}<br>
            <small>${loc.recorded_at}</small>
        `;

        markers[loc.bus_id] = L.marker([lat, lng])
            .addTo(map)
            .bindPopup(popup);
    });
}

// Search by bus number
document.getElementById('searchBusForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const busNumber = document.getElementById('busNumberInput').value.trim().toUpperCase();

    const match = allLocations.find(l =>
        l.bus.bus_number.toUpperCase() === busNumber
    );

    if (!match) {
        alert('Bus not found or no GPS data.');
        return;
    }

    renderLocations([match]);
    map.setView([match.latitude, match.longitude], 15);

    bootstrap.Modal.getInstance(
        document.getElementById('searchBusModal')
    ).hide();
});

// Initial load
loadBusLocations();

// Refresh every 15s
setInterval(loadBusLocations, 15000);
</script>
@endsection
