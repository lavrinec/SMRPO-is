<!-- Profile Image -->
<div class="box box-primary">
    <div class="box-body box-profile">

        <h3 class="profile-username text-center">Table in projekti</h3>
        @if($groups->project->first()!=null)
            <ul class="list-group list-group-unbordered list-unstyled">
                @foreach($boards as $board)
                    <li class="">
                        <h5 class="text-bold text-muted">
                            <a href="/boards/{{$board->id}}/focus">
                                {{$board->board_name}}
                            </a>
                        </h5>
                        <ul class="" style="list-style: none;">
                            @foreach($board->projects as $project)
                                @if($project->group_id==$groups->id)
                                    <li><p>
                                            {{--<small>--}}
                                            <a href="/projects/{{$project->id}}/show">
                                                {{$project->board_name}}
                                            </a>
                                            {{--</small>--}}
                                        </p>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @endforeach


            </ul>

            @if(!empty($no_board_projects))
                <h5 class="text-bold text-muted">Projekti brez table</h5>
                <ul class="" style="list-style: none;">
                    @foreach($no_board_projects as $project)
                        <li>
                            <p>
                                {{--<small>--}}
                                <a href="/projects/{{$project->id}}/show">
                                    {{$project->board_name}}
                                </a>
                                {{--</small>--}}
                            </p>
                        </li>

                    @endforeach
                </ul>
            @endif

        @else
            <p class="text-muted">
                Na tej skupini ni nobenega projekta.
            </p>
        @endif


    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->


