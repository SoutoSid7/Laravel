<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParImparSimpleController extends Controller
{
    public function index()
    {
        if (!session()->has('aciertos')) {
            session(['aciertos' => 0, 'fallos' => 0]);
        }

        return view('parimpar_simple', [
            'aciertos' => session('aciertos'),
            'fallos'   => session('fallos'),
            'numero'   => session('numero'),
            'mensaje'  => session('mensaje', ''),
        ]);
    }

    public function jugar(Request $request)
    {
        $request->validate(['apuesta' => 'required|in:par,impar']);

        $numero = rand(1, 100);
        $esPar  = ($numero % 2 === 0);
        $apuesta = $request->input('apuesta');

        if (($apuesta === 'par' && $esPar) || ($apuesta === 'impar' && !$esPar)) {
            session(['aciertos' => session('aciertos') + 1]);
            $mensaje = "✅ ¡Acertaste! Salió {$numero}.";
        } else {
            session(['fallos' => session('fallos') + 1]);
            $mensaje = "❌ Fallaste. Salió {$numero}.";
        }

        session(['numero' => $numero, 'mensaje' => $mensaje]);
        return redirect()->route('parimparsimple.index');
    }

    public function reiniciar()
    {
        session()->flush();
        return redirect()->route('parimparsimple.index');
    }
}