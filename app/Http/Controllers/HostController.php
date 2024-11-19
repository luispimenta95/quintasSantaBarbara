<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as Database;
use App\Http\Controllers\ReservaController as Reserva;
use App\Models\Hospede;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;
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

            $interval = DateInterval::createFromDateString('1 day');
            $daterange = new DatePeriod($start_date, $interval, $end_date);
            // TipoBloqueio = 1 se data estiver reservada e paga, 2 se data estiver apenas confirmada
            if ($reserva->reservaConfirmada == 1) {
                $tipoBloqueio = 1;
            } else {
                $tipoBloqueio = 2;
            }

            // Definindo as datas bloqueadas
            $this->bloquearDatas($daterange, $tipoBloqueio);
        }


        $datasConfirmadas = $this->reservasAgendadas;
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

            foreach ($cpf as $i => $cpfItem) {
                // Verifique se o CPF já existe no banco de dados
                $hospedeExistente = Hospede::where('cpf', $cpfItem)->first();

                if ($hospedeExistente) {
                    // Atualize o registro existente
                    $hospedeExistente->update([
                        'nome' => $nome[$i],
                        'cpf' => $cpfItem,
                        'nascimento' => $nascimento[$i],
                        'email' => $email[$i],
                        'telefone' => $telefone[$i]
                    ]);
                } else {
                    // Crie um novo registro
                    $hospede = new Hospede([
                        'nome' => $nome[$i],
                        'cpf' => $cpfItem,
                        'nascimento' => $nascimento[$i],
                        'email' => $email[$i],
                        'telefone' => $telefone[$i]
                    ]);
                    $hospede->save();
                }
            }

            $lastId = count(Hospede::all());
            array_push($idsHospedes, $lastId);
            array_push($hospedes, $informacoesHospedes);
        }
        //Iinformacoes Hospedes
        $data['dataInicial'] = $request->dataInicial;
        $data['dataFinal'] = $request->dataFinal;
        $data['hospedes'] = $hospedes;
        $data['camArquivo'] = public_path('pdf/reservas/');
        $data['nomePdf'] = 'Reserva_' . date("d_m_Y_his") . ".pdf";

        $toDate = Carbon::parse($request->dataInicial);
        $fromDate = Carbon::parse($request->dataFinal);
        $dateRange = $toDate->diffInDays($fromDate) + 1;
        $dadosReserva['qtdDias'] = $dateRange;

        // Fim das informacoes hospedes

        //Reserva
        $dadosReserva['hospedes'] = json_encode($idsHospedes);
        $dadosReserva['camArquivo'] = 'pdf/reservas/' . $data['nomePdf'];
        $reserva = new Reserva();
        $reserva->salvarReserva($request, $dadosReserva);
        //Fim reserva
        return redirect('/iniciar-reserva');
    }

    private function bloquearDatas($dr, $tipoBloqueio)
    {
        foreach ($dr as $date1) {
            if ($tipoBloqueio == 1) {
                array_push($this->blockedDates, $date1->format("Y-m-d"));
            } else {
                array_push($this->reservasAgendadas, $date1->format("Y-m-d"));
            }
        }
    }
}
