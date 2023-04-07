@extends('layouts.app')
@section('content')
<div class="p-5">
    <a href="{{route('getNationality')}}">
        <i class="bi bi-arrow-left-circle"></i>
        Back
    </a>
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Edit Nationality!</h1>
    </div>
    <form method="POST" action="{{route('updateNationality', $responseData['data']['nationality_id'])}}" class="user">
        @csrf
        @method('PUT')
        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="text" name="nationality_name" class="form-control form-control-user"
                    id="exampleFirstName" value="{{$responseData['data']['nationality_name']}}">
            </div>
            <div class="col-sm-6">
                <input type="text" name="nationality_code" class="form-control form-control-user"
                    maxlength="2" id="exampleLastName" value="{{$responseData['data']['nationality_code']}}">
            </div>
        </div>
        <input type="submit" class="btn btn-primary btn-user btn-block" value="Submit">
    </form>
</div>
@endsection
