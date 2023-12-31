<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .title {
            font-size: 20px;
            font-family: Arial, Helvetica, sans-serif;
            color: darkmagenta;
            text-align: center;
        },

        p{
            font-size: 16px;
            font-family: Arial, Helvetica, sans-serif;
            color: black;
        }
    </style>
</head>
<body>
    <h1 class="title">Treinos do Aluno</h1>

    <p>Nome do Aluno: <span>{{$students->name}}</span></p>
    <p>E-mail: <span>{{$students->email}}</span></p>
    <p>Data de Nascimento: <span>{{$students->date_birth}}</span></p>
    <p>Telefone: <span>{{$students->contact}}</span></p>
    <p>Rua: <span>{{$students->street}}</span></p>
    <p>Número: <span>{{$students->number}}</span></p>
    <p>Cidade: <span>{{$students->city}}</span></p>
    <p>Estado: <span>{{$students->state}}</span></p>
    <p>CEP: <span>{{$students->cep}}</span></p>

    <h3>Rotina de Treino</h3>

    {{-- <thead>
        <tr>
            <th>Dia</th>
            <th>Exercício</th>
            <th>Repetições</th>
            <th>Peso</th>
            <th>Tempo de Pausa</th>
        </tr>
    </thead> --}}

</body>
</html>
