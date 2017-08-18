@extends('acr_mobsis.index')
@section('acr_mobsis')
    {!! $msg !!}
    <section class="content">
        <div class="row">
            <div class=" col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">MOBSİS Config</div>
                    <div class="box-body">
                        <form method="post" action="/acr/mobsis/config">
                            {{csrf_field()}}
                            <label>Username</label>
                            <input class="form-control" name="username" value="{{$config->username}}"/>
                            <label>Pass</label>
                            <input class="form-control" name="pass" value="{{$config->pass}}"/>
                            <div style="clear:both;"></div>
                            <br>
                            <button type="submit" class="btn btn-primary btn-lg btn-block">KAYDET</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@stop