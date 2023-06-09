<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Http;
use Alert;
use DataTables;

class FamilyListController extends Controller
{

    public function index()
    {
        return view('family-list.index');
    }

    public function getDataFamilyList()
    {
        try
        {
            $apiUrl = \env('API_URL');
            $response = Http::get($apiUrl.'/family-list');
            $message = '';
            if ($response->ok())
            {
                $data = $response->json();
                return DataTables::of($data['data'])->addIndexColumn()
                    ->addColumn('view', function($row){
                        return '<button href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#yourModal">
                                    <i class="bi bi-view-list"></i>
                                </button>';
                    })
                    ->addColumn('edit', function($row){
                        return '<a href="'.route('updateFamilyList',$row['fl_id']).'" class="btn btn-primary btn-block">
                                    <i class="bi bi-pencil-square"></i>
                                </a>';
                    })
                    ->addColumn('delete', function($row){
                        return ' <a class="btn btn-danger btn-block modal-deletetab1"
                                        href="#" data-id="'.$row['fl_id'].'">
                                    <i class="bi bi-trash-fill"></i>
                                </a>';
                    })
                    ->rawColumns(['view','edit','delete'])
                    ->make(true);
            }
            else
            {
                $message = 'Failed to get data from API';
                return view('layouts.error', compact('message'));
            }
        }
        catch (\Exception $e)
        {
            $message = $e->getMessage();
            return view('layouts.error', compact('message'));
        }
    }

    public function create()
    {
        $url = \env('API_URL') . "/customer";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);

        $responseData = json_decode($response, true);

        return view('family-list.create', compact('responseData'));
    }

    public function store(Request $request)
    {
        try
        {
            $url = \env('API_URL') . '/family-list';

            $data = array(
                "cst_id" => (int)$request->cst_id,
                "fl_relation" => $request->fl_relation,
                "fl_name" => $request->fl_name,
                "fl_dob" => $request->fl_dob,
            );

            // dd($data);

            $jsonData = json_encode($data);
            $headers = array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($jsonData)
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            $result = json_decode($response, JSON_PRETTY_PRINT);

            if($result['code'] != 201)
            {
                Alert::error($result['status'], $result['message']);
                return back();
            }

            if (curl_errno($ch)) {
                $error = curl_error($ch);
                curl_close($ch);
                Alert::error('Error', $error);
                return back();
            } else {
                curl_close($ch);
                Alert::success('Success', $result['message']);
                return back();
            }

        }
        catch (\Exception $e)
        {
            $message = $e->getMessage();
            return view('layouts.error', compact('message'));
        }
    }

    public function show($id)
    {
        $url = \env('API_URL') . "/family-list/". $id;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);

        $responseData = json_decode($response, JSON_PRETTY_PRINT);

        // Mengirimkan data dari API response ke view
        return view('family-list.index', compact('responseData'));
    }

    public function edit($id)
    {
        $url = \env('API_URL') . "/family-list/". $id;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);

        $responseData = json_decode($response, JSON_PRETTY_PRINT);

        $url2 = \env('API_URL') . "/customer";

        $ch2 = curl_init();
        curl_setopt($ch2, CURLOPT_URL, $url2);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        $response2 = curl_exec($ch2);
        curl_close($ch2);

        $responseData2 = json_decode($response2, JSON_PRETTY_PRINT);
        return view('family-list.edit', compact('responseData', 'responseData2'));
    }

    public function update(Request $request, $id)
    {
        $url = \env('API_URL') . "/family-list/". $id;
        $data = [
            "cst_id" => (int)$request->cst_id,
            "fl_relation" => $request->fl_relation,
            "fl_name" => $request->fl_name,
            "fl_dob" => $request->fl_dob,
        ];

        $jsonData = json_encode($data);
        $headers = array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        curl_close($ch);

        if ($response) {
            $responseData = json_decode($response, JSON_PRETTY_PRINT);
            Alert::success('Success', $responseData['message']);
            return back();
        } else {
            $responseData = json_decode($response, JSON_PRETTY_PRINT);
            Alert::success('Error', $responseData['message']);
            return back();
        }
    }

    public function destroy($id)
    {
        $url = \env('API_URL') . "/family-list/". $id;
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);

        if ($response === false) {
            $error = curl_error($curl);
            curl_close($curl);
            die('Error: ' . $error);
        }

        curl_close($curl);
    }
}
