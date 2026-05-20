<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PiedraPapelController extends Controller
{
    private $opciones = ['piedra', 'papel', 'tijera'];

    public function index()
    {
        if (!session()->has('jugador_puntos')) {
            session([
                'jugador_puntos' => 0,
                'maquina_puntos' => 0,
                'ronda'          => 0,
            ]);
        }

        return view('piedrapapel', [
            'jugador'   => session('jugador_puntos'),
            'maquina'   => session('maquina_puntos'),
            'ronda'     => session('ronda'),
            'mensaje'   => session('mensaje', ''),
            'eleccion_jugador' => session('eleccion_jugador', ''),
            'eleccion_maquina' => session('eleccion_maquina', ''),
        ]);
    }

    public function jugar(Request $request)
    {
        $request->validate(['eleccion' => 'required|in:piedra,papel,tijera']);

        if (session('jugador_puntos') >= 5 || session('maquina_puntos') >= 5) {
            return redirect()->route('ppt.index');
        }

        $jugador = $request->input('eleccion');
        $maquina = $this->opciones[array_rand($this->opciones)];

        if ($jugador === $maquina) {
            $mensaje = "Empate. Ambos eligieron {$jugador}.";
        } elseif (
            ($jugador === 'piedra' && $maquina === 'tijera') ||
            ($jugador === 'papel'  && $maquina === 'piedra') ||
            ($jugador === 'tijera' && $maquina === 'papel')
        ) {
            $mensaje = "¡Ganaste la ronda! {$jugador} vence a {$maquina}.";
            session(['jugador_puntos' => session('jugador_puntos') + 1]);
        } else {
            $mensaje = "Perdiste la ronda. {$maquina} vence a {$jugador}.";
            session(['maquina_puntos' => session('maquina_puntos') + 1]);
        }

        session([
            'ronda'            => session('ronda') + 1,
            'eleccion_jugador' => $jugador,
            'eleccion_maquina' => $maquina,
            'mensaje'          => $mensaje,
        ]);

        if (session('jugador_puntos') >= 5) {
            session(['mensaje' => '🏆 ¡GANASTE LA PARTIDA!']);
        } elseif (session('maquina_puntos') >= 5) {
            session(['mensaje' => '💀 La máquina ganó la partida.']);
        }

        return redirect()->route('ppt.index');
    }

    public function reiniciar()
    {
        session()->flush();
        return redirect()->route('ppt.index');
    }
}