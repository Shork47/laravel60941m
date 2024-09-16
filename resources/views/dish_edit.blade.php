<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>test_laravel_60941m</title>
    <style> .is-invalid {color: red;}</style>
</head>
<body>
<h2>Редактирование блюда</h2>
<form method="post" action={{url('dish/update/'.$dish->id)}}>
    @csrf
    <label>Наименование</label>
    <input type="text" name="name" value="@if (old('name')) {{old('name')}} @else {{$dish->name}}@endif"/>
    @error('name')
    <div class="is-invalid">{{$message}}</div>
    @enderror
    <br>
    <label>Метод приготовления</label>
    <input type="text" name="cooking_method" value="@if (old('cooking_method')) {{old('cooking_method')}} @else {{$dish->cooking_method}} @endif"/>
    @error('cooking_method')
    <div class="is-invalid">{{$message}}</div>
    @enderror
    <br>
    <label>Время приготовления</label>
    <input type="text" name="cooking_time" value="@if (old('cooking_time')) {{old('cooking_time')}} @else {{$dish->cooking_time}} @endif"/>
    @error('cooking_time')
    <div class="is-invalid">{{$message}}</div>
    @enderror
    <br>
    <label>Категория блюда</label>
    <select name="category_id" value="{{old('category_id')}}">
        <option style=".is-invalid">
        @foreach($categories as $category)
            <option value="{{$category->id}}"
                    @if(old('$category_id'))
                        @if(old('category_id') == $category->id) selected @endif
                    @else
                        @if($dish->category_id == $category->id) selected @endif
                @endif>{{$category->name}}
            </option>
        @endforeach
    </select>
    @error('category_id')
    <div class="is-invalid">{{$message}}</div>
    @enderror
    <br>
    <input type="submit">
</form>
</body>
</html>
