<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JuegoController extends Controller
{
    public function index()
    {
        // 1. Mantener el ranking siempre vivo (incluso si no hay partida)
        if (!session()->has('ranking')) {
            session(['ranking' => []]);
        }

        // 2. Inicializar partida si no hay mazo
        if (!session()->has('mazo')) {
            $mazo = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
            shuffle($mazo); // Barajamos el mazo
            
            // array_shift saca el primer elemento y lo ELIMINA del array
            $primera_carta = array_shift($mazo);

            session([
                'mazo' => $mazo,
                'carta_actual' => $primera_carta,
                'racha' => 0,
                'inicio' => now(), // Guardamos el momento exacto en el que empieza
                'ganado' => false,
            ]);
        }

        return view('juego');
    }

    public function jugar(Request $request)
    {
        // 1. Validación estricta
        $request->validate([
            'apuesta' => 'required|in:mayor,menor'
        ]);

        // Evitar que sigan jugando si ya ganaron
        if (session('ganado')) {
            return redirect()->route('juego.index')->with('error', 'Ya has ganado, reinicia la partida.');
        }

        // Recuperar datos de sesión
        $mazo = session('mazo');
        $carta_actual = session('carta_actual');
        $apuesta = $request->input('apuesta');

        // Sacar la siguiente carta del mazo y actualizar el mazo
        $siguiente_carta = array_shift($mazo);

        // Lógica de acierto (si sale igual, lo tomamos como fallo por mala suerte)
        $acierto = false;
        if ($apuesta === 'mayor' && $siguiente_carta > $carta_actual) $acierto = true;
        if ($apuesta === 'menor' && $siguiente_carta < $carta_actual) $acierto = true;

        if ($acierto) {
            $racha = session('racha') + 1;

            if ($racha == 5) { // Condición de victoria
                // Calcular tiempo transcurrido en segundos
                $segundos = now()->diffInSeconds(session('inicio'));

                // Actualizar ranking (Top 3 de tiempos más rápidos)
                $ranking = session('ranking');
                $ranking[] = $segundos;
                sort($ranking); // Ordenamos de menor a mayor (menos tiempo = mejor)
                $ranking = array_slice($ranking, 0, 3); // Nos quedamos solo con los 3 primeros

                session([
                    'ganado' => true,
                    'ranking' => $ranking,
                    'racha' => $racha,
                    'carta_actual' => $siguiente_carta,
                    'mazo' => $mazo
                ]);

                // Mensaje FLASH de éxito
                return redirect()->route('juego.index')
                    ->with('exito', "¡Ganaste en $segundos segundos!");
            } else {
                // Sigue jugando
                session([
                    'racha' => $racha,
                    'carta_actual' => $siguiente_carta,
                    'mazo' => $mazo
                ]);
                
                return redirect()->route('juego.index')
                    ->with('exito', '¡Acertaste! Sigue así.');
            }
        } else {
            // Falló la apuesta. Borramos la partida actual PERO conservamos el ranking.
            $ranking = session('ranking');
            session()->flush(); 
            session(['ranking' => $ranking]); // Devolvemos el ranking a la sesión limpia

            return redirect()->route('juego.index')
                ->with('error', "Fallaste. La carta era un $siguiente_carta. ¡Vuelve a empezar!");
        }
    }

    public function reiniciar()
    {
        
    }
}