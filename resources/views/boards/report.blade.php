@extends('default.layout')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Tabla
            </h1>
        </section>
        @include('layout.error')
        <!-- Main content -->
        <section class="content">

            <div class="row">

                {{-- left narrow column --}}
                <div class="col-md-4">
                
                @include('boards.reportDetail')
                    {{--here my be included some other part --}}
                </div>
                <!-- /.col -->

                {{-- right wide column --}}
                <div class="col-md-8">
                
                
                @if(isset($cards))   
                @include('boards.reportCards')
                @endif
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

        </section>
        <!-- /.content -->
    </div>

@endsection