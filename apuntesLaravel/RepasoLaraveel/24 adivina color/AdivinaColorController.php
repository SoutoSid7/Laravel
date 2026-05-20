<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdivinaColorController extends Controller
{
    private $colores = ['rojo', 'verde', 'azul'];

    public function index()
    {
        if (!session()->has('color_secreto')) {
            session([
                'color_secreto' => $this->colores[array_rand($this->colores)],
                'aciertos' => 0,
                'intentos' => 0,
            ]);
        }

        return view('adivina_color', [
            'aciertos' => session('aciertos'),
            'intentos' => session('intentos'),
            'mensaje'  => session('mensaje', ''),
            'colores'  => $this->colores,
        ]);
    }

    public function jugar(Request $request)
    {
        $request->validate(['color' => 'required|in:rojo,verde,azul']);

        $apuesta = $request->input('color');
        $secreto = session('color_secreto');
        $intentos = session('intentos') + 1;

        if ($apuesta === $secreto) {
            $mensaje = "✅ ¡Acertaste! Era {$secreto}.";
            session(['aciertos' => session('aciertos') + 1]);
        } else {
            $mensaje = "❌ Era {$secreto}, elegiste {$apuesta}.";
        }

        // Nuevo color para la próxima ronda
        session([
            'color_secreto' => $this->colores[array_rand($this->colores)],
            'intentos' => $intentos,
            'mensaje' => $mensaje,
        ]);

        return redirect()->route('adivinacolor.index');
    }

    public function reiniciar()
    {
        session()->flush();
        return redirect()->route('adivinacolor.index');
    }
}