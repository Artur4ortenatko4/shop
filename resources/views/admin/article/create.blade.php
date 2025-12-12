@extends('admin.layouts.app')

@section('content')

@include('admin.parts.content-header', [
    'page_title' => 'Створити Новини',
    'url_back' => route('admin.article.index'),
])
<section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Створити</h3>
            </div>
            <div class="card-body">
            {!! Lte3::formOpen(['action' => route('admin.article.store'), 'model' => null, 'method' => 'POST']) !!}
    @include('admin.article.inc.form')
            {!! Lte3::formClose() !!}
            </div>

        </div>

        </section>
@endsection
