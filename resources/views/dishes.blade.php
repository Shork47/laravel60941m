@extends('layout')
@section('content')
<div class="container mt-5 w-100 d-flex flex-column align-items-center">
<h2>Список блюд</h2>
<div class="container my-4">
    <div class="row g-4">
        @foreach($dishes as $dish)
            <div class="col-12 col-md-6">
                <div class="card h-100 text-center" >
                    <img src="" class="card-img-top" alt="Image">
                    <div class="card-body">
                        <h5 class="card-title">{{$dish->name}}</h5>
                        <p class="card-text" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                            {{$dish->cooking_method}}
                        </p>
                        <a href="{{url('dish/'.$dish->id)}}" class="btn btn-primary">Посмотреть</a>
                    </div>
                    <a href="{{url('category/'.$dish->category->id)}}" class="btn btn-info">{{$dish->category->name}}</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
{{$dishes -> links()}}
</div>
@endsection
{{--<table border="1">--}}
{{--    <thead>--}}
{{--    <td>id</td>--}}
{{--    <td>Наименование</td>--}}
{{--    <td>Способ приготовления</td>--}}
{{--    <td>Время приготовления</td>--}}
{{--    <td>Категория</td>--}}
{{--    <td>Действие</td>--}}
{{--    </thead>--}}
{{--    @foreach($dishes as $dish)--}}
{{--        <tr>--}}
{{--            <td>{{$dish->id}}</td>--}}
{{--            <td>{{$dish->name}}</td>--}}
{{--            <td>{{$dish->cooking_method}}</td>--}}
{{--            <td>{{$dish->cooking_time}}</td>--}}
{{--            <td>{{$dish->category->name}}</td>--}}
{{--            <td><a href="{{url('dish/destroy/'.$dish->id)}}">Удалить</a>--}}
{{--                <a href="{{url('dish/edit/'.$dish->id)}}">Редактировать</a>--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--    @endforeach--}}
{{--</table>--}}
