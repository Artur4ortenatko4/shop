@extends('admin.layouts.app')

@section('content')
    @include('admin.parts.content-header', [
        'page_title' => 'Категорії',
        'url_create' => route('admin.categories.create'),
    ])


    <!-- Main content -->
    <section class="content">
        @include('admin.seo.metatag')



        <div hidden class="card">
            <div class="card-header">
                <h3 class="card-title"></h3>

                <div class="card-tools">

                </div>
            </div>
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
                        </tr>
                    </thead>
                    <tbody class="sortable-y" data-url="{{ route('lte3.data.save') }}">
                        @foreach ($categories as $category)
                            <tr id="{{ $loop->index }}" class="va-center">
                                <td>
                                    {{ $category->id }}
                                </td>

                                <td>
                                    {{ $category->name }}
                                </td>

                                <td class="text-right">
                                    <a href="{{ route('admin.categories.update', $category->id) }}"
                                        class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="{{ route('admin.categories.destroy', $category->id) }}"
                                        class="btn btn-danger btn-sm js-click-submit" data-method="DELETE"
                                        data-confirm="Delete?"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>

        </div>
        {{-- @dd($categories); --}}

        {!! Lte3::nestedset($categories, [
            'label' => 'Категорії',
            'has_nested' => true,
            'routes' => [
                'edit' => 'admin.categories.show',
                'create' => 'admin.categories.create',
                'delete' => 'admin.categories.destroy',
                'order' => 'admin.categories.order',
                'params' => [],
            ],
        ]) !!}

        {!! Lte3::pagination($categories) !!}


    </section>
    <!-- /.content -->
@endsection
