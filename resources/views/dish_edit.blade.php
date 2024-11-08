    @extends('layout')
    @section('content')
    <div class="container-lg d-flex justify-content-center flex-column align-items-center">
        <form method="post" class="w-50 mb-5" action={{url('dish/update/'.$dish->id)}} >
            @csrf
            <h2>Редактирование блюда</h2>

            <div class="mb-3">
                <label for="name" class="form-label">Наименование</label>
                <input type="text" name="name" id="name" class="form-control" value="@if (old('name')) {{old('name')}} @else {{$dish->name}}@endif"/>
                @error('name')
                <div class="is-invalid">{{$message}}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="cooking_method" class="form-label">Метод приготовления</label>
                <textarea name="cooking_method" id="cooking_method" class="form-control custom-input" rows="4"> {{ old('cooking_method', $dish->cooking_method) }}</textarea>
                @error('cooking_method')
                <div class="is-invalid">{{$message}}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="cooking_time" class="form-label">Время приготовления, мин</label>
                <input type="number" name="cooking_time" id="cooking_time" class="form-control" value="{{ old('cooking_time', $dish->cooking_time) }}" min="0" step="1"/>
                @error('cooking_time')
                <div class="is-invalid">{{$message}}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Категория блюда</label>
                <select name="category_id" id="category_id" class="form-select" value="{{old('category_id')}}">
                    <option value="" disabled selected>Выберите категорию</option>
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
            </div>

            <div class="mb-3">
                <label for="formFileMultiple" class="form-label">Фотографии</label>
                <input class="form-control" type="file" id="formFileMultiple" name="photos[]" multiple accept=".jpg, .jpeg, .png">
            </div>

            <div id="ingredientsContainer">
                <h4>Ингредиенты</h4>
                @foreach($dish->ingredient as $ingredient)
                    <div class="ingredient mb-3 border-top border-success">
                        <div class="d-flex justify-content-between align-items-center">
                            <label for="ingredient_{{ $ingredient->id }}" class="form-label">Ингредиент</label>
                            <button type="button" class="btn btn-outline-danger border-0" onclick="removeIngredient(this)">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <select name="ingredients[]" id="ingredient_{{ $ingredient->id }}" class="form-select">
                            <option value="" disabled>Выберите ингредиент</option>
                            @foreach($ingredients as $item)
                                <option value="{{ $item->id }}"
                                        @if($item->id == $ingredient->id) selected @endif>
                                    {{ $item->name }}, {{ $item->units }}
                                </option>
                            @endforeach
                        </select>
                        <label for="quantity_{{ $ingredient->id }}" class="form-label mt-3">Количество</label>
                        <input type="number" name="quantities[]" id="quantity_{{ $ingredient->id }}" class="form-control"
                               value="{{ $ingredient->pivot->quantity }}" placeholder="Введите количество" min="0" step="1"/>
                    </div>
                @endforeach
            </div>

            <button type="button" class="btn btn-secondary" id="addIngredient">Добавить ингредиент</button>

            <button type="submit" class="btn btn-success">Сохранить</button>
        </form>
    </div>

    <style>
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>
    <script>
        function removeIngredient(button) {
            // Удаляем родительский элемент .ingredient
            button.closest('.ingredient').remove();
        }

        document.getElementById('addIngredient').addEventListener('click', function() {
            const ingredientsContainer = document.getElementById('ingredientsContainer');
            const ingredientCount = ingredientsContainer.getElementsByClassName('ingredient').length + 1;

            const newIngredientDiv = document.createElement('div');
            newIngredientDiv.classList.add('ingredient', 'mb-3', 'border-top', 'border-success');
            newIngredientDiv.innerHTML = `
                <div class="d-flex justify-content-between align-items-center">
                    <label for="ingredient_1" class="form-label">Ингредиент</label>
                    <button type="button" class="btn btn-outline-danger border-0" onclick="removeIngredient(this)">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <select name="ingredients[]" id="ingredient_${ingredientCount}" class="form-select">
                    <option value="" disabled selected>Выберите ингредиент</option>
                    @foreach($ingredients as $ingredient)
            <option value="{{ $ingredient->id }}">{{ $ingredient->name }}, {{ $ingredient->units }}</option>
                    @endforeach
            </select>
            <label for="quantity_${ingredientCount}" class="form-label mt-3">Количество</label>
                    <input type="number" name="quantities[]" id="quantity_1" class="form-control" placeholder="Введите количество" min="0" step="1"/>
            `;

            ingredientsContainer.appendChild(newIngredientDiv);
        });
        document.querySelectorAll('input[type="text"], select').forEach(function(element) {
            element.addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                }
            });
        });
    </script>
    @endsection
