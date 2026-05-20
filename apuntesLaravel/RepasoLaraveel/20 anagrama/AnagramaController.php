<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnagramaController extends Controller
{
    private $palabras = ['ordenador', 'teclado', 'pantalla', 'raton', 'internet', 'codigo', 'laravel', 'programar'];

    public function index()
    {
        if (!session()->has('palabra')) {
            $palabra     = $this->palabras[array_rand($this->palabras)];
            $desordenada = str_shuffle($palabra);
            session([
                'palabra'     => $palabra,
                'desordenada' => $desordenada,
                'intentos'    => 0,
                'aciertos'    => 0,
                'fin'         => false,
            ]);
        }

        return view('anagrama', [
            'desordenada' => session('desordenada'),
            'intentos'    => session('intentos'),
            'aciertos'    => session('aciertos'),
            'fin'         => session('fin'),
            'palabra'     => session('palabra'),
            'mensaje'     => session('mensaje', ''),
        ]);
    }

    public function jugar(Request $request)
    {
        $request->validate(['intento' => 'required|string']);

        if (session('fin')) {
            return redirect()->route('anagrama.index');
        }

        $intento = strtolower(trim($request->input('intento')));
        $palabra = session('palabra');
        $intentos = session('intentos') + 1;

        if ($intento === $palabra) {
            $aciertos = session('aciertos') + 1;
            session(['aciertos' => $aciertos]);

            if ($aciertos >= 3) {
                session(['fin' => true, 'mensaje' => "🏆 ¡GANASTE! 3 palabras acertadas."]);
            } else {
                $nueva = $this->palabras[array_rand($this->palabras)];
                session([
                    'palabra'     => $nueva,
                    'desordenada' => str_shuffle($nueva),
                    'intentos'    => 0,
                    'mensaje'     => "✅ ¡Correcto! Llevas {$aciertos}/3.",
                ]);
            }
        } else {
            session(['intentos' => $intentos]);
            if ($intentos >= 3) {
                session(['fin' => true, 'mensaje' => "💀 Perdiste. La palabra era: {$palabra}"]);
            } else {
                session(['mensaje' => "❌ Incorrecto. Te quedan " . (3 - $intentos) . " intentos."]);
            }
        }

        return redirect()->route('anagrama.index');
    }

    public function reiniciar()
    {
        session()->flush();
        return redirect()->route('anagrama.index');
    }
}