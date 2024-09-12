<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>test_laravel_60941m</title>
</head>
<body>
    <h2>{{$category ? "Список блюд категории ".$category->name : 'Неверный ID категории' }}</h2>
    @if($category)
    <table border="1">
        <td>id</td>
        <td>Наименование</td>
        <td>Способ приготовления</td>
        <td>Время приготовления</td>
        @foreach($category->dishes as $dish)
            <tr>
                <td>{{$dish->id}}</td>
                <td>{{$dish->name}}</td>
                <td>{{$dish->cooking_method}}</td>
                <td>{{$dish->cooking_time}}</td>
            </tr>
        @endforeach
    </table>
    @endif
</body>
</html>
