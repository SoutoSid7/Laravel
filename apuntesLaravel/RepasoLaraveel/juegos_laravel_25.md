# 🎮 Guía Rápida – 25 Juegos Laravel para el Examen

Resumen de cada juego con sus características clave, patrones de Laravel usados y rutas. Pensado para localizar rápido el ejemplo que más se parezca a lo que te pidan.

---

## 📊 Tabla resumen general

### Juegos principales (20)

| # | Juego | Tema/Mecánica | Rutas POST | Patrón clave |
|---|-------|---------------|------------|--------------|
| 1 | Mayor o Menor (cartas) | Adivinar si la siguiente carta es mayor o menor | jugar, reiniciar | Array de imágenes + sesión |
| 2 | Adivina el Número | Adivinar número (1-100) con 7 intentos | jugar, reiniciar | `array` historial en sesión |
| 3 | Piedra, Papel o Tijera | Jugador vs máquina, primero a 5 | jugar, reiniciar | Lógica condicional compleja |
| 4 | Ahorcado | Adivinar palabra letra a letra | jugar, reiniciar | `str_split`, `in_array`, recorrer string |
| 5 | Par o Impar | Apostar par/impar al número aleatorio | jugar, reiniciar | Operador módulo `%` |
| 6 | Dado Mágico | Apostar a número del dado (1-6) | jugar, reiniciar | `@for` en Blade |
| 7 | Memoria de Colores | Repetir secuencia que crece | jugar, ocultar, reiniciar | Array creciente + posición |
| 8 | Suma Rápida | Resolver sumas matemáticas | jugar, reiniciar | Validación numérica |
| 9 | Ruleta de la Fortuna | Apostar cantidad + color | jugar, reiniciar | Input numérico + radio |
| 10 | Caza al Tesoro | Cuadrícula 3x3 con tesoro | jugar, reiniciar | Tabla generada con bucle |
| 11 | Carrera de Caballos | Apostar a caballo y avanzar | apostar, avanzar, reiniciar | Array asociativo + bucle |
| 12 | Blackjack 21 | Pedir cartas o plantarse | pedir, plantar, reiniciar | `array_sum` + IA simple |
| 13 | Tres en Raya | Vs máquina aleatoria | jugar, reiniciar | Tablero array + combos ganadores |
| 14 | Cara o Cruz | Apostar moneda, llegar a 20 | jugar, reiniciar | Acumulación de puntos |
| 15 | Quiz / Trivial | 5 preguntas con 3 opciones | responder, reiniciar | Array de arrays asociativos |
| 16 | Bote de Galletas | Llenar 50 galletas (1-3 al click) | meter, reiniciar | Récord persistente en sesión |
| 17 | Bomba | Cortar cables sin pasar del límite | cortar, desactivar, reiniciar | Estado con string ('jugando'...) |
| 18 | Pesca de Peces | 10 lanzamientos, puntos +/- | lanzar, reiniciar | Array de objetos con peso |
| 19 | Escalera Peligrosa | Subir, si sale 0 te caes | subir, reiniciar | Reset parcial de variable |
| 20 | Caja Sorpresa | 3 cajas, premio/carbón/nada | abrir, reiniciar | `shuffle` para aleatorizar |
| 21 | Anagrama | Adivinar palabra desordenada | jugar, reiniciar | `str_shuffle`, trim, strtolower |

### Juegos fáciles (5) - los más simples para empezar

| # | Juego | Tema/Mecánica | Rutas POST | Patrón clave |
|---|-------|---------------|------------|--------------|
| F1 | Par o Impar Simple | Apostar par/impar, sin objetivo final | jugar, reiniciar | Lo más básico posible |
| F2 | Contador | +1, -1, reset | sumar, restar, reiniciar | Tres rutas POST mínimas |
| F3 | Tirar Dado | Botón → sale 1-6 | tirar, reiniciar | Sin validación, sin lógica |
| F4 | Adivina Color | Adivinar rojo/verde/azul | jugar, reiniciar | Array desde controlador |
| F5 | Mayor o Menor que 5 | Apostar si saldrá >5 o <5 | jugar, reiniciar | Empate explícito |

