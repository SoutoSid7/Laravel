<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JuegoController extends Controller
{

    private array $cartas = [
        ['numero' => 1, 'imagen' => 'img/card_clubs_01.svg'],
        ['numero' => 2, 'imagen' => 'img/card_clubs_02.svg'],
        ['numero' => 3, 'imagen' => 'img/card_clubs_03.svg'],
        ['numero' => 4, 'imagen' => 'img/card_clubs_04.svg'],
        ['numero' => 5, 'imagen' => 'img/card_clubs_05.svg'],
        ['numero' => 6, 'imagen' => 'img/card_clubs_06.svg'],
        ['numero' => 7, 'imagen' => 'img/card_clubs_07.svg'],
        ['numero' => 8, 'imagen' => 'img/card_clubs_08.svg'],
        ['numero' => 9, 'imagen' => 'img/card_clubs_09.svg'],
        ['numero' => 10, 'imagen' => 'img/card_clubs_10.svg'],
        ['numero' => 11, 'imagen' => 'img/card_clubs_11.svg'],
        ['numero' => 12, 'imagen' => 'img/card_clubs_12.svg'],

        ['numero' => 13, 'imagen' => 'img/card_coins_01.svg'],
        ['numero' => 14, 'imagen' => 'img/card_coins_02.svg'],
        ['numero' => 15, 'imagen' => 'img/card_coins_03.svg'],
        ['numero' => 16, 'imagen' => 'img/card_coins_04.svg'],
        ['numero' => 17, 'imagen' => 'img/card_coins_05.svg'],
        ['numero' => 18, 'imagen' => 'img/card_coins_06.svg'],
        ['numero' => 19, 'imagen' => 'img/card_coins_07.svg'],
        ['numero' => 20, 'imagen' => 'img/card_coins_08.svg'],
        ['numero' => 21, 'imagen' => 'img/card_coins_09.svg'],
        ['numero' => 22, 'imagen' => 'img/card_coins_10.svg'],
        ['numero' => 23, 'imagen' => 'img/card_coins_11.svg'],
        ['numero' => 24, 'imagen' => 'img/card_coins_12.svg'],

        ['numero' => 25, 'imagen' => 'img/card_cups_01.svg'],
        ['numero' => 26, 'imagen' => 'img/card_cups_02.svg'],
        ['numero' => 27, 'imagen' => 'img/card_cups_03.svg'],
        ['numero' => 28, 'imagen' => 'img/card_cups_04.svg'],
        ['numero' => 29, 'imagen' => 'img/card_cups_05.svg'],
        ['numero' => 30, 'imagen' => 'img/card_cups_06.svg'],
        ['numero' => 31, 'imagen' => 'img/card_cups_07.svg'],
        ['numero' => 32, 'imagen' => 'img/card_cups_08.svg'],
        ['numero' => 33, 'imagen' => 'img/card_cups_09.svg'],
        ['numero' => 34, 'imagen' => 'img/card_cups_10.svg'],
        ['numero' => 35, 'imagen' => 'img/card_cups_11.svg'],
        ['numero' => 36, 'imagen' => 'img/card_cups_12.svg'],

        ['numero' => 37, 'imagen' => 'img/card_swords_01.svg'],
        ['numero' => 38, 'imagen' => 'img/card_swords_02.svg'],
        ['numero' => 39, 'imagen' => 'img/card_swords_03.svg'],
        ['numero' => 40, 'imagen' => 'img/card_swords_04.svg'],
        ['numero' => 41, 'imagen' => 'img/card_swords_05.svg'],
        ['numero' => 42, 'imagen' => 'img/card_swords_06.svg'],
        ['numero' => 43, 'imagen' => 'img/card_swords_07.svg'],
        ['numero' => 44, 'imagen' => 'img/card_swords_08.svg'],
        ['numero' => 45, 'imagen' => 'img/card_swords_09.svg'],
        ['numero' => 46, 'imagen' => 'img/card_swords_10.svg'],
        ['numero' => 47, 'imagen' => 'img/card_swords_11.svg'],
        ['numero' => 48, 'imagen' => 'img/card_swords_12.svg'],
    ];

    public function inicializacion() 
    {
        if(!session()->has('baraja')){
            // Si no existe 
            $baraja = array_merge($this->cartas, $this->cartas); // Parejas de 2
            shuffle($baraja); // Combinación aleatoria

            // Guardar en sesion 
            session([
                'baraja' => $baraja,    
                'mazo_restante' => 50,
                'puntos_jugador' => 0,
                'puntos_maquina' => 0,
                'ganado' => false
            ]);
        }

        return view('mayor');
    }

    public function jugar(Request $request)
    {
        // Recuperar datos de sesión
        $baraja = session('baraja');
        $ganado = session('ganado');
        $puntos_jugador = session('puntos_jugador');
        $puntos_maquina = session('puntos_maquina');

        session([
            'carta1' => array_shift($baraja),
            'carta2' => array_shift($baraja)
        ]);

        $carta1 = array_shift($baraja);
        $carta2 = array_shift($baraja);

        $tirar = $request->input('jugar_turno');

        // Evitar que sigan jugando si ya ganaron
        if (session('ganado')) {
            return redirect()->route('juego.index')->with('error', 'Ya has ganado, reinicia la partida.');
        }

        if(isset($tirar)){
            session(['mazo_restante' => session('mazo_restante') - 2]);
        }       

        return redirect()->route('mayor.inicializacion');
    }

    public function reiniciar()
    {
        // Borra datos juego
        session()->forget([
            'baraja',
            'mazo_restante',
            'puntos_jugador',
            'puntos_maquina',
            'ganado'
        ]);

        return redirect()->route('mayor.inicializacion');
    }
}