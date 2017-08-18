<?php
Route::group(['middleware' => ['web']], function () {
    Route::group(['namespace' => 'Acr\Mobsis\Controllers', 'prefix' => 'acr/mobsis'], function () {
        Route::get('/', 'AcrMobsisController@index');
        Route::group(['middleware' => ['auth']], function () {
            Route::post('/order/active', 'AcrSepetController@orders_active');
            Route::group(['middleware' => ['admin']], function () {
                Route::post('/order/deactive', 'AcrSepetController@orders_deactive');
                Route::get('/config', 'AcrMobsisController@config');
                Route::post('/config', 'AcrMobsisController@config_set');

            });
            Route::group(['middleware' => ['mobsis']], function () {
                Route::get('/get_token', 'AcrMobsisController@get_token');
                Route::get('/user/control', 'AcrMobsisController@user_control');
                Route::get('/ogretmen/sinif/list', 'AcrMobsisController@ogretmen_sinif_list');

                Route::get('ogretmen/ders/list', 'AcrMobsisController@ogretmen_ders_list');
                Route::get('ogretmen/ders/islem', 'AcrMobsisController@ogretmen_ders_islem');
                Route::post('/ogretmen/ders/ekle', 'AcrMobsisController@ogretmen_ders_ekle');
                Route::get('/ogretmen/ders/form', 'AcrMobsisController@ogretmen_ders_form');

                // lisanslama market
                Route::get('/products_api', 'AcrMobsisController@products_api');

                //bildirimler
                Route::get('/bildirim/form', 'AcrMobsisController@bildirim_form');
                Route::post('/bildirim/form', 'AcrMobsisController@bildirim_form');
                Route::post('/bildirim/gonder', 'AcrMobsisController@bildirim_gonder');

                //çocuk verme
                Route::get('/ogretmen/cocuk/verme/liste', 'AcrMobsisController@ogretmen_cocuk_verme_liste');
                Route::post('/ogretmen/cocuk/verme/islem', 'AcrMobsisController@ogretmen_cocuk_verme_islem');


                // veliler
                Route::get('ogretmen/veli/list', 'AcrMobsisController@ogretmen_veli_list');
                Route::post('ogretmen/veli/list', 'AcrMobsisController@ogretmen_veli_list');
                Route::post('ogretmen/veli/islem', 'AcrMobsisController@ogretmen_veli_islem');

                //öğrenciler
                Route::get('ogretmen/ogrenci/list', 'AcrMobsisController@ogretmen_ogrenci_bekleyen_list');
                Route::post('ogretmen/ogrenci/list', 'AcrMobsisController@ogretmen_ogrenci_bekleyen_list');
                Route::post('ogretmen/ogrenci/islem', 'AcrMobsisController@ogretmen_ogrenci_islem');
            });
        });
    });
});