---

## 🧩 Patrones técnicos – ¿qué juego mirar según lo que te pidan?

| Necesitas | Juegos donde aparece |
|-----------|----------------------|
| **Lo más básico (puntos, sin validación)** | F1, F2, F3 |
| **Validar números con rango** | 2, 6, 8, 9, 10, 20 (`integer\|min:1\|max:N`) |
| **Validar opciones de texto** | 3, 5, 14, F1, F4, F5 (`in:opcion1,opcion2`) |
| **Validar letra única** | 4 (`string\|size:1`) |
| **Guardar array en sesión** | 2, 4, 7, 10, 11, 12, 13, 18 |
| **Recorrer palabra letra a letra** | 4 (`str_split`) |
| **Desordenar / mezclar** | 20 (`shuffle`), 21 (`str_shuffle`) |
| **Sumar elementos de array** | 12 (`array_sum`) |
| **Buscar valor en array** | 4, 10 (`in_array`) |
| **Array asociativo (clave => valor)** | 11, 12, 15 |
| **Múltiples rutas POST diferentes** | 7, 11, 12, 17, F2 |
| **Generar tabla con bucle anidado** | 10, 13 (`@for` doble) |
| **Récord persistente entre partidas** | 16 (preservar al hacer flush) |
| **Estado con string en vez de booleano** | 17 (`'jugando'/'desactivada'/'explotada'`) |
| **Imágenes desde public/img** | 1 (`asset('img/...')`) |
| **Array pasado a la vista para botones** | F4, 7 (`@foreach`) |

---

## 📌 Detalle de cada juego

### 🟢 JUEGOS FÁCILES (para empezar)

#### F1. Par o Impar Simple
- **Qué hace**: Apuestas par/impar, sale número 1-100, te dice si acertaste.
- **Datos en sesión**: `aciertos`, `fallos`, `numero`.
- **Lo distinto**: No hay condición de victoria/derrota, solo aciertos y fallos acumulados.
- **Validación**: `'apuesta' => 'required|in:par,impar'`

#### F2. Contador
- **Qué hace**: Botones +1, -1, reset. Lo más simple del mundo.
- **Datos en sesión**: `contador`.
- **Lo distinto**: Tres rutas POST con un solo valor. No hay validación.
- **Validación**: ninguna.

#### F3. Tirar Dado
- **Qué hace**: Aprietas un botón y sale un número 1-6. Lleva historial.
- **Datos en sesión**: `dado`, `historial[]`.
- **Lo distinto**: Sin validación, sin condiciones, super sencillo.
- **Validación**: ninguna.

#### F4. Adivina Color
- **Qué hace**: El sistema piensa un color, tú adivinas, te dice si acertaste.
- **Datos en sesión**: `color_secreto`, `aciertos`, `intentos`.
- **Lo distinto**: Array de colores en propiedad privada del controlador, pasado a la vista para generar botones.
- **Validación**: `'color' => 'required|in:rojo,verde,azul'`

#### F5. Mayor o Menor que 5
- **Qué hace**: Apuestas si saldrá mayor o menor que 5, sale número 1-10.
- **Datos en sesión**: `aciertos`, `fallos`, `numero`.
- **Lo distinto**: El 5 es empate explícito (ni mayor ni menor). Operadores `>` y `<`.
- **Validación**: `'apuesta' => 'required|in:mayor,menor'`

---

### 🔵 JUEGOS PRINCIPALES

#### 1. Mayor o Menor (cartas)
- **Qué hace**: Te enseña una carta y eliges si la siguiente será mayor o menor. 5 aciertos seguidos para ganar.
- **Datos en sesión**: `numero_actual`, `racha`, `ganado`.
- **Lo distinto**: Usa imágenes desde `public/img/cartaN.png` con `asset()`.
- **Validación**: `'apuesta' => 'required|in:alta,baja'` (implícita por valores del botón)

#### 2. Adivina el Número
- **Qué hace**: Adivinar número del 1 al 100 en máximo 7 intentos. Te dice "más alto" o "más bajo".
- **Datos en sesión**: `numero_secreto`, `intentos`, `historial[]`, `ganado`, `perdido`.
- **Lo distinto**: Guarda historial de intentos en un array y lo muestra con `implode`.
- **Validación**: `'numero' => 'required|integer|min:1|max:100'`

#### 3. Piedra, Papel o Tijera
- **Qué hace**: Jugador vs máquina, primero a 5 victorias gana.
- **Datos en sesión**: `jugador_puntos`, `maquina_puntos`, `ronda`, `eleccion_jugador`, `eleccion_maquina`.
- **Lo distinto**: Lógica condicional con OR de varias combinaciones (`||`).
- **Validación**: `'eleccion' => 'required|in:piedra,papel,tijera'`

#### 4. Ahorcado
- **Qué hace**: Adivinar palabra letra por letra. Máximo 6 fallos.
- **Datos en sesión**: `palabra`, `aciertos[]`, `fallos[]`, `max_fallos`.
- **Lo distinto**: Usa `str_split()` para recorrer la palabra, `in_array()` y `str_contains()`.
- **Validación**: `'letra' => 'required|string|size:1'`

#### 5. Par o Impar (con objetivos)
- **Qué hace**: Apostar si el siguiente número (1-20) será par o impar. 5 aciertos para ganar, 3 fallos para perder.
- **Datos en sesión**: `aciertos`, `fallos`, `numero`.
- **Lo distinto**: Operador módulo `%` para detectar pares (`$num % 2 === 0`).
- **Validación**: `'apuesta' => 'required|in:par,impar'`

#### 6. Dado Mágico
- **Qué hace**: Apostar a un número del dado. 3 aciertos seguidos para ganar.
- **Datos en sesión**: `racha`, `tiradas`, `ganado`, `dado`.
- **Lo distinto**: Bucle `@for` en Blade para generar los 6 botones.
- **Validación**: `'apuesta' => 'required|integer|min:1|max:6'`

#### 7. Memoria de Colores
- **Qué hace**: Memoriza secuencia de colores y repítela. La secuencia crece cada nivel.
- **Datos en sesión**: `secuencia[]`, `posicion`, `nivel`, `mostrar`.
- **Lo distinto**: Tres rutas POST (jugar, ocultar, reiniciar). El array crece.
- **Validación**: `'color' => 'required|in:rojo,verde,azul,amarillo'`

#### 8. Suma Rápida
- **Qué hace**: Resolver sumas matemáticas. 5 aciertos seguidos para ganar, 3 fallos pierdes.
- **Datos en sesión**: `num1`, `num2`, `racha`, `fallos`, `ganado`.
- **Lo distinto**: `autofocus` en el input para escribir rápido.
- **Validación**: `'respuesta' => 'required|integer'`

#### 9. Ruleta de la Fortuna
- **Qué hace**: Tienes 100 puntos, apuestas cantidad + color. Llegar a 500 gana.
- **Datos en sesión**: `puntos`, `tiradas`, `color`.
- **Lo distinto**: Dos inputs combinados (número + botón con valor).
- **Validación**: `'cantidad' => 'required|integer|min:1'`, `'apuesta_color' => 'required|in:rojo,negro'`

#### 10. Caza al Tesoro
- **Qué hace**: 9 casillas, 4 intentos para encontrar el tesoro.
- **Datos en sesión**: `tesoro`, `intentos`, `probadas[]`, `ganado`, `perdido`.
- **Lo distinto**: Tabla 3x3 generada con `@for` anidado. Casillas se desactivan al probar.
- **Validación**: `'casilla' => 'required|integer|min:1|max:9'`

#### 11. Carrera de Caballos
- **Qué hace**: Apuestas por un caballo (1-3). Avanzan al azar cada turno. Meta = 10.
- **Datos en sesión**: `caballos` (array asociativo), `apuesta`, `ganador`.
- **Lo distinto**: Array asociativo `[1 => 0, 2 => 0, 3 => 0]`. Dos POST distintos antes del juego.
- **Validación**: `'caballo' => 'required|integer|min:1|max:3'`

#### 12. Blackjack 21
- **Qué hace**: Pide cartas o plántate. No pasar de 21. Banca juega automáticamente al final.
- **Datos en sesión**: `jugador[]`, `banca[]`, `plantado`, `fin`.
- **Lo distinto**: `array_sum()` para totales. IA de la banca (pide hasta 17).
- **Validación**: ninguna (solo botones sin valor).

#### 13. Tres en Raya
- **Qué hace**: Vs máquina (aleatoria). 3x3 clásico.
- **Datos en sesión**: `tablero[]` (9 posiciones), `turno`, `fin`.
- **Lo distinto**: Función privada `gana()` que recorre combos ganadores. `array_keys($tablero, '')` para casillas libres.
- **Validación**: `'casilla' => 'required|integer|min:0|max:8'`

#### 14. Cara o Cruz
- **Qué hace**: 10 monedas iniciales. Apuestas cara o cruz, ganas/pierdes una. Llegar a 20.
- **Datos en sesión**: `monedas`, `tiradas`, `resultado`.
- **Lo distinto**: Sistema simple de acumulación de "moneda virtual".
- **Validación**: `'apuesta' => 'required|in:cara,cruz'`

#### 15. Quiz / Trivial
- **Qué hace**: 5 preguntas con 3 opciones cada una. Resultado final.
- **Datos en sesión**: `actual`, `aciertos`.
- **Lo distinto**: Array de arrays asociativos con `pregunta`, `opciones`, `correcta`. Acaba solo.
- **Validación**: `'opcion' => 'required|integer|min:0|max:2'`

#### 16. Bote de Galletas
- **Qué hace**: Click para meter 1-3 galletas. Llenar 50 en menos clicks. Récord persistente.
- **Datos en sesión**: `galletas`, `clicks`, `mejor`.
- **Lo distinto**: Al reiniciar conserva `mejor` (récord). Barra de progreso CSS.
- **Validación**: ninguna.

#### 17. Bomba
- **Qué hace**: Cortar cables. Hay un límite secreto. Pasarte = explotas. Desactivar antes = ganas.
- **Datos en sesión**: `limite`, `cortes`, `estado`.
- **Lo distinto**: Estado con string en vez de booleanos (`'jugando'`, `'desactivada'`, `'explotada'`). Tres POST diferentes.
- **Validación**: ninguna.

#### 18. Pesca de Peces
- **Qué hace**: 10 lanzamientos. Pescas peces (puntos positivos) o basura (negativos).
- **Datos en sesión**: `puntos`, `lanzamientos`, `pesca[]`.
- **Lo distinto**: Array de tipos con nombre + puntos. Historial completo de capturas.
- **Validación**: ninguna.

#### 19. Escalera Peligrosa
- **Qué hace**: Subir 1-3 escalones al azar. Si sale 0, vuelves a empezar. Meta = 20.
- **Datos en sesión**: `escalon`, `caidas`, `subidas`, `ganado`.
- **Lo distinto**: `rand(0, 3)` y reset de variable al fallar (no flush completo).
- **Validación**: ninguna.

#### 20. Caja Sorpresa
- **Qué hace**: 3 cajas mezcladas (premio, carbón, nada). 5 rondas. Conseguir 3 premios.
- **Datos en sesión**: `premios`, `rondas`, `eleccion`, `ganado`.
- **Lo distinto**: `shuffle()` para mezclar el contenido cada ronda. Mapa de mensajes con array asociativo.
- **Validación**: `'caja' => 'required|integer|min:1|max:3'`

#### 21. Anagrama
- **Qué hace**: Te dan palabra desordenada, la adivinas. 3 intentos por palabra. 3 palabras seguidas.
- **Datos en sesión**: `palabra`, `desordenada`, `intentos`, `aciertos`, `fin`.
- **Lo distinto**: `str_shuffle()` para desordenar, `strtolower(trim($input))` para limpiar entrada.
- **Validación**: `'intento' => 'required|string'`

---

## 🛠️ Snippets útiles (copiar y pegar rápido)

### Inicializar sesión (en `index()`)
```php
if (!session()->has('clave_principal')) {
    session([
        'puntos' => 0,
        'ganado' => false,
        'historial' => [],
    ]);
}
```

### Devolver vista con datos
```php
return view('nombre', [
    'puntos' => session('puntos'),
    'mensaje' => session('mensaje', ''),
]);
```

### Validar entrada del formulario
```php
$request->validate([
    'apuesta' => 'required|in:opcion1,opcion2',
    'numero'  => 'required|integer|min:1|max:100',
]);
```

### Leer input del formulario
```php
$valor = $request->input('nombre_del_input');
```

### Actualizar sesión y redirigir
```php
session(['puntos' => session('puntos') + 1, 'mensaje' => 'Ganaste']);
return redirect()->route('mi.ruta');
```

### Reiniciar partida (borrar toda la sesión)
```php
session()->flush();
return redirect()->route('mi.ruta');
```

### Generar número aleatorio
```php
$dado = rand(1, 6);
```

### Elegir aleatorio de un array
```php
$colores = ['rojo', 'verde', 'azul'];
$color = $colores[array_rand($colores)];
```

### Recorrer una palabra letra a letra
```php
foreach (str_split($palabra) as $letra) {
    // hacer algo con $letra
}
```

### Mezclar un array / string
```php
shuffle($array);           // modifica el array
$mezclada = str_shuffle($palabra);
```

### Imagen desde public/img
```php
$ruta = asset('img/carta1.png');
// produce algo como http://localhost:8000/img/carta1.png
```

---

## 🎨 Snippets de Blade

### Mostrar variable
```blade
{{ $variable }}
```

### Comentario (no aparece en HTML)
```blade
{{-- esto es un comentario --}}
```

### Condicional
```blade
@if ($condicion)
    ...
@elseif ($otra)
    ...
@else
    ...
@endif
```

### Bucle for
```blade
@for ($i = 1; $i <= 10; $i++)
    {{ $i }}
@endfor
```

### Bucle foreach
```blade
@foreach ($items as $item)
    {{ $item }}
@endforeach
```

### Foreach con clave
```blade
@foreach ($caballos as $id => $pos)
    Caballo {{ $id }} - Posición {{ $pos }}
@endforeach
```

### Formulario POST con CSRF
```blade
<form action="{{ route('ruta.nombre') }}" method="POST">
    @csrf
    <input type="text" name="dato">
    <button type="submit">Enviar</button>
</form>
```

### Botón con valor diferente (apuestas)
```blade
<button type="submit" name="apuesta" value="alta">Alta</button>
<button type="submit" name="apuesta" value="baja">Baja</button>
```

### PHP inline en Blade
```blade
@php $resultado = $a + $b; @endphp
```

### Imagen
```blade
<img src="{{ $imagenes[$numero - 1] }}" alt="Carta">
```

---

## 🚦 Estructura típica de `web.php`

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MiController;

