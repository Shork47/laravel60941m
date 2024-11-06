<div class="container" style="margin-top: 80px">
    @error('email')
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{$message}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @enderror
    @error('password')
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{$message}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @enderror
    @error('error')
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{$message}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @enderror
    @error('success')
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{$message}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @enderror
</div>




{{--<!DOCTYPE html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <title>test_laravel_60941m</title>--}}
{{--</head>--}}
{{--<body>--}}
{{--    <h2>{{ $message }}</h2>--}}
{{--    <a href="{{url('dish')}}">Назад</a>--}}
{{--</body>--}}
{{--</html>--}}

