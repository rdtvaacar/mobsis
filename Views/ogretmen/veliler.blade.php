@extends('acr_mobsis.index')
@section('header')
    <link rel="stylesheet" href="/plugins/datatables/dataTables.bootstrap.css">
@stop
@section('acr_mobsis')
    <div id="msg">{!! empty($msg)?'':$msg !!}</div>
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
                    <div class="box-header with-border">Bekleyen Veliler</div>
                    <div class="box-body">
                        <table class="table">
                            @foreach($bekleyen->data as $veli)
                                <tr id="bekleyen_{{$veli->id}}">
                                    <td>
                                        <h4 class="text-aqua">{{$veli->name}}</h4>
                                        <div style="clear:both;"></div>
                                        <ol class="text-green">
                                            @foreach($veli->users as $ogr)
                                                <li>{{$ogr->name}}
                                                    <ol class="text-maroon">
                                                        @foreach($ogr->siniflar as $sinif)
                                                            <li>{{$sinif->ad}}</li>
                                                        @endforeach
                                                    </ol>
                                                </li>
                                            @endforeach
                                        </ol>

                                    </td>
                                    <td>
                                        <div onclick="veli_islem({{$veli->id}},1)" class="btn btn-sm btn-success btn-block">ONAYLA</div>
                                        <div onclick="veli_islem({{$veli->id}},-1)" class="btn btn-sm btn-danger btn-block">SİL</div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            <div class=" col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">Veli Listesi</div>
                    <div class="box-body">
                        @if(!empty($ders_id))
                            <table class="table">

                                @foreach($veliler->data as $veli)
                                    <tr id="bekleyen_{{$veli->id}}">
                                        <td>
                                            <h4 class="text-aqua">{{$veli->name}}</h4>
                                            <div style="clear:both;"></div>
                                            <ol class="text-green">
                                                @if(!empty($veli->users))
                                                    @foreach($veli->users as $ogr)
                                                        <li>{{$ogr->name}}
                                                            <ol class="text-maroon">
                                                                @foreach($ogr->siniflar as $sinif)
                                                                    <li>{{$sinif->ad}}</li>
                                                                @endforeach
                                                            </ol>
                                                        </li>
                                                    @endforeach
                                                @endif

                                            </ol>

                                        </td>
                                        <td width="40">
                                            <div onclick="veli_islem({{$veli->id}},0)" class="btn btn-sm btn-warning btn-block">BEKLEYENLERE AL</div>
                                            <div onclick="veli_islem({{$veli->id}},-1)" class="btn btn-sm btn-danger btn-block">SİL</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
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
    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script>
        $('#data_table').DataTable({
            "paging"      : true,
            "lengthChange": false,
            "searching"   : true,
            "ordering"    : true,
            "info"        : true,
            "autoWidth"   : true,
            "language"    : {
                "sProcessing" : "İşleniyor...",
                "lengthMenu"  : "Sayfada _MENU_ satır gösteriliyor",
                "zeroRecords" : "Gösterilecek sonuç yok.",
                "info"        : "Toplam _PAGES_ sayfadan _PAGE_. sayfa gösteriliyor",
                "infoEmpty"   : "Gösterilecek öğe yok",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "search"      : "Arama yap",
                "oPaginate"   : {
                    "sFirst"   : "İlk",
                    "sPrevious": "Önceki",
                    "sNext"    : "Sonraki",
                    "sLast"    : "Son"
                }

            }
        });

        function veli_islem(veli_id, status) {
            $.ajax({
                type   : "POST",
                url    : "/acr/mobsis/ogretmen/veli/islem",
                data   : 'veli_id=' + veli_id + '&status=' + status,
                success: function (msg) {
                    if (msg[0] == 1) {
                        $('#bekleyen_' + veli_id).hide();
                        $('#msg').html(msg[1])
                    }
                }
            });
        }
    </script>
@stop
