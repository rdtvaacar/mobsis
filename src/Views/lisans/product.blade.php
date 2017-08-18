@extends('acr_mobsis.index')
@section('acr_mobsis')
    <section class="content">
        <div class="row">
            <div class=" col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">Market</a>
                    </div>
                    <div class="box-body">
                        <table>

                        </table>
                        @foreach($veri->products as $pdoduct)
                            {{$pdoduct->product_name}}
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
