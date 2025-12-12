@extends('admin.auth.app')

@section('content')
    <section class="vh-100" style="background-color: #eee;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Авторизація</p>
                                    @if (session('status'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @endif


                                    {!! Lte3::formOpen(['action' => '/login', 'method' => 'POST']) !!}
                                    {!! Lte3::text('email', null, [
                                        'type' => 'email',
                                        'placeholder' => 'Емейл',
                                        'label' => '',
                                        'class_wrap' => 'mb-3',
                                        'append' => '<i class="fas fa-envelope"></i>',
                                    ]) !!}
                                    {!! Lte3::text('password', null, [
                                        'type' => 'password',
                                        'placeholder' => 'Пароль',
                                        'label' => '',
                                        'class_wrap' => 'mb-3',
                                        'append' => '<i class="fas fa-lock"></i>',
                                    ]) !!}
                                    <div class="row">
                                        <div class="col-7">
                                            {!! Lte3::checkbox('remember', null, ['label' => 'Запам\'ятати мене', 'class_wrap' => 'icheck-primary']) !!}
                                        </div>
                                        <div class="col-5">
                                            <button type="submit" class="btn btn-primary btn-block">Авторизуватись</button>
                                        </div>
                                    </div>
                                    {!! Lte3::formClose() !!}


                                    <p class="mb-1">
                                        <a href="/forgot-password">Забув пароль?</a>
                                    </p>

                                    <p class="mb-0">
                                        <a href="/register" class="text-center">Не зареєстрований ?</a>
                                    </p>



                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp"
                                        class="img-fluid" alt="Sample image">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
