@extends('layout')
@section('content')
<div class="container mt-5 w-100 d-flex flex-column align-items-center">
    <h2>{{$category ? "Список блюд категории ".$category->name : 'Неверный ID категории' }}</h2>
    <div class="container my-4">
        <div class="row g-4">
            @foreach($category->dishes as $dish)
                <div class="col-12 col-md-6">
                    <a href="{{url('dish/'.$dish->id)}}" style="text-decoration: none; color: black;">
                        <div class="card h-100 text-center" >
                            <img src="" class="card-img-top" alt="Image">
                            <div class="card-body">
                                <h5 class="card-title">{{$dish->name}}</h5>
                                <p class="card-text" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{$dish->cooking_method}}
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection


{{--@if($category)--}}
{{--    <table border="1">--}}
{{--        <td>id</td>--}}
{{--        <td>Наименование</td>--}}
{{--        <td>Способ приготовления</td>--}}
{{--        <td>Время приготовления</td>--}}
{{--        @foreach($category->dishes as $dish)--}}
{{--            <tr>--}}
{{--                <td>{{$dish->id}}</td>--}}
{{--                <td>{{$dish->name}}</td>--}}
{{--                <td>{{$dish->cooking_method}}</td>--}}
{{--                <td>{{$dish->cooking_time}}</td>--}}
{{--            </tr>--}}
{{--        @endforeach--}}
{{--    </table>--}}
{{--@endif--}}
