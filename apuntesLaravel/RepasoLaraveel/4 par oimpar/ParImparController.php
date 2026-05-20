<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParImparController extends Controller
{
    public function index()
    {
        if (!session()->has('aciertos')) {
            session(['aciertos' => 0, 'fallos' => 0, 'numero' => null]);
        }

        return view('parimpar', [
            'aciertos' => session('aciertos'),
            'fallos'   => session('fallos'),
            'numero'   => session('numero'),
            'mensaje'  => session('mensaje', ''),
        ]);
    }

    public function jugar(Request $request)
    {
        $request->validate(['apuesta' => 'required|in:par,impar']);

        if (session('aciertos') >= 5 || session('fallos') >= 3) {
            return redirect()->route('parimpar.index');
        }

        $apuesta = $request->input('apuesta');
        $numero  = rand(1, 20);
        $esPar   = ($numero % 2 === 0);

        $acierto = ($apuesta === 'par' && $esPar) || ($apuesta === 'impar' && !$esPar);

        if ($acierto) {
            session(['aciertos' => session('aciertos') + 1]);
            $mensaje = "¡Acierto! Salió {$numero} (" . ($esPar ? 'par' : 'impar') . ").";
        } else {
            session(['fallos' => session('fallos') + 1]);
            $mensaje = "Fallo. Salió {$numero} (" . ($esPar ? 'par' : 'impar') . ").";
        }

        if (session('aciertos') >= 5) {
            $mensaje = "🏆 ¡GANASTE! 5 aciertos.";
        } elseif (session('fallos') >= 3) {
            $mensaje = "💀 Perdiste. 3 fallos.";
        }

        session(['numero' => $numero, 'mensaje' => $mensaje]);
        return redirect()->route('parimpar.index');
    }

    public function reiniciar()
    {
        session()->flush();
        return redirect()->route('parimpar.index');
    }
}