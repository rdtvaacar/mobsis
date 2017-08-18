@extends('acr_mobsis.index')
@section('acr_mobsis')
    <section class="content">
        <div class="row">
            <div class=" col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">Öğretmen Sınıf Listesi
                        <a style=" float: right;" class=" btn btn-primary" href="/acr/mobsis/ogretmen/ders/form">Ders Ekle</a>
                    </div>
                    <div class="box-body">
                        @foreach($veri->data as $sinif)
                            @if($sinif->status !=-1)
                                <div class="col-md-3">
                                    <table class="table ">
                                        <tr>
                                            <th style=" text-align: left">{{$sinif->ad}}</th>
                                            <th>
                                                <a style="float: right" class="btn btn-info btn-xs" href="/acr/mobsis/ogretmen/ders/form?&ders_id={{$sinif->id}}">DÜZENLE</a>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td>Aktif Öğrenci Sayısı</td>
                                            <td style="text-align: center">{{$sinif->aktif_ogr_count}}</td>
                                        </tr>
                                        <tr>
                                            <td>Pasif Öğrenci Sayısı</td>
                                            <td style="text-align: center">{{$sinif->pasif_ogr_count}}</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                @if($sinif->status == 0)
                                                    <a class="btn btn-success btn-sm" href="/acr/mobsis/ogretmen/ders/islem?status=1&sinif_id={{$sinif->id}}">AKTİF YAP</a>
                                                @else
                                                    <a class="btn btn-warning btn-sm" href="/acr/mobsis/ogretmen/ders/islem?status=0&sinif_id={{$sinif->id}}">PASİF YAP</a>
                                                @endif
                                            </td>

                                            <td>
                                                <div class="btn btn-danger btn-sm" style="float: right" onclick="sinif_sil({{$sinif->id}})">SINIFI SİL</div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('footer')
    <script>
        function sinif_sil(sinif_id) {
            if (confirm('Silmek istediğinizden emin misiniz ? Silme işlemi geri alınamaz!!!') == true) {
                $.ajax({
                    type   : "POST",
                    url    : "/acr/mobsis/ogretmen/ders/islem",
                    data   : 'sinif_id=' + sinif_id + '&status=-1',
                    success: function () {
                        location.reload();
                    }
                });
            }
        }
    </script>
@stop