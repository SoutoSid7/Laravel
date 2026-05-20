<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemoriaController extends Controller
{
    private $colores = ['rojo', 'verde', 'azul', 'amarillo'];

    public function index()
    {
        if (!session()->has('secuencia')) {
            session([
                'secuencia' => [$this->colores[array_rand($this->colores)]],
                'posicion'  => 0,
                'nivel'     => 1,
                'mostrar'   => true,
            ]);
        }

        return view('memoria', [
            'secuencia' => session('secuencia'),
            'nivel'     => session('nivel'),
            'mostrar'   => session('mostrar', false),
            'mensaje'   => session('mensaje', ''),
            'colores'   => $this->colores,
        ]);
    }

    public function jugar(Request $request)
    {
        $request->validate(['color' => 'required|in:rojo,verde,azul,amarillo']);

        $color     = $request->input('color');
        $secuencia = session('secuencia');
        $posicion  = session('posicion');

        if ($color !== $secuencia[$posicion]) {
            session(['mensaje' => "💀 Fallaste en el nivel " . session('nivel') . ". La secuencia era: " . implode(' → ', $secuencia)]);
            session(['secuencia' => [], 'posicion' => 0, 'nivel' => 1]);
            return redirect()->route('memoria.index');
        }

        $posicion++;

        if ($posicion >= count($secuencia)) {
            $secuencia[] = $this->colores[array_rand($this->colores)];
            session([
                'secuencia' => $secuencia,
                'posicion'  => 0,
                'nivel'     => session('nivel') + 1,
                'mostrar'   => true,
                'mensaje'   => "✅ ¡Nivel completado! Memoriza la nueva secuencia.",
            ]);
        } else {
            session(['posicion' => $posicion, 'mostrar' => false, 'mensaje' => 'Bien, sigue...']);
        }

        return redirect()->route('memoria.index');
    }

    public function ocultar()
    {
        session(['mostrar' => false]);
        return redirect()->route('memoria.index');
    }

    public function reiniciar()
    {
        session()->flush();
        return redirect()->route('memoria.index');
    }
}