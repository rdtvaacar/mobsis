@extends('acr_mobsis.index')
@section('header')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@stop
@section('acr_mobsis')
    {!! empty($msg)?'':$msg !!}
    <section class="content">
        <div class="row">
            <div class=" col-md-3">
                <div class="box box-primary">
                    <div class="box-header with-border">Sınıf Seç</div>
                    <div class="box-body">
                        {!! $ders_list !!}
                    </div>
                </div>
            </div>
            <div class=" col-md-5">
                <div class="box box-primary">
                    <div class="box-header with-border">Gönderilen Bildirimler</div>
                    <div class="box-body">
                        @if(!empty($ders_id))
                            <table class="table">
                                @foreach($veri->data->ogretmen_bildirimler as $bildirim)
                                    <tr>
                                        <td>
                                            <h4 style="float: left;" class="text-aqua">{{$bildirim->header}}</h4>
                                            <div style="text-align: right; font-size: small" class="text-muted">{{$bildirim->created_at}}</div>
                                            <div style="clear:both;"></div>
                                            <div style="text-indent: 20px;">{{$bildirim->content}}</div>
                                            <div style="clear:both;"></div>
                                            <span class="text-muted" style=" font-size: 9pt;">
                                            @foreach($bildirim->events_user_type as $key=>$user_type)
                                                    {{$user_type->ad}}
                                                    @if(count($bildirim->events_user_type)>$key+1)
                                                        ,
                                                    @endif
                                                @endforeach
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                    </div>
                </div>
            </div>
            <div class=" col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">Bildirim Gönderme Formu</div>
                    <div class="box-body">
                        @if(!empty($ders_id))
                            <form method="post" action="/acr/mobsis/bildirim/gonder">
                                <input type="hidden" name="ders_id" value="{{$ders_id}}"/>
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label>Bildirim</label>
                                    <input required class="form-control" name="baslik"/>
                                </div>
                                <div class="form-group">
                                    <label>İçerik</label>
                                    <textarea required class="form-control" name="icerik"></textarea>
                                </div>
                                <table class="table">
                                    <tr>
                                        <td width="200">
                                            <label for="ogretmen_durum">Öğretmenlere Gönder</label>
                                        </td>
                                        <td>
                                            <input id="ogretmen_durum" name="ogretmen_durum" style="float: right;" type="checkbox"
                                                   value="1" data-toggle="toggle" data-size="small"
                                                   data-on="AKTİF" data-off="PASİF">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Velilere Gönder</label>
                                        </td>
                                        <td>
                                            <input name="veli_durum" checked style="float: right;" type="checkbox"
                                                   value="1" data-toggle="toggle" data-size="small"
                                                   data-on="AKTİF" data-off="PASİF">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Öğrencilere Gönder</label>
                                        </td>
                                        <td>
                                            <input name="ogrenci_durum" style="float: right;" type="checkbox"
                                                   value="1" data-toggle="toggle" data-size="small"
                                                   data-on="AKTİF" data-off="PASİF">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Servislere Gönder</label>
                                        </td>
                                        <td>
                                            <input name="servis_durum" style="float: right;" type="checkbox"
                                                   value="1" data-toggle="toggle" data-size="small"
                                                   data-on="AKTİF" data-off="PASİF">
                                        </td>
                                    </tr>
                                </table>
                                <div style="clear:both;"></div>
                                <br>
                                <button type="submit" class="btn btn-primary btn-block btn-lg">BİLDİRİM GÖNDER</button>
                            </form>
                        @else
                            <div class="alert alert-danger">Lütfen sınıf seçiniz.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('footer')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
@stop
