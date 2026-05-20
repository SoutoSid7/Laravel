<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BarajaController extends Controller
{
    private array $cartas = [
        /**
         *  Guarda las cartas cada carta tiene:
         * 'numero' => 5
         * 'imagen' => 5.png
         * */ 

        ['numero' => 1, 'imagen' => '1.png'],
        ['numero' => 2, 'imagen' => '2.png'],
        ['numero' => 3, 'imagen' => '3.png'],
        ['numero' => 4, 'imagen' => '4.png'],
        ['numero' => 5, 'imagen' => '5.png'],
        ['numero' => 6, 'imagen' => '6.png'],
        ['numero' => 7, 'imagen' => '7.png'],
        ['numero' => 8, 'imagen' => '8.png'],
        ['numero' => 9, 'imagen' => '9.png'],
        ['numero' => 10, 'imagen' => '10.png'],
        ['numero' => 11, 'imagen' => '11.png'],
        ['numero' => 12, 'imagen' => '12.png']
    ];

    public function index()
    {
        if(!session()->has('numero_actual')){ // Ya hay una carta actual en la sesion?
            // Si no existe
            $numero = array_rand($this->cartas);
            $carta = $this->cartas[$numero];

            // Guardar en sesion 
            session([
                'numero_actual' => $carta['numero'],
                'imagen_actual' => $carta['imagen'],
                'puntos' => 0,
                'ganado' => false
            ]);
        }

        return view('baraja');
    }

    public function jugar(Request $request)
    {
        // Recoge lo que pulsa
        $eleccion = $request->input('eleccion');
        // Obtiene carta
        $numeroActual = session('numero_actual');
        // Saca carta aleatoria
        $indice = array_rand($this->cartas);
        $nuevaCarta = $this->cartas[$indice];

        // Comprobar que eligio
        $acierto = false;

        if($eleccion == 'mayor' && $nuevaCarta['numero'] > $numeroActual){
            $acierto = true;
        }

        if($eleccion == 'menor' && $nuevaCarta['numero'] < $numeroActual){
            $acierto = true;
        }

        $puntos = session('puntos');

        // Si acierta se le suma puntos
        if($acierto){
            $puntos++;
        } else {
            // Si falla vuelve a 0
            $puntos = 0;
        }

        session([
            // La carta actual pasa a ser anterior
            'numero_anterior' => $numeroActual,
            'imagen_anterior' => session('imagen_actual'),

            // Genera nuevas cartas
            'numero_actual' => $nuevaCarta['numero'],
            'imagen_actual' => $nuevaCarta['imagen'],

            // Si tienes 5 puntos has ganado
            'puntos' => $puntos,
            'ganado' => $puntos >= 5
        ]);

        return redirect()->route('baraja.index');
    }

    public function reiniciar()
    {
        // Borra datos juego
        session()->forget([
            'numero_actual',
            'imagen_actual',
            'numero_anterior',
            'imagen_anterior',
            'puntos',
            'ganado'
        ]);

        return redirect()->route('baraja.index');
    }
}
