<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarreraController extends Controller
{
    const META = 10;

    public function index()
    {
        if (!session()->has('caballos')) {
            session([
                'caballos'  => [1 => 0, 2 => 0, 3 => 0],
                'apuesta'   => null,
                'ganador'   => null,
            ]);
        }

        return view('carrera', [
            'caballos' => session('caballos'),
            'apuesta'  => session('apuesta'),
            'ganador'  => session('ganador'),
            'meta'     => self::META,
            'mensaje'  => session('mensaje', ''),
        ]);
    }

    public function apostar(Request $request)
    {
        $request->validate(['caballo' => 'required|integer|min:1|max:3']);
        session(['apuesta' => (int) $request->input('caballo')]);
        return redirect()->route('carrera.index');
    }

    public function avanzar()
    {
        if (session('ganador') || !session('apuesta')) {
            return redirect()->route('carrera.index');
        }

        $caballos = session('caballos');
        foreach ($caballos as $id => $pos) {
            $caballos[$id] = $pos + rand(0, 3);
        }

        $ganador = null;
        foreach ($caballos as $id => $pos) {
            if ($pos >= self::META) {
                $ganador = $id;
                break;
            }
        }

        if ($ganador) {
            $mensaje = $ganador === session('apuesta')
                ? "🏆 ¡GANASTE! El caballo {$ganador} llegó primero."
                : "💀 Perdiste. Ganó el caballo {$ganador}, tú apostaste al " . session('apuesta');
            session(['ganador' => $ganador, 'mensaje' => $mensaje]);
        }

        session(['caballos' => $caballos]);
        return redirect()->route('carrera.index');
    }

    public function reiniciar()
    {
        session()->flush();
        return redirect()->route('carrera.index');
    }
}