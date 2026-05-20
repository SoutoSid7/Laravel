<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MayorMenor5Controller extends Controller
{
    public function index()
    {
        if (!session()->has('aciertos')) {
            session(['aciertos' => 0, 'fallos' => 0]);
        }

        return view('mayormenor5', [
            'aciertos' => session('aciertos'),
            'fallos'   => session('fallos'),
            'numero'   => session('numero'),
            'mensaje'  => session('mensaje', ''),
        ]);
    }

    public function jugar(Request $request)
    {
        $request->validate(['apuesta' => 'required|in:mayor,menor']);

        $numero = rand(1, 10);
        $apuesta = $request->input('apuesta');

        // El 5 es empate (ni mayor ni menor que 5)
        if ($numero === 5) {
            $mensaje = "🤝 Salió 5. Empate.";
        } elseif (($apuesta === 'mayor' && $numero > 5) || ($apuesta === 'menor' && $numero < 5)) {
            session(['aciertos' => session('aciertos') + 1]);
            $mensaje = "✅ ¡Acertaste! Salió {$numero}.";
        } else {
            session(['fallos' => session('fallos') + 1]);
            $mensaje = "❌ Fallaste. Salió {$numero}.";
        }

        session(['numero' => $numero, 'mensaje' => $mensaje]);
        return redirect()->route('mm5.index');
    }

    public function reiniciar()
    {
        session()->flush();
        return redirect()->route('mm5.index');
    }
}