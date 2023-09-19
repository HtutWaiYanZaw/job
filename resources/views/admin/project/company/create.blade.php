@extends('admin.layouts.app')

@section('style')

@endsection

@section('topbar')
    @parent
@endsection

@section('sidebar')
    @parent
@endsection

@section('page-title', 'Create Company')

@section('content')
    <a href="{{ url('/admin/company') }}" class="btn btn-primary">Go To Back</a>
    <hr>
    <form action="{{ url('admin/company') }}" method="post" enctype="multipart/form-data">
        @csrf()
        <div class="mb-3">
            <label class="form-label">Company Name</label>
            <input type="text" class="form-control" name="company_name" value="{{ old('company_name') }}">
            @if ($errors->has('company_name'))
                <p class="text-danger mt-1">{{ $errors->first('company_name') }}</p>
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="emails" value="{{ old('emails') }}">
            @if ($errors->has('emails'))
                <p class="text-danger mt-1">{{ $errors->first('emails') }}</p>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Logo</label>
            <input type="file" class="form-control" name="logo">
            @if ($errors->has('logo'))
                <p class="text-danger">{{ $errors->first('logo') }}</p>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Website</label>
            <input type="text" class="form-control" name="website" value="{{ old('website') }}">
            @if ($errors->has('website'))
                <p class="text-danger mt-1">{{ $errors->first('website') }}</p>
            @endif
        </div>


        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>

    </form>
@endsection

@section('script')
    <script>
        $(document).ready(() => {
            $('[name="company_name"]').focus();
        });
    </script>

@endsection
