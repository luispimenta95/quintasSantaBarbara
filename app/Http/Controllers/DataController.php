<?php

namespace App\Http\Controllers;

use DatePeriod;
use DateInterval;
use App\Models\Reserva;

class DataController extends Controller

{
    private $blockedDates = array();
    public function show()
    {

        $reservas = Reserva::all();
        foreach ($reservas as $reserva) {

            $start_date = date_create($reserva->dataInicial);
            $end_date = date_create($reserva->dataFinal);
            $end_date->modify('+1 day');

            $interval = DateInterval::createFromDateString('1 day');
            $daterange = new DatePeriod($start_date, $interval, $end_date);

            // Definindo as datas bloqueadas
            $this->bloquearDatas($daterange);
        }

        $datasBloqueadas = $this->blockedDates;

        return view('hospedes.bloquear-datas', compact('datasBloqueadas'));
    }


    private function bloquearDatas($dr)
    {
        foreach ($dr as $date1) {
            array_push($this->blockedDates, $date1->format("Y-m-d"));
        }
    }
}
