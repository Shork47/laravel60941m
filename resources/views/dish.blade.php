<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>test_laravel_60941m</title>
</head>
<body>
    <h2>{{$dish ? "Список ингредиентов для блюда ".$dish->name : 'Неверный ID блюда' }}</h2>
    @if($dish)
        <table border="1">
            <td>id</td>
            <td>Наименование</td>
            <td>Количество</td>
            <td>Единицы измерения</td>
            @foreach($dish->ingredient as $ingredient)
                <tr>
                    <td>{{$ingredient->id}}</td>
                    <td>{{$ingredient->name}}</td>
                    <td>{{$ingredient->pivot->quantity}}</td>
                    <td>{{$ingredient->units}}</td>
                </tr>
            @endforeach
        </table>
    @endif
</body>
</html>
