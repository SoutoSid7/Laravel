<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TresRayaController extends Controller
{
    private $combos = [
        [0,1,2],[3,4,5],[6,7,8], // filas
        [0,3,6],[1,4,7],[2,5,8], // columnas
        [0,4,8],[2,4,6]          // diagonales
    ];

    public function index()
    {
        if (!session()->has('tablero')) {
            session([
                'tablero' => array_fill(0, 9, ''),
                'turno'   => 'X',
                'fin'     => false,
            ]);
        }

        return view('tresraya', [
            'tablero' => session('tablero'),
            'fin'     => session('fin'),
            'mensaje' => session('mensaje', ''),
        ]);
    }

    public function jugar(Request $request)
    {
        $request->validate(['casilla' => 'required|integer|min:0|max:8']);

        if (session('fin')) return redirect()->route('tres.index');

        $tablero = session('tablero');
        $casilla = (int) $request->input('casilla');

        if ($tablero[$casilla] !== '') {
            session(['mensaje' => 'Casilla ocupada']);
            return redirect()->route('tres.index');
        }

        // Movimiento del jugador
        $tablero[$casilla] = 'X';

        if ($this->gana($tablero, 'X')) {
            session(['tablero' => $tablero, 'fin' => true, 'mensaje' => '🏆 ¡Ganaste!']);
            return redirect()->route('tres.index');
        }

        if (!in_array('', $tablero)) {
            session(['tablero' => $tablero, 'fin' => true, 'mensaje' => '🤝 Empate']);
            return redirect()->route('tres.index');
        }

        // Movimiento de la máquina (aleatorio en casilla libre)
        $libres = array_keys($tablero, '');
        $jugada = $libres[array_rand($libres)];
        $tablero[$jugada] = 'O';

        if ($this->gana($tablero, 'O')) {
            session(['tablero' => $tablero, 'fin' => true, 'mensaje' => '💀 Ganó la máquina']);
        } elseif (!in_array('', $tablero)) {
            session(['tablero' => $tablero, 'fin' => true, 'mensaje' => '🤝 Empate']);
        } else {
            session(['tablero' => $tablero, 'mensaje' => '']);
        }

        return redirect()->route('tres.index');
    }

    private function gana($tablero, $simbolo)
    {
        foreach ($this->combos as $c) {
            if ($tablero[$c[0]] === $simbolo && $tablero[$c[1]] === $simbolo && $tablero[$c[2]] === $simbolo) {
                return true;
            }
        }
        return false;
    }

    public function reiniciar()
    {
        session()->flush();
        return redirect()->route('tres.index');
    }
}