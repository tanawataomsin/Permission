@extends('layouts.app')

@section('title', 'Permission Edit')

@section('contents')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card-header">
                    <h4>
                        <a href="{{ url('permissions') }}" class="btn btn-danger float-end">Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form id="editPermissionForm" action="{{ url('permissions/' . $permission->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name">Permission name</label>
                            <input type="text" name="name" value="{{ $permission->name }}" class="form-control" />
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
                    var form = $('#editPermissionForm');
                    $.ajax({
                        url: form.attr('action'),
                        type: 'POST',
                        data: form.serialize(),
                        success: function(response) {
                            Swal.fire(
                                'Updated!',
                                'The permission has been updated.',
                                'success'
                            ).then(() => {
                                window.location.href = '/permissions';
                            });
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'An error occurred while updating the permission.',
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>
@endsection
