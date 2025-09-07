@extends('layout')
@section('content')
<div class="container mt-5 w-100 d-flex flex-column align-items-center">
<h2>Список категорий:</h2>
<div class="container my-4">
    <div class="row g-4">
    @foreach($categories as $category)
        <div class="col-12 col-md-6">
            <div class="card h-100 text-center" style="border-radius: 10px; border: 1px solid #000000;">
                <a href="{{url('category/'.$category->id)}}" style="text-decoration: none; color: black;">
                    @if($category->photo_path)
                        <img src="{{ Storage::disk('minio')->url($category->photo_path) }}" class="card-img-top" alt="Фото категории" style="object-fit: cover; height: 300px; width: 100%; border-radius: 10px;">
                    @else
                        <img src="" class="card-img-top" alt="Фото категории" style="object-fit: cover; height: 300px; width: 100%; border-radius: 10px;">
                    @endif
{{--                    <img src="{{ Storage::disk('minio')->url($category->photo_path) }}" class="card-img-top" alt="Фото категории" style="object-fit: cover; height: 300px; width: 100%; border-radius: 10px;">--}}
                    <div class="card-body">
                        <h2 class="card-text">{{$category->name}}</h2>
                    </div>
                </a>
            </div>
        </div>
    @endforeach
    </div>
</div>
</div>
@endsection
