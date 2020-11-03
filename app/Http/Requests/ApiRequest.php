<?php


namespace App\Http\Requests;


use Illuminate\Http\Request;

interface ApiRequest
{
    public function rules(Request $request);

}
