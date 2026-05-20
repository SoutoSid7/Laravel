<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdivinaNumeroController extends Controller
{
    public function index()
    {
        if (!session()->has('numero_secreto')) {
            session([
                'numero_secreto' => rand(1, 100),
                'intentos'       => 0,
                'max_intentos'   => 7,
                'ganado'         => false,
                'perdido'        => false,
                'historial'      => [],
            ]);
        }

        return view('adivina', [
            'intentos'     => session('intentos'),
            'max_intentos' => session('max_intentos'),
            'ganado'       => session('ganado'),
            'perdido'      => session('perdido'),
            'historial'    => session('historial'),
            'mensaje'      => session('mensaje', ''),
            'numero'       => session('numero_secreto'),
        ]);
    }

    public function jugar(Request $request)
    {
        $request->validate(['numero' => 'required|integer|min:1|max:100']);

        if (session('ganado') || session('perdido')) {
            return redirect()->route('adivina.index');
        }

        $intento  = (int) $request->input('numero');
        $secreto  = session('numero_secreto');
        $intentos = session('intentos') + 1;
        $historial = session('historial', []);

        if ($intento === $secreto) {
            $mensaje = "¡Acertaste en {$intentos} intentos! 🎉";
            session(['ganado' => true]);
        } elseif ($intento < $secreto) {
            $mensaje = "Más alto ⬆️";
        } else {
            $mensaje = "Más bajo ⬇️";
        }

        $historial[] = $intento;

        if ($intentos >= session('max_intentos') && !session('ganado')) {
            $mensaje = "¡Perdiste! El número era {$secreto}.";
            session(['perdido' => true]);
        }

        session([
            'intentos'  => $intentos,
            'historial' => $historial,
            'mensaje'   => $mensaje,
        ]);

        return redirect()->route('adivina.index');
    }

    public function reiniciar()
    {
        session()->flush();
        return redirect()->route('adivina.index');
    }
}