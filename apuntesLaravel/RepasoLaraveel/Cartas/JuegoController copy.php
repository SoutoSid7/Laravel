<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request; // Clase nativa de Laravel para recoger datos de los formularios (inputs)

class JuegoController extends Controller
{
    // MÉTODO PRIVADO: Devuelve un array (una lista) con las rutas de las imágenes de las cartas.
    // Lo pones privado porque solo se va a usar "por dentro" de este controlador.
    private function imagenes()
    {
        return [
            'img/carta1.png', 'img/carta2.png', 'img/carta3.png', 
            // ... hasta la carta 12
        ];
    }

    /* =========================================
       MÉTODO INDEX: Carga la vista principal
       ========================================= */
    public function index()
    {
        $imagenes = $this->imagenes(); // Guarda el array de imágenes en una variable

        // session()->has() comprueba si NO existe la variable 'numero_actual' en la sesión.
        // Si no existe, significa que el usuario acaba de entrar por primera vez.
        if (!session()->has('numero_actual')) {
            // Inicializa las variables básicas del juego en la sesión para que no se pierdan
            session([
                'numero_actual' => rand(1, count($imagenes)), // Saca una carta al azar entre 1 y 12
                'racha'         => 0,                         // Puntuación empieza en 0
                'ganado'        => false,                     // Estado del juego
            ]);
        }

        // view() llama al archivo 'cartas.blade.php'. El array que le pasamos al lado 
        // son los datos que le "inyectamos" a la vista para que pueda dibujarlos.
        return view('cartas', [
            'imagenes'      => $imagenes,
            'numero_actual' => session('numero_actual'), // Pilla la carta actual de la sesión
            'racha'         => session('racha'),
            'ganado'        => session('ganado'),
            'mensaje'       => session('mensaje', ''),   // El '' es por si no hay mensaje, que no dé error
        ]);
    }

    /* =========================================
       MÉTODO JUGAR: Procesa la apuesta
       ========================================= */
    public function jugar(Request $request)
    {
        $imagenes = $this->imagenes();
        $total    = count($imagenes); // Cuenta que hay 12 cartas

        // CORTAFUEGOS: Si en la sesión consta que ya ganó, le impide seguir jugando
        // y lo devuelve a la pantalla principal automáticamente.
        if (session('ganado', false)) {
            return redirect()->route('juego.index');
        }

        // Rescata de la sesión la carta actual que el usuario estaba viendo
        $numeroActual    = session('numero_actual', rand(1, $total));
        
        // $request->input('apuesta') atrapa lo que el usuario pulsó en el formulario (value="alta" o "baja")
        $apuesta         = $request->input('apuesta'); 
        
        // El programa saca la carta "misteriosa" que va a salir ahora
        $numeroSiguiente = rand(1, $total);

        $acierto = false; // Empezamos asumiendo que ha fallado

        // LÓGICA DE JUEGO: 
        // Si apostó 'alta' y la nueva carta es mayor, acierta.
        if ($apuesta === 'alta' && $numeroSiguiente > $numeroActual) {
            $acierto = true;
        // Si apostó 'baja' y la nueva carta es menor, acierta.
        } elseif ($apuesta === 'baja' && $numeroSiguiente < $numeroActual) {
            $acierto = true;
        }

        // ¿Qué pasa si acierta?
        if ($acierto) {
            // Suma 1 a la racha actual que había en sesión
            $racha = session('racha', 0) + 1;
            session(['racha' => $racha]); // Lo guarda actualizado

            if ($racha >= 5) { // Si llega a 5, gana la partida
                session(['ganado' => true]);
                $mensaje = "¡Has ganado! 5 aciertos seguidos 🎉";
            } else { // Si no llega a 5, simplemente avisa del acierto
                $mensaje = "¡Acierto! Racha: {$racha}/5";
            }
        } 
        // ¿Qué pasa si falla o hay un empate?
        else {
            session(['racha' => 0]); // Resetea la puntuación a 0
            $mensaje = "Fallaste. El número era {$numeroSiguiente}. Racha reiniciada.";
        }

        // ACTUALIZACIÓN DE SESIÓN FINAL:
        // La carta que acabamos de sacar pasa a ser la carta visible para el siguiente turno
        session([
            'numero_actual' => $numeroSiguiente,
            'mensaje'       => $mensaje,
        ]);

        // Redirige por GET a la vista principal (evita el error de "Reenviar formulario" si pulsas F5)
        return redirect()->route('juego.index');
    }

    /* =========================================
       MÉTODO REINICIAR: Resetea el juego a mano
       ========================================= */
    public function reiniciar()
    {
        $imagenes = $this->imagenes();

        // Pisa (sobrescribe) los valores de la sesión para empezar todo a cero
        session([
            'numero_actual' => rand(1, count($imagenes)),
            'racha'         => 0,
            'ganado'        => false,
            'mensaje'       => 'Partida reiniciada.',
        ]);

        // Lo manda de nuevo a la pantalla de jugar
        return redirect()->route('juego.index');
    }
}