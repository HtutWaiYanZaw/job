@extends('admin.layouts.app')

@section('style')

@endsection

@section('topbar')
    @parent
@endsection

@section('sidebar')
    @parent
@endsection

@section('page-title','Create Employee')

@section('content')

    <a href="{{ url('/admin/employee') }}" class="btn btn-primary">Go To Back</a>
    <hr>
    <form action="{{ url('admin/employee') }}" method="post" novalidate>
        @csrf()
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" class="form-control" name="full_name"
            value="{{ old('full_name') }}">
            @if($errors->has('full_name'))
                <p class="text-danger mt-1">{{ $errors->first('full_name')}}</p>
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label">CompanyId</label>
            <input type="number" class="form-control" name="company_id"
            value="{{ old('company_id') }}">
            @if($errors->has('company_id'))
                <p class="text-danger mt-1">{{ $errors->first('company_id')}}</p>
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="emails"
            value="{{ old('emails') }}">
            @if($errors->has('emails'))
                <p class="text-danger mt-1">{{ $errors->first('emails')}}</p>
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label">phone</label>
            <input type="number" class="form-control" name="phone"
            value="{{ old('phone') }}">
            @if($errors->has('phone'))
                <p class="text-danger mt-1">{{ $errors->first('phone')}}</p>
            @endif
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
@endsection

@section('script')
    <script>
        $(document).ready(()=>{
            $('[name="full_name"]').focus();
        });
    </script>

@endsection
