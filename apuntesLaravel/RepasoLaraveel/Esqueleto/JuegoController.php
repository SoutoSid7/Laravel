<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JuegoController extends Controller
{
    /**
     * Carga la vista principal y prepara la sesión si está vacía
     */
    public function index()
    {
        // 1. Inicializar la sesión la primera vez que se entra
        if (!session()->has('iniciado')) {
            session([
                'iniciado' => true,
                'puntos'   => 0,
                'racha'    => 0,
                'ganado'   => false,
                'estado'   => 'jugando', // puede ser 'jugando', 'ganado', 'perdido'
                // Aquí metes tus arrays (ej. baraja, historial, etc.)
            ]);
        }

        // 2. Devolver la vista pasándole variables (opcional, también puedes usar session() directo en Blade)
        return view('juego');
    }

    /**
     * Procesa la acción del usuario
     */
    public function jugar(Request $request)
    {
        // 1. Validar la entrada (Descomenta y adapta lo que necesites)
        $request->validate([
            'apuesta' => 'required',
            // 'numero' => 'required|integer|min:1|max:10',
        ]);

        // 2. Cortafuegos: Si el juego ya acabó, no dejar jugar
        if (session('ganado') || session('estado') === 'perdido') {
            return redirect()->route('juego.index')->with('error', 'La partida ha terminado, reinicia para volver a jugar.');
        }

        // 3. Recuperar datos actuales de la sesión y del formulario
        $apuesta = $request->input('apuesta');
        $puntos = session('puntos');
        
        // --- 4. LÓGICA DEL JUEGO (REEMPLAZAR ESTO) ---
        $acierto = true; // Aquí tu condición (ej. $apuesta == $numeroSecreto)
        
        if ($acierto) {
            // Modificamos datos
            $puntos += 1;
            
            // Comprobamos victoria
            if ($puntos >= 5) {
                session(['ganado' => true, 'puntos' => $puntos, 'estado' => 'ganado']);
                return redirect()->route('juego.index')->with('exito', '¡Enhorabuena, has ganado la partida!');
            }

            // Guardamos progreso si no ha ganado aún
            session(['puntos' => $puntos]);
            return redirect()->route('juego.index')->with('exito', '¡Acertaste! Sigue así.');
            
        } else {
            // Penalización o derrota
            session(['estado' => 'perdido']);
            return redirect()->route('juego.index')->with('error', 'Has fallado. Fin de la partida.');
        }
    }

    /**
     * Reinicia toda la partida limpiando la sesión
     */
    public function reiniciar()
    {
        // Si necesitas guardar algo (como un récord), sácalo antes del flush
        // $mejor_record = session('mejor_record');
        
        session()->flush(); // Borra todo
        
        // session(['mejor_record' => $mejor_record]); // Lo vuelves a meter

        return redirect()->route('juego.index')->with('exito', 'Partida reiniciada.');
    }
}