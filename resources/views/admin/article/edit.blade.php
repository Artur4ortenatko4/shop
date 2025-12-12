@extends('admin.layouts.app')

@section('content')
    @include('admin.parts.content-header', [
        'page_title' => 'Редагувати Новину',
        'url_back' => route('admin.article.index'),
    ])

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Редагувати {{ $articles->name }}</h3>
            </div>
            <div class="card-body">
                {!! Lte3::formOpen(['action' => route('admin.article.update', $articles->id), 'model' => $articles, 'method' => 'PUT']) !!}
                @include('admin.article.inc.form', ['article' => $articles])
                {!! Lte3::formClose() !!}
            </div>

        </div>

    </section>
@endsection
