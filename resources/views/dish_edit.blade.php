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

{{--        <div class="mb-3">--}}
{{--            <label for="formFileMultiple" class="form-label">Фотографии</label>--}}
{{--            <input class="form-control" type="file" id="formFileMultiple" name="photos[]" multiple accept="image/*" onchange="validatePhotos()">--}}
{{--            <small class="form-text text-muted">Максимум 3 фотографии.</small>--}}
{{--            @error('photos')--}}
{{--            <div class="is-invalid">{{ $message }}</div>--}}
{{--            @enderror--}}
{{--        </div>--}}
        <h4>Фотографии</h4>
        <div id="photoPreview" class="d-flex flex-wrap mt-3">
            @foreach($dish->photo as $photo)
                <div class="position-relative d-inline-block">
                    <img src="{{ Storage::disk('minio')->url($photo->path) }}" class="img-thumbnail m-1" alt="Фото блюда" style="width: 100px; height: 100px; object-fit: cover">
{{--                    <button type="button" class="btn btn-danger fas fa-trash-alt btn-sm position-absolute top-0 end-0 m-1" onclick="removePhoto({{ $photo->id }}, this)"></button>--}}
                </div>
            @endforeach
        </div>
        <div id="existingPhotosContainer" style="display: none;"></div>

        <div id="ingredientsContainer">
            <h4>Ингредиенты</h4>
            <small>В случае если нет необходимого ингредниента, впришите его по примеру.<br>Пример: Гречка,г</small>
            @foreach($dish->ingredient as $ingredient)
                <div class="ingredient mb-3 border-top border-success">
                    <div class="d-flex justify-content-between align-items-center">
                        <label for="ingredient_{{ $ingredient->id }}" class="form-label">Ингредиент</label>
                        <button type="button" class="btn btn-outline-danger border-0" onclick="removeIngredient(this)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <input type="text" name="ingredient_names[]" id="ingredient_{{ $ingredient->id }}" class="form-control"
                           placeholder="Начните вводить необходимый ингредиент" list="ingredientsList_{{ $ingredient->id }}"
                           value="{{ $ingredient->name }}, {{ $ingredient->units }}" autocomplete="off" />
                    <datalist id="ingredientsList">
                        @foreach($ingredients as $item)
                            <option value="{{ $item->name }}, {{$item->units}}"
                                    @if($item->id == $ingredient->id) selected @endif>
                            </option>
                        @endforeach
                    </datalist>
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
            <input type="text" name="ingredient_names[]" id="ingredient_${ingredientCount}" class="form-control"
                           placeholder="Начните вводить необходимый ингредиент" list="ingredientsList_${ingredientCount}"
                           autocomplete="off" />
            <datalist id="ingredientsList_${ingredientCount}">
                @foreach($ingredients as $item)
                    <option value="{{ $item->name }}, {{ $item->units }}"></option>
                @endforeach
            </datalist>
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

    // function validatePhotos() {
    //     const fileInput = document.getElementById('formFileMultiple');
    //     const photoPreview = document.getElementById('photoPreview');
    //     const fileCount = fileInput.files.length;
    //
    //     // Очищаем контейнер с предпросмотром
    //     // photoPreview.innerHTML = '';
    //
    //     if (fileCount > 3) {
    //         alert("Вы можете загрузить не более 3 фотографий.");
    //         fileInput.value = ''; // Сбросить выбор файлов
    //         return;
    //     }
    //
    //     // Отображаем миниатюры
    //     Array.from(fileInput.files).forEach(file => {
    //         const reader = new FileReader();
    //         reader.onload = function(e) {
    //             const img = document.createElement('img');
    //             img.src = e.target.result;
    //             img.className = 'img-thumbnail m-1';
    //             img.style.width = '100px';
    //             img.style.height = '100px';
    //             img.style.objectFit = 'cover';
    //             photoPreview.appendChild(img);
    //         };
    //         reader.readAsDataURL(file);
    //     });
    // }
    //
    // function removePhoto(photoId, button) {
    //     // Удаляем родительский элемент (обертку) с изображением
    //     const photoContainer = button.closest('.position-relative');
    //     photoContainer.remove();
    //
    //     // Добавляем скрытое поле для удаления на сервере
    //     const input = document.createElement('input');
    //     input.type = 'hidden';
    //     input.name = 'photos_to_delete[]'; // Массив для хранения ID удаляемых фотографий
    //     input.value = photoId;
    //
    //     // Находим контейнер для скрытых полей и добавляем новое поле
    //     document.getElementById('existingPhotosContainer').appendChild(input);
    // }
</script>
@endsection
