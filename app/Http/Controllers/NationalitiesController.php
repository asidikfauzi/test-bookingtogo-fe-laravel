<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Http;
use Alert;
use DataTables;

class NationalitiesController extends Controller
{

    public function index()
    {
       return view('nationality.index');
    }

    public function getDataNationalities()
    {
        try
        {
            $apiUrl = \env('API_URL');
            $response = Http::get($apiUrl.'/nationality');
            $message = '';
            if ($response->ok())
            {
                $data = $response->json();
                return DataTables::of($data['data'])->addIndexColumn()
                    ->addColumn('edit', function($row){
                        return '<a href="'.route('updateNationality',$row['nationality_id']).'" class="btn btn-primary btn-block">
                                    <i class="bi bi-pencil-square"></i>
                                    Edit
                                </a>';
                    })
                    ->addColumn('delete', function($row){
                        return ' <a class="btn btn-danger btn-block modal-deletetab1"
                                        href="#" data-id="'.$row['nationality_id'].'">
                                    <i class="bi bi-trash-fill"></i>
                                    Delete
                                </a>';
                    })
                    ->rawColumns(['edit','delete'])
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
        return view('nationality.create');
    }

    public function store(Request $request)
    {
        try
        {
            $url = \env('API_URL') . '/nationality';

            $data = array(
                "nationality_name" => $request->nationality_name,
                "nationality_code" => $request->nationality_code
            );

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

    }

    public function edit($id)
    {
        $url = \env('API_URL') . "/nationality/". $id;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);

        if ($response) {
            $responseData = json_decode($response, true);
            return view('nationality.edit', compact('responseData'));
        } else {
            $responseData = json_decode($response, true);
            Alert::error($responseData['status'], $responseData['message']);
            return back();
        }

    }

    public function update(Request $request, $id)
    {
        $url = \env('API_URL') . "/nationality/". $id;
        $data = [
            'nationality_name' => $request->nationality_name,
            'nationality_code' => $request->nationality_code
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
            $responseData = json_decode($response, true);
            Alert::success('Success', $responseData['message']);
            return back();
        } else {
            $responseData = json_decode($response, true);
            Alert::success('Error', $responseData['message']);
            return back();
        }


    }

    public function destroy($id)
    {
        $url = \env('API_URL') . "/nationality/". $id;
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
