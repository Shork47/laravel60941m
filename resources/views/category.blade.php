@extends('layout')
@section('content')
<div class="container mt-5 w-100 d-flex flex-column align-items-center">
<h2>{{$category ? "Список блюд категории ".$category->name : 'Неверный ID категории' }}</h2>
    <div class="container my-4">
        <div class="row g-4">
            @foreach($category->dishes as $dish)
                <div class="col-12 col-md-6">
                    <a href="{{url('dish/'.$dish->id)}}" style="text-decoration: none; color: black;">
                        <div class="card h-100 text-center" style="border-radius: 10px; border: 1px solid #000000;">
                            <img src="{{ $dish->photo->first() ? Storage::disk('minio')->url($dish->photo->first()->path) : '' }}" class="card-img-top" alt="Image" style="object-fit: cover; height: 300px; width: 100%; border-radius: 10px;">
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
