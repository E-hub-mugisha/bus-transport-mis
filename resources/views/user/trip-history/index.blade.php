@extends('layouts.app')
@section('title','Trip History')

@section('content')
<div class="container mt-4">

    <h4 class="fw-bold mb-3">📜 Trip History</h4>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Bus</th>
                        <th>Route</th>
                        <th>Departure</th>
                        <th>Arrival</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="tripHistoryTable">
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            Loading trip history...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
function loadTripHistory() {
    fetch('{{ route('trip.history.data') }}')
        .then(res => res.json())
        .then(trips => {

            const table = document.getElementById('tripHistoryTable');
            table.innerHTML = '';

            if (trips.length === 0) {
                table.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center text-danger">
                            No trip history available
                        </td>
                    </tr>`;
                return;
            }

            trips.forEach(trip => {
                table.innerHTML += `
                    <tr>
                        <td>${trip.trip_date}</td>
                        <td>${trip.bus.bus_number}</td>
                        <td>${trip.route.name}</td>
                        <td>${trip.departure_time}</td>
                        <td>${trip.arrival_time ?? '-'}</td>
                        <td>
                            <span class="badge ${trip.status === 'completed' ? 'bg-success' : 'bg-warning'}">
                                ${trip.status}
                            </span>
                        </td>
                    </tr>
                `;
            });
        });
}

// Load once
loadTripHistory();
</script>
@endsection
