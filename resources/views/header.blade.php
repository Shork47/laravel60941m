<header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top" style="background: #023731">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">NiceCook</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" aria-current="page" data-bs-toggle="dropdown"
                           href={{url('dish')}}>Блюда</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href={{url('dish')}}>Все блюда</a></li>
                            <li><a class="dropdown-item" href={{url('dish/create')}}>Добавить блюдо</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('category')}}">Категории блюд</a>
                    </li>
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link disabled" aria-disabled="true">Пользователи</a>--}}
{{--                    </li>--}}
                </ul>
                @if(!Auth::user())
                    <form class="d-flex" method="post" action={{url('auth')}}>
                        @csrf
                        <input class="form-control me-2" type="text" placeholder="Логин" name="email" aria-label="Логин" value="{{ old('email') }}"/>
                        <input class="form-control me-2" type="password" placeholder="Пароль" name="password" aria-label="Пароль" value="{{ old('password') }}"/>
                        <button class="btn btn-outline-danger me-2" type="submit">Войти</button>
                        <a class="btn btn-outline-info" href="{{url('registration')}}">Регистрация</a>
                    </form>
                @else
                    <ul class="navbar-nav">
                        <a class="nav-link active" href="#"><i class="fa fa-user" style="font-size: 20px;color: white;"></i>
                            <span>  </span>{{ Auth::user()->name }}</a>
                        <a class="btn btn-outline-danger my-2 my-sm-0" href="{{url('logout')}}">Выйти</a>
                    </ul>
                @endif
            </div>
        </div>
    </nav>
</header>
