@extends('admin.layouts.app')

@section('style')

@endsection

@section('topbar')
    @parent
@endsection

@section('sidebar')
    @parent
@endsection

@section('page-title','Show employee')

@section('content')
    <a href="{{ url('/admin/employee') }}" class="btn btn-primary">Go To Back</a>
    <hr>

    <table class="table">
        <tbody>
            <tr>
                <td>Full Name</td>
                <td>{{ $data->full_name }}</td>
            </tr>
            <tr>
                <td>CompanyId</td>
                <td>{{ $data->company_id }}</td>
            </tr>
            <tr>
                <td>email</td>
                <td>{{ $data->email }}</td>
            </tr>
            <tr>
                <td>phone</td>
                <td>{{ $data->phone }}</td>
            </tr>
            <tr>
                <td>Created At</td>
                <td>{{ $data->created_at }}</td>
            </tr>
            <tr>
                <td>Updated At</td>
                <td>{{ $data->updated_at }}</td>
            </tr>
        </tbody>
    </table>
@endsection

@section('script')
@endsection
