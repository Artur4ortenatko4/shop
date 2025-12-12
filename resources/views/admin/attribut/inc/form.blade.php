@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
{!! Lte3::text('name', isset($attributs->name) ? $attributs->name : '') !!}


{!! Lte3::select2(
    'categories',
    isset($attributs->categories) ? $attributs->categories->pluck('id')->toArray() : [],
    $categories,
    [
        'label' => 'Категорії',
        'multiple' => 1,
        'id' => 'categories',
    ],
) !!}








{!! Lte3::btnSubmit('Зберегти', null, null, ['add' => 'fixed']) !!}
