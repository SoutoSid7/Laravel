$colores = ['rojo', 'verde', 'azul', 'amarillo'];

// 1. shuffle(): Desordena un array (modifica el original).
// Útil para barajar cartas o mezclar cajas ocultas.
shuffle($colores);

// 2. array_rand(): Devuelve un ÍNDICE (o clave) al azar, no el valor.
$indice_al_azar = array_rand($colores);
$color_elegido = $colores[$indice_al_azar];

// 3. in_array(): Comprueba si un VALOR existe dentro del array (Devuelve true/false).
// Útil para juegos tipo Ahorcado (¿esta letra está en las letras adivinadas?)
if (in_array('rojo', $colores)) { ... }

// 4. array_search(): Busca un VALOR y te devuelve su ÍNDICE.
$posicion = array_search('verde', $colores); // Devuelve 1