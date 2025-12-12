@extends('admin.layouts.app')

@section('content')

@include('admin.parts.content-header', [
    'page_title' => 'Редагувати Категорію',
    'url_back' => route('admin.categories.index'),
])

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Редагувати {{  $categories->name }}</h3>
            </div>
            <div class="card-body">
            {!! Lte3::formOpen(['action' => route('admin.categories.update', $categories->id), 'model' => $categories, 'method' => 'PUT']) !!}
    @include('admin.categories.inc.form', ['categories' => $categories])
            {!! Lte3::formClose() !!}
            </div>

        </div>

        </section>
@endsection
