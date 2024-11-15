<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as Database;
use App\Http\Controllers\ReservaController as Reserva;
use DatePeriod;
use DateInterval;
use App\Models\Reserva as ReservaModel;

class HostController extends Controller
{
    private $blockedDates = array();
    private $reservasAgendadas = array();

    public function index()
    {

        $reservas = ReservaModel::all();
        foreach ($reservas as $reserva) {

            $start_date = date_create($reserva->dataInicial);
            $end_date = date_create($reserva->dataFinal);
            $end_date->modify('+1 day');

            $interval = DateInterval::createFromDateString('1 day');
            $daterange = new DatePeriod($start_date, $interval, $end_date);

            // Definindo as datas bloqueadas
            $this->bloquearDatas($daterange);
        }

        $datasConfirmadas = ['2024-12-25', '2024-12-31'];
        $this->reservasAgendadas = $datasConfirmadas;
        $datasBloqueadas = $this->blockedDates;
        return view('hospedes.index', compact('datasBloqueadas', 'datasConfirmadas'));
    }
    public function receberDados(Request $request)
    {
        $nome = $request->nome;
        $cpf = $request->cpf;
        $nascimento = $request->nascimento;
        $email = $request->email;
        $telefone = $request->telefone;



        $hospedes = array();
        $idsHospedes = array();

        for ($i = 0; $i < count($nome); $i++) {
            $informacoesHospedes = [
                'nome' => $nome[$i],
                'cpf' => $cpf[$i],
                'nascimento' => $nascimento[$i],
                'email' => $email[$i],
                'telefone' => $telefone[$i]
            ];
            $lastId = Database::table('hospedes')->insertGetId($informacoesHospedes);
            array_push($idsHospedes, $lastId);
            array_push($hospedes, $informacoesHospedes);
        }
        //Iinformacoes Hospedes
        $data['dataInicial'] = $request->dataInicial;
        $data['dataFinal'] = $request->dataFinal;
        $data['hospedes'] = $hospedes;
        $data['camArquivo'] = public_path('pdf/reservas/');
        $data['nomePdf'] = 'Reserva_' . date("d_m_Y_his") . ".pdf";
        // Fim das informacoes hospedes

        //Reserva
        $dadosReserva['hospedes'] = json_encode($idsHospedes);
        $dadosReserva['camArquivo'] = 'pdf/reservas/' . $data['nomePdf'];
        $reserva = new Reserva();
        $reserva->salvarReserva($request, $dadosReserva);
        //Fim reserva

        $datasBloqueadas = $this->blockedDates;
        $datasConfirmadas = $this->reservasAgendadas;
        return view('hospedes.index', compact('datasBloqueadas', 'datasConfirmadas'));
    }

    private function bloquearDatas($dr)
    {
        foreach ($dr as $date1) {
            array_push($this->blockedDates, $date1->format("Y-m-d"));
        }
    }
}
