<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BarajaController extends Controller
{
    private array $cartas = [
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
        if(!session()->has('numero_actual')){
            $numero = array_rand($this->cartas);
            $carta = $this->cartas[$numero];

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
        $eleccion = $request->input('eleccion');
        $numeroActual = session('numero_actual');
        $indice = array_rand($this->cartas);
        $nuevaCarta = $this->cartas[$indice];

        $acierto = false;

        if($eleccion == 'mayor' && $nuevaCarta['numero'] > $numeroActual){
            $acierto = true;
        }

        if($eleccion == 'menor' && $nuevaCarta['numero'] < $numeroActual){
            $acierto = true;
        }

        $puntos = session('puntos');

        if($acierto){
            $puntos++;
        } else {
            $puntos = 0;
        }

        session([
            'numero_anterior' => $numeroActual,
            'imagen_anterior' => session('imagen_actual'),

            'numero_actual' => $nuevaCarta['numero'],
            'imagen_actual' => $nuevaCarta['imagen'],

            'puntos' => $puntos,
            'ganado' => $puntos >= 5
        ]);

        return redirect()->route('baraja.index');
    }

    public function reiniciar()
    {
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
