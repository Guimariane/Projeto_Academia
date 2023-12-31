<!DOCTYPE html>
<html lang="pt-br">
<head>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        h1 {
            color: darkmagenta;
            font-size: 20px;
            text-align: center;
        }

        p{
            font-size: 16px;
            color:black;
            text-align:left;
        }
    </style>
</head>
<body>
    <h1>Olá, {{$name}}!</h1>

    <p>Que bom que se juntou a nós da FitTech!</p>

    {{-- <p>Você se cadastrou no {{$type_plan}} e, com isso, gostaria de lembrar que você tem um limite de
    {{$limit_plan}}!</p> --}}

    <p>Caso tenha mais alguma dúvida, por favor não hesite em nos contatar! Estamos aqui para te ajudar!</p>

    </body>
</html>
