<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RuletaController extends Controller
{
    public function index()
    {
        if (!session()->has('puntos')) {
            session(['puntos' => 100, 'tiradas' => 0]);
        }

        return view('ruleta', [
            'puntos'  => session('puntos'),
            'tiradas' => session('tiradas'),
            'color'   => session('color'),
            'mensaje' => session('mensaje', ''),
        ]);
    }

    public function jugar(Request $request)
    {
        $request->validate([
            'apuesta_color' => 'required|in:rojo,negro',
            'cantidad'      => 'required|integer|min:1',
        ]);

        $puntos = session('puntos');

        if ($puntos <= 0 || $puntos >= 500) {
            return redirect()->route('ruleta.index');
        }

        $cantidad = (int) $request->input('cantidad');
        if ($cantidad > $puntos) {
            session(['mensaje' => "No tienes tantos puntos."]);
            return redirect()->route('ruleta.index');
        }

        $apuestaColor = $request->input('apuesta_color');
        $colorSalido  = rand(0, 1) === 0 ? 'rojo' : 'negro';

        if ($apuestaColor === $colorSalido) {
            session(['puntos' => $puntos + $cantidad]);
            $mensaje = "✅ ¡Salió {$colorSalido}! Ganaste {$cantidad} puntos.";
        } else {
            session(['puntos' => $puntos - $cantidad]);
            $mensaje = "❌ Salió {$colorSalido}. Perdiste {$cantidad} puntos.";
        }

        if (session('puntos') >= 500) {
            $mensaje = "🏆 ¡GANASTE! Llegaste a 500 puntos.";
        } elseif (session('puntos') <= 0) {
            $mensaje = "💀 Te quedaste sin puntos.";
        }

        session([
            'color'   => $colorSalido,
            'tiradas' => session('tiradas') + 1,
            'mensaje' => $mensaje,
        ]);

        return redirect()->route('ruleta.index');
    }

    public function reiniciar()
    {
        session()->flush();
        return redirect()->route('ruleta.index');
    }
}