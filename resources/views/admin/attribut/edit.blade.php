@extends('admin.layouts.app')

@section('content')

@include('admin.parts.content-header', [
    'page_title' => 'Редагувати Атрибут',
    'url_back' => route('admin.attribut.index'),
])

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Редагувати {{  $attributs->name }}</h3>
            </div>
            <div class="card-body">
            {!! Lte3::formOpen(['action' => route('admin.attribut.update', $attributs->id), 'model' => null, 'method' => 'PUT']) !!}
    @include('admin.attribut.inc.form',compact('categories','attributs'))
            {!! Lte3::formClose() !!}
            </div>

        </div>

        </section>
@endsection
