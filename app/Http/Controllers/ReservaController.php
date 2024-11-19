<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as Database;
use App\Models\Reserva;
use App\Models\Hospede;
use Illuminate\Database\Eloquent\Collection;

class ReservaController extends Controller
{
    public function show()
    {
        $reservas = Reserva::paginate(15);
        foreach ($reservas as $reserva) {
            // Recuperar o ID do primeiro hóspede
            $hospedesArray = json_decode($reserva->hospedes, true);
            $hospedeResponsavelId = intval($hospedesArray[0]);

            // Recuperar o hóspede responsável
            $hospedeResponsavel = Hospede::find($hospedeResponsavelId);

            // Adicionar o hóspede responsável à reserva
            $reserva->hospedeResponsavel = $hospedeResponsavel;
        }
        $preco = config('app.preco');

        return view('reservas.index', ['reservas' => $reservas, 'preco' => $preco]);
    }

    public function getHospedesReserva(Reserva $reserva): Collection
    {
        $hospedes = Hospede::whereIn('id', array_map("intval", json_decode($reserva->hospedes)))->get();
        return $hospedes;
    }
    public function salvarReserva(Request $request, array $params): void
    {
        $informacoesReserva = new Reserva();

        $informacoesReserva->dataInicial = $request->dataInicial;
        $informacoesReserva->dataFinal = $request->dataFinal;
        $informacoesReserva->hospedes = $params['hospedes'];
        $informacoesReserva->camArquivo = $params['camArquivo'];
        $informacoesReserva->qtdDias = $params['qtdDias'];
        $informacoesReserva->valorReserva = $params['qtdDias'] *  config('app.preco');
        $informacoesReserva->save();
    }
}
