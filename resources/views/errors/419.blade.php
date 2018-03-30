@extends('default.layout')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Napaka 419
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="error-page">
                <h2 class="headline text-yellow"> 419</h2>

                <div class="error-content">
                    <br>
                    <h3><i class="fa fa-warning text-yellow"></i>Stran je potekla.</h3>

                    <p>
                        Stran ki ste jo želeli obiskati je potekla.
                        Najbolje da se vrnete <a href="{{ url()->previous() }}">nazaj na prejšnjo stran</a>.
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
