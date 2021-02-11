<?php namespace App\Http\Controllers;


use Illuminate\Http\Request;

class TestController extends Controller
{
    public function emailConfirmation(Request $request){

        return abort(400, 'already_verified');
    }

}