<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlackjackController extends Controller
{
    public function index()
    {
        if (!session()->has('jugador')) {
            session([
                'jugador'  => [rand(1, 10), rand(1, 10)],
                'banca'    => [],
                'plantado' => false,
                'fin'      => false,
            ]);
        }

        $cartas = session('jugador');
        return view('blackjack', [
            'cartas'   => $cartas,
            'total'    => array_sum($cartas),
            'banca'    => session('banca'),
            'totalB'   => array_sum(session('banca', [])),
            'plantado' => session('plantado'),
            'fin'      => session('fin'),
            'mensaje'  => session('mensaje', ''),
        ]);
    }

    public function pedir()
    {
        if (session('fin') || session('plantado')) {
            return redirect()->route('bj.index');
        }

        $cartas = session('jugador');
        $cartas[] = rand(1, 10);
        session(['jugador' => $cartas]);

        if (array_sum($cartas) > 21) {
            session(['fin' => true, 'mensaje' => "💀 Te pasaste de 21. Perdiste."]);
        }

        return redirect()->route('bj.index');
    }

    public function plantar()
    {
        session(['plantado' => true]);

        $banca = [rand(1, 10), rand(1, 10)];
        while (array_sum($banca) < 17) {
            $banca[] = rand(1, 10);
        }

        $jugador = array_sum(session('jugador'));
        $totalB  = array_sum($banca);

        if ($totalB > 21 || $jugador > $totalB) {
            $mensaje = "🏆 ¡Ganaste! Tú: {$jugador} | Banca: {$totalB}";
        } elseif ($jugador === $totalB) {
            $mensaje = "🤝 Empate. Ambos con {$jugador}";
        } else {
            $mensaje = "💀 Perdiste. Tú: {$jugador} | Banca: {$totalB}";
        }

        session(['banca' => $banca, 'fin' => true, 'mensaje' => $mensaje]);
        return redirect()->route('bj.index');
    }

    public function reiniciar()
    {
        session()->flush();
        return redirect()->route('bj.index');
    }
}