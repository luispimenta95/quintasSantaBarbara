<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Hospede;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Http\Controllers\ReservaController as ReservaController;



class AppController extends Controller
{
    public function gerarContrato(Request $request)
    {
        $reservaController = new ReservaController();
        $reserva = Reserva::find($request->id);
        if($reserva){
            $reserva->reservaConfirmada = 1;
            $reserva->save();
        }

        $file = public_path() . '/' . $reserva->camArquivo;
        if (!file_exists($file)) {
            $dados['reserva'] = $reserva;
            $dados['hospedes'] = $reservaController->getHospedesReserva($reserva);


            $this->createFolder(public_path('pdf/reservas/'));
            $data = $this->tratarDadosPdf($dados);


            $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('pdf.document', $data);

            $pdf->save($reserva->camArquivo);
        }

        return response()->download($file);
    }
    private function getDataAtual(): String
    {
        $dia = Carbon::now()->format('d');
        $mes = Carbon::now()->format('m');
        $ano = Carbon::now()->format('Y');
        $months = [
            'Janeiro',
            'Fevereiro',
            'Março',
            'Abril',
            'Maio',
            'Junho',
            'Julho',
            'Agosto',
            'Setembro',
            'Outubro',
            'Novembro',
            'Dezembro'
        ];
        return $dia . ' de ' . $months[$mes - 1] . ' de ' . $ano;
    }

    private function formatarCpf($cpf): String
    {

        $cpf = substr($cpf, 0, 3) . '.' .
            substr($cpf, 3, 3) . '.' .
            substr($cpf, 6, 3) . '-' .
            substr($cpf, 9, 2);

        return $cpf;
    }
    private function tratarDadosPdf(array $params): array
    {
        $hosts = array();
        foreach ($params['hospedes'] as $hospede) {
            $hospede['nascimento'] = date('d/m/Y', strtotime($hospede['nascimento']));
            $hospede['cpf'] = $this->formatarCpf($hospede['cpf']);
            array_push($hosts, $hospede);
        }
        $data = [
            'empresa' => config('app.empresa'),
            'nome' => config('app.nome'),
            'telefone' => config('app.telefone'),
            'cpf' => config('app.cpf'),
            'cidade' => config('app.cidade'),
            'uf' => config('app.uf'),
            'fracao' => config('app.fracao'),
            'numero' => config('app.numero'),
            'bloco' => config('app.bloco'),
            'tipo_quarto' => config('app.tipo'),
            'dia' =>  $this->getDataAtual(),
            'dataInicial' =>  date('d/m/Y', strtotime($params['reserva']['dataInicial'])),
            'dataFinal' =>  date('d/m/Y', strtotime($params['reserva']['dataFinal'])),
            'email' => config('app.email'),
            'preco' => config('app.preco'),
            'hospedes' => $hosts
        ];

        return $data;
    }
    private function createFolder($path)
    {
        //dd($path);
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
    }

    public function login()
    {
        return view('autenticacao.login');
    }
    public function validarLogin(Request $request)
    {
        $credentials = $request->only('cpf', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->route('reservas');
        }
        return redirect()->back()->withErrors('Usuário ou senha inválidos');
    }
}
