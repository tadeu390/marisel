<table style="border: 3px solid black;">
    <thead>
        <tr>
            <td style="width: 50px; text-align: center; color: green;">Nome</td>
            <td style="width: 15px; text-align: center;">Documento</td>
            <td style="width: 15px; text-align: center;">Telefone</td>
            <td style="width: 10px; text-align: center;">Poltrona</td>
            <td style="width: 100px; text-align: center;">Observação</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($viagem['passageiros'] as $item)
            <tr>
                <td>{{$item['nome']}}</td>
                <td>{{$item['rg']}}</td>
                <td>{{$item['telefone']}}</td>
                <td>{{$item['pivot']['poltrona']}}</td>
                <td>{{$item['pivot']['observacao']}}</td>
            </tr>
        @endforeach
    </tbody>
</table>