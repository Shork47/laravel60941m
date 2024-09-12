<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>test_laravel_60941m</title>
</head>
<body>
<h2>Список блюд</h2>
<table border="1">
    <thead>
    <td>id</td>
    <td>Наименование</td>
    <td>Способ приготовления</td>
    <td>Время приготовления</td>
    <td>Категория</td>
    </thead>
    @foreach($dishes as $dish)
        <tr>
            <td>{{$dish->id}}</td>
            <td>{{$dish->name}}</td>
            <td>{{$dish->cooking_method}}</td>
            <td>{{$dish->cooking_time}}</td>
            <td>{{$dish->category->name}}</td>
        </tr>
    @endforeach
</table>
</body>
</html>
