<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as Database;
use App\Http\Controllers\ReservaController as Reserva;

class HostController extends Controller
{
    public function index()
    {
        return view('hospedes.index');
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
        $data['nomePdf'] = 'Reserva_' . date("Y_m_d_his") . ".pdf";
        // Fim das informacoes hospedes

        //Reserva
        $dadosReserva['hospedes'] = json_encode($idsHospedes);
        $dadosReserva['camArquivo'] = 'pdf/reservas/' . $data['nomePdf'];
        $reserva = new Reserva();
        $reserva->salvarReserva($request, $dadosReserva);
        //Fim reserva

        return view('hospedes.index');
    }
}
