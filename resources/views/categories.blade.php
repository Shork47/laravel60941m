@extends('layout')
@section('content')
<div class="container mt-5 w-100 d-flex flex-column align-items-center">
<h2>Список категорий:</h2>
<div class="container my-4">
    <div class="row g-4">
    @foreach($categories as $category)
        <div class="col-12 col-md-6">
            <div class="card h-100 text-center" >
                <a href="{{url('category/'.$category->id)}}" style="text-decoration: none; color: black;">
                    <img src="..." class="card-img-top" alt="...">
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



{{--<table border="1">--}}
{{--    <thead>--}}
{{--    <td>id</td>--}}
{{--    <td>Наименование</td>--}}
{{--    </thead>--}}
{{--    @foreach($categories as $category)--}}
{{--        <tr>--}}
{{--            <td>{{$category->id}}</td>--}}
{{--            <td>{{$category->name}}</td>--}}
{{--        </tr>--}}
{{--    @endforeach--}}
{{--</table>--}}
