@extends('admin.layouts.app')

@section('style')

@endsection

@section('topbar')
    @parent
@endsection

@section('sidebar')
    @parent
@endsection

@section('page-title', 'Employee')

@section('content')
    <a href="{{ url('/admin/employee/create') }}" class="btn btn-primary">Create</a>
    <hr>
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Actions</th>
                <th>Full Name</th>
                <th>Company ID</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $employee)
                <tr>
                    <td>
                        <a href="{{ url('/admin/employee/' . $employee->id . '/edit') }}" class="btn btn-secondary">Edit</a>
                        <a href="{{ url('/admin/employee/' . $employee->id) }}" class="btn btn-info">Show</a>
                        <button class="btn btn-danger delete" data-id="{{ $employee->id }}">Delete</button>
                    </td>
                    <td>{{ $employee->full_name }}</td>
                    <td>{{ $employee->company_id }}</td>
                    <td>{{ $employee->email }}</td>
                    <td> {{ $employee->phone }} </td>
                    <td>{{ $employee->created_at }}</td>
                    <td>{{ $employee->updated_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection

@section('script')

    <script>
        $(document).ready(() => {
            showFlashMessage();
            new DataTable('#example');

            $(document).on('click', '.delete', (event) => {
                let deleteButton = $(event.currentTarget);
                let id = deleteButton.data('id');
                let row = deleteButton.parent().parent();

                console.log(deleteButton);

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    console.log(result);
                    if (result.isConfirmed) {
                        row.remove();
                        deleteRecord(id);
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        );
                    }
                })
            });

            function deleteRecord(id) {
                $.ajax({
                    type: "DELETE",
                    url: "/admin/employee/" + id,
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: (data) => {
                        console.log(data);
                    },
                    error: (error) => {
                        console.log(error);
                    }

                });
            }

            function showFlashMessage() {
                let message = "{{ session()->get('message') }}";
                if (message) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            }
        });
    </script>

@endsection
