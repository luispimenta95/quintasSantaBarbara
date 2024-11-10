<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Hospede;
use Illuminate\Http\Request;
use App\Models\Reserva;



class MobileController extends Controller
{

    public function reserva()
    {
        return Reserva::all();
    }

    public function getPath(): string{
        return public_path();
    }
}
