@extends('layout')

@section('content')
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="container p-3" style="border-radius: 10px; border: 2px solid #000000">
            <h3 class="text-center">Регистрация</h3>
            <form action="{{ url('registration') }}" method="POST">
                @csrf

                <div class="form-floating mb-3">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Ваше имя" value="{{ old('name') }}" required>
                    <label for="name">Имя</label>
                    @error('name')
                    <div class=".is-invalid">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}" required>
                    <label for="email">Email</label>
                    @error('email')
                    <div class=".is-invalid">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Пароль" required>
                    <label for="password">Пароль</label>
                    @error('password')
                    <div class=".is-invalid">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Подтвердите пароль" required>
                    <label for="password_confirmation">Подтвердите пароль</label>
                </div>

                <div class="d-grid w-25 d-flex ">
                    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
                </div>
            </form>
        </div>
    </div>
    <style>
        @media (max-width: 768px) {
            .container {
                width: 95%;
            }
        }
        @media (min-width: 992px) {
            .container {
                width: 30%; /* или любое другое значение для уменьшения ширины */
            }
        }
    </style>
@endsection
