@extends('admin.layouts.app')

@section('content')
    @include('admin.parts.content-header', [
        'page_title' => 'Атрибути',
        'url_create' => route('admin.attribut.create'),
    ])

    <!-- Main content -->
    <section class="content">



        <!-- Default box -->
        <div class="card">

            <div class="card-body">

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 1%">
                                №
                            </th>
                            <th>
                                Назва
                            </th>
                            <th>
                                Категорія
                            </th>



                        </tr>
                    </thead>
                    <tbody class="sortable-y" data-url="{{ route('lte3.data.save') }}">
                        @foreach ($attributs as $attribut)
                            <tr id="{{ $loop->index }}" class="va-center">
                                <td>
                                    {{ $attribut->id }}
                                </td>
                                <td>
                                    {{ $attribut->name }}
                                </td>
                                <td>
                                    @foreach ($attribut->categories as $category)
                                        {{ $category->name }}
                                    @endforeach
                                </td>



                                <td class="text-right">
                                    <a href="{{ route('admin.attribut.update', $attribut->id) }}" class="btn btn-info btn-sm"><i
                                            class="fas fa-pencil-alt"></i></a>
                                    <a href="{{ route('admin.attribut.destroy', $attribut->id) }}"
                                        class="btn btn-danger btn-sm js-click-submit" data-method="DELETE"
                                        data-confirm="Delete?"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>

        </div>
        <!-- /.card -->
        {!! Lte3::pagination($attributs) !!}
    </section>
    <!-- /.content -->
@endsection
