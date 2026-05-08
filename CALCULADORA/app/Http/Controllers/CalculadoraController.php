<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CalculadoraController extends Controller
{
    // Carga por primera vez
    public function index() {
        return view('calculadora');
    }

    public function calcular(Request $request)
    {
        /**
         *  Comprobacion de que num1 y num2 sean numeros
         *  Comprobacion de que operacion exista
         *  Si falla devuelve error validacion, detiene ejecucion del codigo
        */ 
        $request->validate([
            'num1' => 'required|numeric',
            'num2' => 'required|numeric',
            'oper' => 'required'
        ]);

        // Recoger valores de la calculadora y comprobarlos
        $num1 = (float) $request->num1;
        $num2 = (float) $request->num2; 
        $oper = $request->oper;

        // Variables resultado y error
        $resultado = null;
        $error = null;

        // Segun la operacion elegida, realizamos el calculo
        switch($oper){
            case '+':
                $resultado = $num1 + $num2;
                break;
            case '-':
                $resultado = $num1 - $num2;
                break;
            case '*':
                $resultado = $num1 * $num2;
                break;
            case '/':
                if ($num2 == 0) {
                    $error = 'No se puede dividir entre cero.';
                } else {
                    $resultado = $num1 / $num2;
                }
                break;
            case 'sqrt':
                if ($num1 < 0) {
                    $error = 'No se puede calcular la raiz de un numero negativo';
                } else {
                    $resultado = sqrt($num1);
                } break;
            case 'pow':
                $resultado = pow($num1, $num2);
                break;
            // Porcertanje calcular el x% del num1
            case '%':
                if ($num2 < 0) {
                    $error = 'El porcentaje no puede ser 0';
                } else {
                    $resultado = $num1 * $num2 / 100;
                }
                break;
        }
        /**
         * Devolvemos la vista con:
         * resultado --> el numero o null si hubo error
         * error --> el mensaje de error si hubo
         * num1, num2, oper --> para mantener valores en el formulario
         * compact --> en vez de escribir todo el array asociativo lo acorta
        */
        return view('calculadora', compact('resultado', 'error', 'num1', 'num2', 'oper'));
    }
}
