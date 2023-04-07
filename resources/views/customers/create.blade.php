@extends('layouts.app')
@section('content')
<div class="p-5">
    <a href="{{route('getCustomer')}}">
        <i class="bi bi-arrow-left-circle"></i>
        Back
    </a>
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Create Customer!</h1>
    </div>
    <form method="POST" action="{{route('createCustomer')}}" class="user">
        @csrf
        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="text" name="cst_name" class="form-control form-control-user"
                    placeholder="Customer Name" required>
            </div>
            <div class="col-sm-6">
                <input type="email" name="cst_email" class="form-control form-control-user"
                    placeholder="Email" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-4 mb-3 mb-sm-0">
                <input type="text" name="cst_phone_num" class="form-control form-control-user"
                    placeholder="Nomer Telp" required>
            </div>
            <div class="col-sm-4">
                <input type="date" name="cst_dob" class="form-control form-control-user"
                    placeholder="Date Of Birth" required>
            </div>
            <div class="col-sm-4">
                <select id="nationality_id" name="nationality_id" class="form-control">
                    <option value="">--Choice Nationalities--</option>
                    @foreach ($responseData['data'] as $item)
                    <option value="{{$item['nationality_id']}}">{{$item['nationality_name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <input type="submit" class="btn btn-primary btn-user btn-block" value="Submit">
    </form>
</div>
@endsection
