<form action="" method="post">
    {{csrf_field()}}
    <select class="form-control" name="ders_id">
        <option value="">Seçiniz</option>
        @foreach($veri->data as $sinif)
            <option {{ $ders_id == $sinif->id ?'selected':'' }} value="{{$sinif->id}}">{{$sinif->ad}}</option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-primary btn-block">SINIF SEÇ</button>
</form>