Route::get('/',          [MiController::class, 'index'])->name('juego.index');
Route::post('/jugar',    [MiController::class, 'jugar'])->name('juego.jugar');
Route::post('/reiniciar',[MiController::class, 'reiniciar'])->name('juego.reiniciar');
```

---

## 🎯 Estructura típica de un Controlador

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MiController extends Controller
{
    // Datos fijos del juego (opcional)
    private $opciones = ['a', 'b', 'c'];

    public function index()
    {
        // 1. Inicializar sesión si es la primera vez
        if (!session()->has('clave')) {
            session(['clave' => valor_inicial]);
        }

        // 2. Devolver la vista con los datos
        return view('vista', [
            'dato' => session('clave'),
            'mensaje' => session('mensaje', ''),
        ]);
    }

    public function jugar(Request $request)
    {
        // 1. Validar input
        $request->validate(['campo' => 'required|...']);

        // 2. Comprobar si ya terminó la partida
        if (session('ganado')) {
            return redirect()->route('juego.index');
        }

        // 3. Procesar la lógica del juego
        $input = $request->input('campo');
        // ... lógica ...

        // 4. Guardar resultados en sesión
        session(['clave' => $nuevo_valor, 'mensaje' => $mensaje]);

        // 5. Redirigir a la vista
        return redirect()->route('juego.index');
    }

    public function reiniciar()
    {
        session()->flush();
        return redirect()->route('juego.index');
    }
}
```

---

## 🎨 Estructura típica de una Vista Blade

```blade
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Juego</title>
</head>
<body style="text-align:center; font-family:sans-serif; padding:20px;">
    <h1>Título del Juego</h1>

    {{-- Datos del estado --}}
    <p>Puntos: {{ $puntos }}</p>

    {{-- Formulario de jugada (solo si la partida sigue) --}}
    @if (!$ganado)
        <form action="{{ route('juego.jugar') }}" method="POST">
            @csrf
            <button type="submit" name="opcion" value="a">A</button>
            <button type="submit" name="opcion" value="b">B</button>
        </form>
    @else
        <h2>¡Ganaste!</h2>
    @endif

    {{-- Mensaje del controlador --}}
    @if ($mensaje)
        <p><strong>{{ $mensaje }}</strong></p>
    @endif

    {{-- Botón de reiniciar (siempre visible) --}}
    <form action="{{ route('juego.reiniciar') }}" method="POST">
        @csrf
        <button type="submit">Reiniciar</button>
    </form>
</body>
</html>
```

---

## ✅ Checklist para el examen

- [ ] He puesto `@csrf` en TODOS los formularios POST.
- [ ] Las rutas POST en `web.php` usan `Route::post`, no `Route::get`.
- [ ] He inicializado las variables de sesión en `index()` antes de usarlas.
- [ ] He validado los inputs con `$request->validate()`.
- [ ] He pasado todas las variables que uso en la vista desde el controlador.
- [ ] He puesto `return redirect()->route(...)` después de procesar (no devuelvo vista en el POST).
- [ ] Las imágenes están en `public/img/` y las referencio con `asset('img/...')` o con ruta `/img/...`.
- [ ] El nombre del archivo blade coincide con lo que pongo en `view('...')`.
- [ ] `use Illuminate\Http\Request;` está al principio del controlador si uso `Request`.
- [ ] `use App\Http\Controllers\MiController;` está en `web.php`.

---

## 🚀 Por dónde empezar si no sabes qué juego elegir

1. **Si te piden algo simple sin condiciones**: mira F2 (Contador) o F3 (Tirar Dado).
2. **Si te piden apostar entre dos opciones**: F1 (Par/Impar), F5 (Mayor/Menor 5), 14 (Cara/Cruz).
3. **Si te piden adivinar con pistas**: 2 (Adivina Número), 4 (Ahorcado).
4. **Si te piden tabla/cuadrícula**: 10 (Tesoro), 13 (Tres en Raya).
5. **Si te piden imágenes**: 1 (Mayor o Menor con cartas).
6. **Si te piden múltiples rutas POST**: 7 (Memoria), 11 (Carrera), 17 (Bomba).

¡Mucha suerte! 💪
