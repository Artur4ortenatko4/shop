@extends('admin.layouts.app')

@section('content')

@include('admin.parts.content-header', [
    'page_title' => 'Створити Атрибут',
    'url_back' => route('admin.attribut.index'),
])
<section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Створити</h3>
            </div>
            <div class="card-body">
            {!! Lte3::formOpen(['action' => route('admin.attribut.store'), 'model' => null, 'method' => 'POST']) !!}
    @include('admin.attribut.inc.form')
            {!! Lte3::formClose() !!}
            </div>

        </div>

        </section>
@endsection
