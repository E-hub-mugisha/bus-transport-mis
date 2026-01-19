@extends('layouts.app')
@section('title','Student Pickup Points')

@section('content')
<div class="container-fluid mt-4">

    <h4 class="fw-bold mb-3">📍 Student Pickup Point Management</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <!-- Student List -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header fw-bold">👨‍🎓 Students</div>
                <ul class="list-group list-group-flush">
                    @foreach($students as $student)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $student->names }}
                            <button class="btn btn-sm btn-primary"
                                onclick="selectStudent(
                                    {{ $student->id }},
                                    '{{ $student->name }}',
                                    {{ optional($student->pickupPoint)->latitude ?? 'null' }},
                                    {{ optional($student->pickupPoint)->longitude ?? 'null' }}
                                )">
                                Set Location
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Map -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header fw-bold">🗺️ Pickup Location Map</div>
                <div class="card-body p-0">
                    <div id="map" style="height: 500px;"></div>
                </div>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('pickup-points.store') }}" class="mt-3">
                @csrf
                <input type="hidden" name="student_id" id="student_id">
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">

                <button class="btn btn-success w-100" id="saveBtn" disabled>
                    💾 Save Pickup Point
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
let map = L.map('map').setView([-1.9500, 30.0588], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

let marker = null;

function selectStudent(id, name, lat, lng) {
    document.getElementById('student_id').value = id;
    document.getElementById('saveBtn').disabled = false;

    if (lat && lng) {
        if (marker) map.removeLayer(marker);
        marker = L.marker([lat, lng]).addTo(map)
            .bindPopup(name + "'s Pickup Point").openPopup();
        map.setView([lat, lng], 15);
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
    }
}

// Click on map
map.on('click', function(e) {
    if (!document.getElementById('student_id').value) {
        alert('Select a student first');
        return;
    }

    if (marker) map.removeLayer(marker);

    marker = L.marker(e.latlng).addTo(map)
        .bindPopup('Pickup Location Selected').openPopup();

    document.getElementById('latitude').value = e.latlng.lat;
    document.getElementById('longitude').value = e.latlng.lng;
});
</script>
@endsection
