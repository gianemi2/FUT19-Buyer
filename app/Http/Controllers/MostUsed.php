<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use duzun\hQuery;

class MostUsed extends Controller
{
    public function mostUsed(){
        return view('sbc');
    }
}
