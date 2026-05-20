<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SumaController extends Controller
{
    public function index()
    {
        if (!session()->has('num1')) {
            session([
                'num1'    => rand(1, 50),
                'num2'    => rand(1, 50),
                'racha'   => 0,
                'fallos'  => 0,
                'ganado'  => false,
            ]);
        }

        return view('suma', [
            'num1'    => session('num1'),
            'num2'    => session('num2'),
            'racha'   => session('racha'),
            'fallos'  => session('fallos'),
            'ganado'  => session('ganado'),
            'mensaje' => session('mensaje', ''),
        ]);
    }

    public function jugar(Request $request)
    {
        $request->validate(['respuesta' => 'required|integer']);

        if (session('ganado') || session('fallos') >= 3) {
            return redirect()->route('suma.index');
        }

        $respuesta = (int) $request->input('respuesta');
        $correcta  = session('num1') + session('num2');

        if ($respuesta === $correcta) {
            $racha = session('racha') + 1;
            session(['racha' => $racha]);
            $mensaje = "✅ ¡Correcto! Racha: {$racha}/5";
            if ($racha >= 5) {
                session(['ganado' => true]);
                $mensaje = "🏆 ¡GANASTE! 5 sumas seguidas.";
            }
        } else {
            session(['fallos' => session('fallos') + 1, 'racha' => 0]);
            $mensaje = "❌ Incorrecto. Era {$correcta}. Fallos: " . session('fallos') . "/3";
            if (session('fallos') >= 3) {
                $mensaje = "💀 Perdiste. 3 fallos.";
            }
        }

        session([
            'num1'    => rand(1, 50),
            'num2'    => rand(1, 50),
            'mensaje' => $mensaje,
        ]);

        return redirect()->route('suma.index');
    }

    public function reiniciar()
    {
        session()->flush();
        return redirect()->route('suma.index');
    }
}