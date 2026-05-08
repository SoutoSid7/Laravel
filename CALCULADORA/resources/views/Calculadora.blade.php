<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calculadora</title>
</head>
<body>

<h1>Calculadora</h1>

<form action="{{ url('/calculadora') }}" method="POST">
    @csrf

    <!-- INPUTS -->
    <input
        type="number"
        step="any"
        name="num1"
        placeholder="Número 1"
        value="{{ old('num1', $num1 ?? '') }}"
        required
    >

    <input
        type="number"
        step="any"
        name="num2"
        placeholder="Número 2"
        value="{{ old('num2', $num2 ?? '') }}"
    >

    <br><br>

    <!-- BOTONES NUMÉRICOS (solo visuales) -->
    <button type="button">7</button>
    <button type="button">8</button>
    <button type="button">9</button>

    <br><br>

    <button type="button">4</button>
    <button type="button">5</button>
    <button type="button">6</button>

    <br><br>

    <button type="button">1</button>
    <button type="button">2</button>
    <button type="button">3</button>

    <br><br>

    <button type="button">0</button>

    <br><br>

    <!-- OPERACIONES -->
    <button type="submit" name="oper" value="+">+</button>
    <button type="submit" name="oper" value="-">-</button>
    <button type="submit" name="oper" value="*">×</button>
    <button type="submit" name="oper" value="/">÷</button>
    <button type="submit" name="oper" value="pow">xⁿ</button>
    <button type="submit" name="oper" value="sqrt">√</button>
    <button type="submit" name="oper" value="%">%</button>

    <button type="reset">C</button>
</form>

@if ($errors->any())
    <p style="color:red">
        {{ $errors->first() }}
    </p>
@endif

@if(isset($error) && $error)
    <p style="color:red">
        {{ $error }}
    </p>
@endif

@if(isset($resultado) && $resultado !== null)
    <h2>Resultado: {{ $resultado }}</h2>
@endif

</body>
</html>