<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonedaController extends Controller
{
    public function index()
    {
        if (!session()->has('monedas')) {
            session(['monedas' => 10, 'tiradas' => 0]);
        }

        return view('moneda', [
            'monedas'   => session('monedas'),
            'tiradas'   => session('tiradas'),
            'resultado' => session('resultado'),
            'mensaje'   => session('mensaje', ''),
        ]);
    }

    public function jugar(Request $request)
    {
        $request->validate(['apuesta' => 'required|in:cara,cruz']);

        $monedas = session('monedas');
        if ($monedas <= 0 || $monedas >= 20) {
            return redirect()->route('moneda.index');
        }

        $apuesta   = $request->input('apuesta');
        $resultado = rand(0, 1) === 0 ? 'cara' : 'cruz';

        if ($apuesta === $resultado) {
            session(['monedas' => $monedas + 1]);
            $mensaje = "✅ ¡Salió {$resultado}! Ganaste 1 moneda.";
        } else {
            session(['monedas' => $monedas - 1]);
            $mensaje = "❌ Salió {$resultado}. Perdiste 1 moneda.";
        }

        if (session('monedas') >= 20) {
            $mensaje = "🏆 ¡GANASTE! Llegaste a 20 monedas.";
        } elseif (session('monedas') <= 0) {
            $mensaje = "💀 Te quedaste sin monedas.";
        }

        session([
            'resultado' => $resultado,
            'tiradas'   => session('tiradas') + 1,
            'mensaje'   => $mensaje,
        ]);

        return redirect()->route('moneda.index');
    }

    public function reiniciar()
    {
        session()->flush();
        return redirect()->route('moneda.index');
    }
}