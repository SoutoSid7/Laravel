<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JuegoCartasController extends Controller
{
    public function index()
    {
        if (!session()->has('usuario')) {
            session(['usuario' => 'Luison']); // Usuario del examen [cite: 45, 53, 78]
        }

        // Inicializamos la baraja SOLO si no hay una partida activa Y tampoco estamos mostrando un resultado
        if (!session()->has('baraja') && !session()->has('resultado')) {
            $cartas_disponibles = ['carta_copas.png', 'carta_oros.png', 'carta_espadas.png'];
            $baraja = array_merge($cartas_disponibles, $cartas_disponibles); // Parejas de 2 [cite: 47]
            shuffle($baraja); // Combinación aleatoria [cite: 47]

            session([
                'baraja' => $baraja,
                'intentos' => 0, // Cartas levantadas empieza vacío/0 [cite: 48]
                'carta_volteada' => null
            ]);
        }

        return view('juego'); // Apunta a una única vista: resources/views/juego.blade.php
    }

    public function levantar(Request $request)
    {
        $request->validate(['posicion' => 'required|integer|min:1|max:6']);
        
        session(['intentos' => session('intentos') + 1]); // Incrementa cartas levantadas [cite: 52]
        session(['carta_volteada' => $request->input('posicion')]); // Guarda cuál se voltea 

        return redirect()->route('juego.index');
    }

    public function comprobar(Request $request)
    {
        $request->validate([
            'pos1' => 'required|integer|min:1|max:6',
            'pos2' => 'required|integer|min:1|max:6',
        ]);

        $pos1 = $request->input('pos1');
        $pos2 = $request->input('pos2');
        $baraja = session('baraja');

        // Lógica de acierto (restando 1 por el índice 0 del array)
        $acierto = false;
        if ($pos1 != $pos2 && $baraja[$pos1 - 1] === $baraja[$pos2 - 1]) {
            $acierto = true;
        }

        // Guardamos la información del resultado en la sesión
        session([
            'resultado' => [
                'pos1' => $pos1,
                'pos2' => $pos2,
                'acierto' => $acierto,
                'intentos' => session('intentos')
            ]
        ]);

        // Olvidamos los datos de la partida actual para congelar el estado y forzar reinicio al terminar
        session()->forget(['baraja', 'intentos', 'carta_volteada']);

        return redirect()->route('juego.index');
    }

    public function reiniciar()
    {
        // Limpiamos absolutamente todo para empezar de cero por completo
        session()->forget(['baraja', 'intentos', 'carta_volteada', 'resultado']);
        return redirect()->route('juego.index');
    }
}