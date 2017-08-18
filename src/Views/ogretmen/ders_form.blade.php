@extends('acr_mobsis.index')
@section('header')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@stop
@section('acr_mobsis')
    <section class="content">
        <div class="row">
            <div class=" col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">Ders Formu
                        <a style=" float: right;" class=" btn btn-info" href="/acr/mobsis/ogretmen/ders/list"><< Derslere Geri Dön</a>
                    </div>
                    <div class="box-body">
                        <form method="post" action="/acr/mobsis/ogretmen/ders/ekle">
                            {{csrf_field()}}
                            <input value="{{$ders_id}}" name="ders_id" type="hidden"/>

                            <div class="form-group">
                                <label>DERS ADI</label>
                                <input class="form-control" name="ad" value="{{@$veri->data->ad}}"/>
                            </div>
                            <div class="form-group">
                                <label>DURUM</label>
                                <input name="status" style="float: right;" type="checkbox"
                                       {{!empty(@$veri->status) && @$veri->data->status == 1?'checked':''}} value="1" data-toggle="toggle" data-size="small"
                                       data-on="AKTİF" data-off="PASİF">
                            </div>

                            <div style="clear:both;"></div>
                            <br>
                            <button type="submit" class="btn btn-primary btn-block btn-lg">DERS BİLGİLERİNİ KAYDET</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('footer')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
@stop
