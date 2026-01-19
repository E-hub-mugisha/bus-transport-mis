@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h4>🧭 Live Pickup Navigation</h4>

    <div id="map" style="height: 80vh;"></div>
</div>

<script>
let map, driverMarker;
let pickupMarkers = [];

function initMap() {
    map = L.map('map').setView([-1.95, 30.05], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    // Student pickup points
    @foreach($students as $student)
        @if($student->pickupPoint)
            L.marker([
                {{ $student->pickupPoint->latitude }},
                {{ $student->pickupPoint->longitude }}
            ])
            .addTo(map)
            .bindPopup("🎓 {{ $student->names }}");
        @endif
    @endforeach

    startTracking();
}

function startTracking() {
    navigator.geolocation.watchPosition(position => {
        let lat = position.coords.latitude;
        let lng = position.coords.longitude;

        if (!driverMarker) {
            driverMarker = L.marker([lat, lng], {
                icon: L.icon({
                    iconUrl: 'https://cdn-icons-png.flaticon.com/512/61/61231.png',
                    iconSize: [40,40]
                })
            }).addTo(map);
        } else {
            driverMarker.setLatLng([lat, lng]);
        }

        map.panTo([lat, lng]);

        // Send GPS to server
        fetch("{{ route('driver.bus.location') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                latitude: lat,
                longitude: lng,
                trip_id: {{ $trip->id }},
                bus_id: {{ $trip->bus_id }}
            })
        });
    });
}

initMap();
</script>
@endsection
