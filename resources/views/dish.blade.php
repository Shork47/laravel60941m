@extends('layout')
@section('content')
<div class="container-md">
    <h2 style="text-align: center">{{$dish ? "".$dish->name : 'Неверный ID блюда' }}</h2>
    @if($dish)
        @if(Auth::check() && (Auth::user()->id == $dish->user_id || Auth::user()->is_admin))
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ url('dish/edit/'.$dish->id) }}" class="btn btn-warning me-2"><i class="far fa-edit"></i></a>
                <a href="{{url('dish/destroy/'.$dish->id)}}" class="btn btn-danger"><i class="far fa-trash-alt"></i></a>
            </div>
        @endif
        <div id="carouselExampleControlsNoTouching" class="carousel slide" data-bs-touch="false" data-bs-interval="false" style="width: 50%; margin: 0 auto;"   >
            <div class="carousel-inner">
                @foreach($dish->photo as $photo)
                    <div class="carousel-item @if($loop->first) active @endif">
                        <img src="{{ Storage::disk('minio')->url($photo->path) }}" class="d-block w-100" alt="Фото блюда" style="object-fit: cover; height: 350px; width: 100%; border-radius: 10px;">
{{--                        <p>{{ Storage::disk('minio')->url($photo->path) }}</p>--}}
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <h2 style="text-align: center">{{"Список ингредиентов для блюда ".$dish->name}}</h2>
        <div class="d-flex justify-content-center">
        <table class="table table-bordered border border-dark text-center align-middle" style="width: 50%;box-shadow: 0 0 0 2px black;  overflow: hidden; border-radius: 10px">
{{--            <td>id</td>--}}
            <td style="background: #b9e4e0">Наименование</td>
            <td style="background: #b9e4e0">Количество</td>
{{--            <td>Единицы измерения</td>--}}
            @foreach($dish->ingredient as $ingredient)
                <tr>
{{--                    <td>{{$ingredient->id}}</td>--}}
                    <td>{{$ingredient->name}}</td>
                    <td>{{$ingredient->pivot->quantity}} {{$ingredient->units}}</td>
{{--                    <td>{{$ingredient->units}}</td>--}}
                </tr>
            @endforeach
        </table>

        </div>
        <div class="container" style="width: 50%;">
            <h2 style="text-align: center">{{"Время приготовления: ".$dish->cooking_time}}</h2>
            <div class="justified-text" style="text-align: justify;">
                <p style="justify-content: space-between;">{{ $dish->cooking_method }}</p>
            </div>
        </div>
    @endif
</div>
@endsection
