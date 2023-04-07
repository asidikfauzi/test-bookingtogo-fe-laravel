@extends('layouts.app')
@section('content')
<div class="p-5">
    <a href="{{route('getNationality')}}">
        <i class="bi bi-arrow-left-circle"></i>
        Back
    </a>
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Create Nationality!</h1>
    </div>
    <form method="POST" action="{{route('createNationality')}}" class="user">
        @csrf
        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="text" name="nationality_name" class="form-control form-control-user"
                    placeholder="Nationality Name" required>
            </div>
            <div class="col-sm-6">
                <input type="text" name="nationality_code" class="form-control form-control-user"
                    maxlength="2" placeholder="Nationality Code" required>
            </div>
        </div>
        <input type="submit" class="btn btn-primary btn-user btn-block" value="Submit">
    </form>
</div>
@endsection
