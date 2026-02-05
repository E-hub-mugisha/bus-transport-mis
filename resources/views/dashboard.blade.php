@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="container py-4">

    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Dashboard</h3>
            <small class="text-muted">Overview of School Transport System</small>
        </div>
        <span class="badge bg-primary">System Active</span>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-primary text-white me-3">👩‍🎓</div>
                    <div>
                        <h6 class="mb-0">Students</h6>
                        <h4 class="fw-bold mb-0">{{ $totalStudents }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-success text-white me-3">🚍</div>
                    <div>
                        <h6 class="mb-0">Buses</h6>
                        <h4 class="fw-bold mb-0">{{ $totalBuses }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-warning text-white me-3">🛣️</div>
                    <div>
                        <h6 class="mb-0">Routes</h6>
                        <h4 class="fw-bold mb-0">{{ $totalRoutes }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-dark text-white me-3">👨‍👩‍👧</div>
                    <div>
                        <h6 class="mb-0">Parents</h6>
                        <h4 class="fw-bold mb-0">{{ $totalParents }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-3">
                <h6 class="fw-semibold mb-3">📊 Students per Bus</h6>
                <canvas id="studentsPerBusChart" height="120"></canvas>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-3">
                <h6 class="fw-semibold mb-3">🛣️ Route Usage</h6>
                <canvas id="routeUsageChart" height="120"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Students -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white fw-semibold">
            🕒 Recently Added Students
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Parent</th>
                        <th>Bus</th>
                        <th>Registered</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentStudents as $student)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                        <td>{{ $student->parent->name ?? '-' }}</td>
                        <td>{{ $student->bus->plate_number ?? 'Not Assigned' }}</td>
                        <td>{{ $student->created_at->diffForHumans() }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">No recent students</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Simple Styling -->
<style>
    .icon-circle {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
</style>

<!-- Charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const busLabels   = @json($busLabels);
    const busCounts   = @json($busCounts);

    const routeLabels = @json($routeLabels);
    const routeCounts = @json($routeCounts);

    new Chart(document.getElementById('studentsPerBusChart'), {
        type: 'bar',
        data: {
            labels: busLabels,
            datasets: [{
                label: 'Students',
                data: busCounts,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    new Chart(document.getElementById('routeUsageChart'), {
        type: 'doughnut',
        data: {
            labels: routeLabels,
            datasets: [{
                label: 'Students',
                data: routeCounts,
                borderWidth: 1
            }]
        },
        options: { responsive: true }
    });
</script>
@endsection
