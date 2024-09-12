<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>test_laravel_60941m</title>
</head>
<body>
    <h2>{{$ingredient ? "Список блюд, где используется ингредиент ".$ingredient->name : 'Неверный ID ингредиента' }}</h2>
    @if($ingredient)
        <table border="1">
            <td>id</td>
            <td>Наименование</td>
            <td>Количество</td>
            <td>Единицы измерения</td>
            @foreach($ingredient->dishes as $dish)
                <tr>
                    <td>{{$dish->id}}</td>
                    <td>{{$dish->name}}</td>
                    <td>{{$dish->pivot->quantity}}</td>
                    <td>{{$ingredient->units}}</td>
                </tr>
            @endforeach
        </table>
    @endif
</body>
</html>
