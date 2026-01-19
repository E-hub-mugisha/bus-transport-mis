@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Student Parents</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Add Parent Button -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addParentModal">
        Add Parent
    </button>

    <!-- Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($parents as $parent)
                <tr>
                    <td>{{ $parent->id }}</td>
                    <td>{{ $parent->name }}</td>
                    <td>{{ $parent->created_at->format('Y-m-d') }}</td>
                    <td>
                        <!-- Edit Button -->
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editParentModal{{ $parent->id }}">
                            Edit
                        </button>

                        <!-- Delete Button -->
                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteParentModal{{ $parent->id }}">
                            Delete
                        </button>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editParentModal{{ $parent->id }}" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog">
                    <form action="{{ route('student-parents.update', $parent->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Edit Parent</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>
                          <div class="modal-body">
                              <div class="mb-3">
                                  <label class="form-label">Parent Name</label>
                                  <input type="text" class="form-control" name="name" value="{{ $parent->name }}" required>
                              </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                          </div>
                        </div>
                    </form>
                  </div>
                </div>

                <!-- Delete Modal -->
                <div class="modal fade" id="deleteParentModal{{ $parent->id }}" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog">
                    <form action="{{ route('student-parents.destroy', $parent->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Delete Parent</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>
                          <div class="modal-body">
                              <p>Are you sure you want to delete <strong>{{ $parent->name }}</strong>?</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                          </div>
                        </div>
                    </form>
                  </div>
                </div>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addParentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('student-parents.store') }}" method="POST">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add Parent</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
              <div class="mb-3">
                  <label class="form-label">Parent Name</label>
                  <input type="text" class="form-control" name="name" required>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </div>
    </form>
  </div>
</div>
@endsection
