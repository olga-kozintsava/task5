<?php

namespace App\Http\Controllers;

use App\Canvas;
use Illuminate\Http\Request;

class MainPageController extends Controller
{
    public function get()
    {
        return view('main');
    }

    public function save(Request $request)
    {
        $canvas  =new Canvas;
        $canvas->data = json_encode($request->all());
        $canvas->save();
    }


}
