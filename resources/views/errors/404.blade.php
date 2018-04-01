@extends('default.layout')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Napaka 404
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="error-page">
                <h2 class="headline text-yellow"> 404</h2>

                <div class="error-content">
                    <br>
                    <h3><i class="fa fa-warning text-yellow"></i>Stran ni najdena.</h3>

                    <p>
                        Stran ki ste jo želeli obiskati, ni najdena.
                        Najbolje da se vrnete na <a href="/">domačo stran</a>.
                    </p>
                </div>
                <!-- /.error-content -->
            </div>
            <!-- /.error-page -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection
