$jugadores = ['Juan' => 10, 'Ana' => 25, 'Luis' => 5];

// 1. foreach normal (solo valores)
foreach ($colores as $color) {
    echo $color;
}

// 2. foreach con Clave y Valor (imprescindible para arrays asociativos)
foreach ($jugadores as $nombre => $puntuacion) {
    echo "El jugador $nombre tiene $puntuacion puntos.";
}

// 3. Recorrer un String letra a letra (Juegos de palabras/Ahorcado)
$palabra = "LARAVEL";
$letras = str_split($palabra); // Lo convierte en ['L', 'A', 'R', 'A', 'V', 'E', 'L']
foreach ($letras as $letra) { ... }

// Alternativa para buscar dentro de un string sin recorrerlo:
if (str_contains($palabra, 'A')) { // true }