@extends('layouts.app')
@section('title', 'User Management')
@section('content')

<div class="container mt-4">
    <h3>User Management</h3>

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createUserModal">
        Add New User
    </button>

    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    <button class="btn btn-sm btn-info editBtn" data-id="{{ $user->id }}">Edit</button>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger deleteBtn" type="button" data-id="{{ $user->id }}">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('users.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Role</label>
                    <select name="role" class="form-control" required>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                        <option value="super_admin">Super Admin</option>
                        <option value="driver">Driver</option>
                        <option value="manager">Manager</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="editUserForm" method="POST" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3"><label>Name</label><input type="text" name="name" class="form-control" required></div>
                <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required></div>
                <div class="mb-3">
                    <label>Role</label>
                    <select name="role" class="form-control" required>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                        <option value="super_admin">Super Admin</option>
                        <option value="driver">Driver</option>
                        <option value="manager">Manager</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

<!-- Toast Container -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="toastContainer"></div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Edit user button
    document.querySelectorAll('.editBtn').forEach(btn => {
        btn.addEventListener('click', function() {
            let userId = this.dataset.id;
            fetch(`/users/${userId}/edit`)
                .then(res => res.json())
                .then(data => {
                    let form = document.getElementById('editUserForm');
                    form.action = `/users/${userId}`;
                    form.name.value = data.name;
                    form.email.value = data.email;
                    form.role.value = data.role;
                    new bootstrap.Modal(document.getElementById('editUserModal')).show();
                });
        });
    });

    // Delete confirmation with toast
    document.querySelectorAll('.deleteBtn').forEach(btn => {
        btn.addEventListener('click', function() {
            if(confirm('Are you sure you want to delete this user?')) {
                this.closest('form').submit();
            }
        });
    });
});
</script>
@endsection
