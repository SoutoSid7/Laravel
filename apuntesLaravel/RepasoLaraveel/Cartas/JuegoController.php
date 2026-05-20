<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JuegoController extends Controller
{


    // Array de imágenes (las que tengas en public/img)
    private function imagenes()
    {
        return [
            'img/carta1.png',
            'img/carta2.png',
            'img/carta3.png',
            'img/carta4.png',
            'img/carta5.png',
            'img/carta6.png',
            'img/carta7.png',
            'img/carta8.png',
            'img/carta9.png',
            'img/carta10.png',
            'img/carta11.png',
            'img/carta12.png',
        ];
    }

    /**
     * GET / -> muestra la vista con la carta actual
     */
    public function index()
    {
        $imagenes = $this->imagenes();

        // Si es la primera vez, inicializamos sesión
        if (!session()->has('numero_actual')) {
            session([
                'numero_actual' => rand(1, count($imagenes)),
                'racha'         => 0,
                'ganado'        => false,
            ]);
        }

        return view('cartas', [
            'imagenes'      => $imagenes,
            'numero_actual' => session('numero_actual'),
            'racha'         => session('racha'),
            'ganado'        => session('ganado'),
            'mensaje'       => session('mensaje', ''),
        ]);
    }

    /**
     * POST /cartas -> procesa la apuesta "alta" o "baja"
     */
    public function jugar(Request $request)
    {
        $imagenes = $this->imagenes();
        $total    = count($imagenes);

        // Si ya ha ganado, que reinicie antes de seguir
        if (session('ganado', false)) {
            return redirect()->route('juego.index');
        }

        $numeroActual    = session('numero_actual', rand(1, $total));
        $apuesta         = $request->input('apuesta'); // "alta" o "baja"
        $numeroSiguiente = rand(1, $total);

        // Determinamos si ha acertado
        $acierto = false;
        if ($apuesta === 'alta' && $numeroSiguiente > $numeroActual) {
            $acierto = true;
        } elseif ($apuesta === 'baja' && $numeroSiguiente < $numeroActual) {
            $acierto = true;
        }

        if ($acierto) {
            $racha = session('racha', 0) + 1;
            session(['racha' => $racha]);

            if ($racha >= 5) {
                session(['ganado' => true]);
                $mensaje = "¡Has ganado! 5 aciertos seguidos 🎉";
            } else {
                $mensaje = "¡Acierto! Racha: {$racha}/5";
            }
        } else {
            session(['racha' => 0]);
            $mensaje = "Fallaste. El número era {$numeroSiguiente}. Racha reiniciada.";
        }

        // El siguiente número pasa a ser el actual
        session([
            'numero_actual' => $numeroSiguiente,
            'mensaje'       => $mensaje,
        ]);

        return redirect()->route('juego.index');
    }

    /**
     * POST /reiniciar -> reinicia la partida
     */
    public function reiniciar()
    {
        $imagenes = $this->imagenes();

        session([
            'numero_actual' => rand(1, count($imagenes)),
            'racha'         => 0,
            'ganado'        => false,
            'mensaje'       => 'Partida reiniciada.',
        ]);

        return redirect()->route('juego.index');
    }
}