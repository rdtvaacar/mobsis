@extends('acr_mobsis.index')
@section('header')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@stop
@section('acr_mobsis')
    {!! empty($msg)?'':$msg !!}
    <section class="content">
        <div class="row">
            <div class=" col-md-2">
                <div class="box box-primary">
                    <div class="box-header with-border"></div>
                    <div class="box-body">
                        <a class="btn btn-block btn-sm {{$status == 0?'btn-success':'btn-default'}}" href="/acr/mobsis/ogretmen/cocuk/verme/liste?status=0">YENİ İSTEKLER</a>
                        <a class="btn btn-block btn-sm {{$status == 1?'btn-success':'btn-default'}}" href="/acr/mobsis/ogretmen/cocuk/verme/liste?status=1">ONAYLANMIŞ</a>
                        <a class="btn btn-block btn-sm {{$status == 2?'btn-success':'btn-default'}}" href="/acr/mobsis/ogretmen/cocuk/verme/liste?status=2">TAMAMLANMIŞ</a>
                    </div>
                </div>
            </div>
            <div class=" col-md-10">
                <div class="box box-primary">
                    <div class="box-header with-border">Öğrenci Verme İşlemleri</div>
                    <div class="box-body">
                        <table class="table">
                            @foreach($veri->data as $data)
                                <tr id="istek_{{$data->id}}">
                                    <td id="istek_td_{{$data->id}}">
                                        <h4 style="float: left;" class="text-aqua">{{$data->veli->name}} - {{$data->sinif->ad}} {{!empty($data->ogr)? '('.$data->ogr->name.')':''}}</h4>
                                        <div style="text-align: right; font-size: small" class="text-muted">{{date('d/m/Y H:i',strtotime($data->created_at))}}</div>
                                        <div style="clear:both;"></div>
                                        <div style="text-indent: 20px;" class="text-navy">
                                            Alacak Kişi :
                                            @if($data->kendim_alacagim == 0)
                                                <span class="text-green">Kendisi</span>
                                            @else
                                                <span class="text-red">{{$data->alacak_ad}}</span>
                                            @endif
                                            | {{date('d/m/Y H:i',strtotime($data->tarih))}}
                                        </div>
                                        <div style="clear:both;"></div>
                                        <span class="text-muted" style=" font-size: 9pt;">
                                                @if($data->status ==-1)
                                                Alınacak saati onayınız bekleniyor.
                                            @elseif($data->status ==1)
                                                Onay tarihi : {{date('d/m/Y H:i',strtotime($data->updated_at))}}
                                            @else
                                                Onay tarihi : {{date('d/m/Y H:i',strtotime($data->tarih))}}
                                            @endif
                                            </span>
                                        <hr style="padding: 2px; margin: 2px;">
                                        @foreach($islem_list  as $key=>$islem)
                                            @if($key !=$data->status)
                                                <div class="btn btn-{{$islem[1]}} btn-sm" onclick="verme_islem({{$data->id}},{{$key}})">{{$islem[0]}}</div>
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>

                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
@stop
@section('footer')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script>
        function verme_islem(id, status) {
            $.ajax
            ({
                type   : "POST",
                url    : "/acr/mobsis/ogretmen/cocuk/verme/islem",
                data   : "status=" + status + '&id=' + id,
                success: function (msg) {
                    if (status != msg[0]) {
                        $("#istek_td_" + id).hide();
                        $("#istek_" + id).html('<td><span class="text-maroon">' + msg[1] + '</span></td>')
                    }

                }
            });
        }

    </script>
@stop
