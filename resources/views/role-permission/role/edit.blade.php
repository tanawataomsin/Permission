@extends('layouts.app')

@section('title', 'Edit Role')

@section('contents')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card-header">
                    <h4>
                        <a href="{{ url('roles') }}" class="btn btn-danger float-end">Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form id="editRoleForm" action="{{ url('roles/' . $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name">Role name</label>
                            <input type="text" name="name" value="{{ $role->name }}" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-primary" onclick="submitForm()">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function submitForm() {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to submit the changes?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = $('#editRoleForm');
                    $.ajax({
                        url: form.attr('action'),
                        type: 'POST',
                        data: form.serialize(),
                        success: function(response) {
                            Swal.fire(
                                'Updated!',
                                'The role has been updated.',
                                'success'
                            ).then(() => {
                                window.location.href = '/roles';
                            });
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'An error occurred while updating the role.',
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>
@endsection
