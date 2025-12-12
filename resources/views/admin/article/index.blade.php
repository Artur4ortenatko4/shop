@extends('admin.layouts.app')

@section('content')
    @include('admin.parts.content-header', [
        'page_title' => 'Новини',
        'url_create' => route('admin.article.create'),
    ])

    <!-- Main content -->
    <section class="content">

        @include('admin.seo.metatag')

        <!-- Default box -->
        <div class="card">

            <div class="card-body">

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 1%">
                                №
                            </th>
                            <th style="width: 20%">
                                Назва
                            </th>
                            <th style="width: 20%">
                                Фото
                            </th>

                            <th style="width: 30%">
                                Опис
                            </th>
                            <th>
                                Час створення
                            </th>
                        </tr>
                    </thead>
                    <tbody class="sortable-y" data-url="{{ route('lte3.data.save') }}">
                        @foreach ($articles as $article)
                            <tr id="{{ $loop->index }}" class="va-center">
                                <td>
                                    {{ $article->id }}
                                </td>

                                <td>
                                    {{ $article->name }}
                                </td>
                                <td>
                                    @if ($article->hasMedia('photo'))
                                        <a href="{{ $article->getFirstMediaUrl('photo') }}" class="js-popup-image">
                                            <img src="{{ $article->getFirstMediaUrl('photo') }}" width="150px">
                                        </a>
                                    @else
                                        <p>Фото не було додано</p>
                                    @endif
                                </td>
                                <td>
                                    {{ $article->content }}
                                </td>
                                <td>
                                    {{ $article->created_at }}
                                </td>

                                <td class="text-right">
                                    <a href="{{ route('admin.article.update', $article->id) }}"
                                        class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="{{ route('admin.article.destroy', $article->id) }}"
                                        class="btn btn-danger btn-sm js-click-submit" data-method="DELETE"
                                        data-confirm="Delete?"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>

        </div>
        {!! Lte3::pagination($article) !!}
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection
