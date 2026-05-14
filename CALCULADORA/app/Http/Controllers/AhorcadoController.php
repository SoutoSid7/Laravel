<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AhorcadoController extends Controller
{
    private array $palabras = ['laravel', 'programacion', 'servidor', 'controlador'];

    public function index()
    {
        if (!session()->has('palabra')) {
            $this->nuevoJuego();
        }

        return view('ahorcado');
    }

    public function probarLetra(Request $request)
    {
        $request->validate([
            'letra' => 'required|string|size:1'
        ]);

        $letra = strtolower($request->letra);
        $palabra = session('palabra');
        $letras = session('letras', []);
        $errores = session('errores', 0);

        if (!in_array($letra, $letras)) {
            $letras[] = $letra;

            if (!str_contains($palabra, $letra)) {
                $errores++;
            }
        }

        session([
            'letras' => $letras,
            'errores' => $errores,
        ]);

        return redirect()->route('ahorcado.index');
    }

    public function reiniciar()
    {
        session()->forget(['palabra', 'letras', 'errores']);
        $this->nuevoJuego();

        return redirect()->route('ahorcado.index');
    }

    private function nuevoJuego()
    {
        session([
            'palabra' => $this->palabras[array_rand($this->palabras)],
            'letras' => [],
            'errores' => 0,
        ]);
    }
}