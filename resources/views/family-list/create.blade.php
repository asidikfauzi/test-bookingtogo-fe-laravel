@extends('layouts.app')
@section('content')
<div class="p-5">
    <a href="{{route('getFamilyList')}}">
        <i class="bi bi-arrow-left-circle"></i>
        Back
    </a>
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Create Family List!</h1>
    </div>
    <form method="POST" action="{{route('createFamilyList')}}" class="user">
        @csrf
        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="text" name="fl_relation" class="form-control form-control-user"
                    placeholder="Relation" required>
            </div>
            <div class="col-sm-6">
                <input type="text" name="fl_name" class="form-control form-control-user"
                    placeholder="Name" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-6">
                <input type="date" name="fl_dob" class="form-control form-control-user"
                    placeholder="Date Of Birth" required>
            </div>
            <div class="col-sm-6">
                <select id="cst_id" name="cst_id" class="form-control">
                    <option value="">--Choice Nationalities--</option>
                    @foreach ($responseData['data'] as $item)
                    <option value="{{$item['cst_id']}}">{{$item['cst_name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <input type="submit" class="btn btn-primary btn-user btn-block" value="Submit">
    </form>
</div>
@endsection
