<?php

namespace Acr\Mobsis\Controllers;

use Acr\Mobsis\Model\Config;
use Auth;
use Illuminate\Http\Request;
use Ixudra\Curl\CurlService;

class AcrMobsisController extends Controller
{
    protected $mobsis_token;
    protected $admin_token;
    protected $user;

    #lisanslama ve market
    function products_api()
    {
        $user = self::curl('http://api.mobilogrencitakip.com/api/v1/user-info', null, 'post', self::get_token());
        $data = ['order_id' => 15];
        $veri = self::curl('http://api.mobilogrencitakip.com/api/v1/payment-credit-card', $data, 'post', self::get_token());
        dd($veri);
        $veri = self::curl('http://api.mobilogrencitakip.com/api/v1/adresses-info', null, 'post', self::get_token());
        dd($veri);
        $data = ['adress_id' => 1];
        $veri = self::curl('http://api.mobilogrencitakip.com/api/v1/select-adress', $data, 'post', self::get_token());
        dd($veri);

        $data = ['bank_id' => 1, 'order_id' => 1];
        $veri = self::curl('http://api.mobilogrencitakip.com/api/v1/payment-havale-eft', $data, 'post', self::get_token());
        dd($veri);
        $data = [
            'user_id'      => $user->data->id,
            'name'         => 'Adres -1 ',
            'invoice_name' => 'Alıcı 1 ',
            'tc'           => 'TC-1',
            'adress'       => 'adres satırı 1 ',
            'city'         => 15, // id olmalı
            'county'       => 20, // id olmalı
            'post_code'    => 15000,
            'tel'          => '0 543 425 9887',
            'type'         => 1,
            'company'      => 'Helix İşitme cihazları',
            'tax_number'   => 32323,
            'tax_office'   => 'Burdur',
            'e_fatura'     => 1
        ];
        $veri = self::curl('http://api.mobilogrencitakip.com/api/v1/adress-create', $data, 'post', self::get_token());
        dd($veri);
        $data = ['product_id' => 11];
        self::curl('http://api.mobilogrencitakip.com/api/v1/sepet-add-product', $data, 'post', self::get_token());
        $veri = self::curl('http://api.mobilogrencitakip.com/api/v1/sepet', null, 'post', self::get_token());
        dd($veri);
        $data = ['order_id' => 20];
        $veri = self::curl('http://api.mobilogrencitakip.com/api/v1/order_result', $data, 'post', self::get_token());
        dd($veri);
        $veri = json_decode($veri);
        dd($veri);
        $veri = self::curl('http://api.mobilogrencitakip.com/api/v1/products', null, 'post', self::get_token());
        dd($veri);
        return View('acr_mobsis::lisans.product', compact('veri'));
    }

    #lisanslama ve market

    //config
    function config()
    {
        $config_model = new Config();
        $config       = $config_model->first();
        $msg          = session('msg');
        return View('acr_mobsis::config', compact('config', 'msg'));

    }

    function config_set(Request $request)
    {
        $config_model = new Config();
        $data         = [
            'username' => $request->username,
            'pass'     => $request->pass

        ];
        $config_model->where('id', 1)->update($data);
        return redirect()->back()->with('msg', $this->basarili());

    }

// öğrenciler
    function ogretmen_ogrenci_islem(Request $request)
    {
        $data  = ['ogrenci_id' => $request->ogrenci_id, 'status' => $request->status];
        $veri  = self::curl('http://api.mobilogrencitakip.com/api/v1/ogretmen-ogrenci-islem', $data, 'post', self::get_token());
        $style = 'style="width: 300px; margin-left: auto; margin-right: auto; text-aling:center;"';
        $msg   = $veri->status == 1 ? '<div class="alert alert-success" ' . $style . '>' . $veri->msg . '</div>' : '<div  class="alert alert-danger" ' . $style . ' >' . $veri->msg . '</div>';
        return [$veri->status, $msg];
    }

    function ogretmen_ogrenci_bekleyen_list(Request $request)
    {
        $ders_id       = $request->ders_id;
        $ders_list     = self::ders_list($ders_id);
        $data_bekleyen = ['status' => 0, 'start' => 0, 'record' => 50];
        $data_veliler  = ['sinif_id' => $ders_id, 'start' => 0, 'record' => 50];
        $bekleyen      = self::curl('http://api.mobilogrencitakip.com/api/v1/ogretmen-ogrenci-bekleyen-list', $data_bekleyen, 'post', self::get_token());
        $ogrenciler    = self::curl('http://api.mobilogrencitakip.com/api/v1/ogretmen-sinif-ogrenci-list', $data_veliler, 'post', self::get_token());
        return View('acr_mobsis::ogretmen.ogrenciler', compact('ders_list', 'ders_id', 'ogrenciler', 'bekleyen'));
    }

    //veliler
    function ogretmen_veli_islem(Request $request)
    {
        $data  = ['veli_id' => $request->veli_id, 'status' => $request->status];
        $veri  = self::curl('http://api.mobilogrencitakip.com/api/v1/ogretmen-veli-islem', $data, 'post', self::get_token());
        $style = 'style="width: 300px; margin-left: auto; margin-right: auto; text-aling:center;"';
        $msg   = $veri->status == 1 ? '<div class="alert alert-success" ' . $style . '>' . $veri->msg . '</div>' : '<div  class="alert alert-danger" ' . $style . ' >' . $veri->msg . '</div>';
        return [$veri->status, $msg];
    }

    function ogretmen_veli_list(Request $request)
    {
        $ders_id       = $request->ders_id;
        $ders_list     = self::ders_list($ders_id);
        $data_bekleyen = ['status' => 0, 'start' => 0, 'record' => 50];
        $data_veliler  = ['sinif_id' => $ders_id, 'start' => 0, 'record' => 50];
        $bekleyen      = self::curl('http://api.mobilogrencitakip.com/api/v1/ogretmen-veli-bekleyen-list', $data_bekleyen, 'post', self::get_token());
        $veliler       = self::curl('http://api.mobilogrencitakip.com/api/v1/ogretmen-sinif-veli-list', $data_veliler, 'post', self::get_token());
        return View('acr_mobsis::ogretmen.veliler', compact('ders_list', 'ders_id', 'veliler', 'bekleyen'));
    }

//çocuk verme
    function ogretmen_cocuk_verme_islem(Request $request)
    {
        $data = ['status' => $request->status, 'id' => $request->id];
        $veri = self::curl('http://api.mobilogrencitakip.com/api/v1/ogretmen-cocuk-verme-islem', $data, 'post', self::get_token());
        return [$veri->status, $veri->msg];
    }

    function ogretmen_cocuk_verme_liste(Request $request)
    {
        $status     = empty($request->status) ? 0 : $request->status;
        $data       = ['status' => $status, 'start' => 0, 'record' => 120];
        $veri       = self::curl('http://api.mobilogrencitakip.com/api/v1/ogretmen-cocuk-verme-liste', $data, 'post', self::get_token());
        $islem_list = [
            2  => ['TESLİM ET', 'primary'],
            1  => ['UYGUN', 'success'],
            0  => ['UYGUN DEĞİL', 'warning'],
            -1 => ['SİL', 'danger']
        ];
        return View('acr_mobsis::ogretmen.cocuk_verme', compact('ders_id', 'veri', 'status', 'islem_list'));
    }
    //Çocuk verme
    // Bildirimler
    function bildirim_form(Request $request)
    {
        $ders_id   = $request->ders_id;
        $ders_list = self::ders_list($ders_id);
        $data      = ['sinif_id' => $ders_id, 'start' => 0, 'record' => 30];
        $veri      = self::curl('http://api.mobilogrencitakip.com/api/v1/ogretmen-sinif-bildirim-list', $data, 'post', self::get_token());
        return View('acr_mobsis::bildirimler.bildirim_form', compact('ders_list', 'ders_id', 'veri'));
    }

    function ders_list($ders_id)
    {
        $data = ['status' => 1];
        $veri = self::curl('http://api.mobilogrencitakip.com/api/v1/ogretmen-ders-list', $data, 'post', self::get_token());
        return View('acr_mobsis::ogretmen.ders_list', compact('veri', 'ders_id'))->render();
    }

    function bildirim_gonder(Request $request)
    {
        $ders_id       = $request->ders_id;
        $data_bildirim = [
            'header'         => $request->baslik,
            'content'        => $request->icerik,
            'sinif_id'       => $ders_id,
            'ogretmen_durum' => $request->ogretmen_durum,
            'veli_durum'     => $request->veli_durum,
            'ogrenci_durum'  => $request->ogrenci_durum,
            'servis_durum'   => $request->servis_durum
        ];
        $data          = ['sinif_id' => $ders_id, 'start' => 0, 'record' => 30];
        $veri          = self::curl('http://api.mobilogrencitakip.com/api/v1/ogretmen-sinif-bildirim-list', $data, 'post', self::get_token());
        self::curl('http://api.mobilogrencitakip.com/api/v1/ogretmen-sinif-bildirim-ekle', $data_bildirim, 'post', self::get_token());
        $ders_list = self::ders_list($ders_id);
        $msg       = '<div class="alert alert-success" style="width: 300px; text-align: center; margin-left: auto; margin-right: auto;">Bildiriminiz başarıyla gönderildi.</div>';
        return View('acr_mobsis::bildirimler.bildirim_form', compact('ders_list', 'ders_id', 'msg', 'veri'));
    }

    //Bildirimler
    function ogretmen_ders_islem(Request $request)
    {
        $mobsis_token = self::get_token($request);
        $data         = ['status' => $request->status, 'id' => $request->sinif_id];
        self::curl('http://api.mobilogrencitakip.com/api/v1/ogretmen-ders-islem', $data, 'post', $mobsis_token);
        return redirect()->back()->with('msg', $this->basarili());
    }

    function ogretmen_ders_list(Request $request)
    {
        self::user_control($request);
        $status = $request->status;
        $status = empty($status) ? -1 : $status;
        $data   = ['status' => $status];
        $veri   = self::curl('http://api.mobilogrencitakip.com/api/v1/ogretmen-ders-list', $data, 'post', self::get_token());
        return View('acr_mobsis::ogretmen.sinif_list', compact('veri'));
    }

    function ogretmen_ders_form(Request $request)
    {
        $ders_id = $request->ders_id;
        $data    = ['ders_id' => $ders_id];
        $veri    = self::curl('http://api.mobilogrencitakip.com/api/v1/ogretmen-ders-data', $data, 'post', self::get_token());
        return View('acr_mobsis::ogretmen.ders_form', compact('veri', 'ders_id'));
    }

    function ogretmen_ders_ekle(Request $request)
    {
        $data    = ['ad' => $request->ad, 'status' => $request->status, 'ders_id' => $request->ders_id];
        $veri    = self::curl('http://api.mobilogrencitakip.com/api/v1/ogretmen-ders-ekle', $data, 'post', self::get_token());
        $ders_id = $veri->data->id;
        return View('acr_mobsis::ogretmen.ders_form', compact('veri', 'ders_id'));
    }

    function ogretmen_sinif_list(Request $request)
    {
        self::user_control($request);
        $mobsis_token = self::get_token($request);
        $veri         = self::curl('http://api.mobilogrencitakip.com/api/v1/ogretmen-sinif-list', null, 'post', $mobsis_token);
        return View('acr_mobsis::ogretmen.sinif_list', compact('veri'));
    }

    function index(Request $request)
    {
        self::user_control($request);
        return View('acr_mobsis::anasayfa');
    }

    function curl($url, $data = null, $method, $mobsis_token = null)
    {
        $curl = new CurlService();
        if (empty($mobsis_token)) {
            $url = $url;
        } else {
            $url = "$url?token=$mobsis_token";
        }
        if (!empty($data)) {
            $response = $curl->to($url)
                ->withData($data)
                ->$method();
        } else {
            $response = $curl->to($url)->$method();
        }

        $response = json_decode($response);
        if (!empty($response->error)) {
            session()->forget('mobsis_token');
            $mobsis_token = self::get_token();
            self::curl($url, $data = null, $method, $mobsis_token);
        }
        // dd(session('mobsis_token'));
        return $response;

    }

    function get_token(Request $request = null)
    {
        $mobsis_token = session('mobsis_token');
        if ($mobsis_token) {
            return $mobsis_token;
        }
        $config_model = new Config();
        $config       = $config_model->first();
        $username     = $config->username;
        $pass         = $config->pass;
        $data         = ['username' => Auth::user()->$username, 'password' => Auth::user()->$pass];
        $url          = 'http://api.mobilogrencitakip.com/api/v1/login';
        $get_token    = self::curl($url, $data, 'post', $mobsis_token);
        if (empty($get_token->data->token)) {
            session()->forget('mobsis_token');
        }
        $mobsis_token = $get_token->data->token;
        session('mobsis_token', $mobsis_token);
        return $mobsis_token;

    }

    function user_detail(Request $request)
    {
        $data        = ['username' => Auth::user()->email, 'password' => Auth::user()->pass];
        $url         = 'http://api.mobilogrencitakip.com/api/v1/login';
        $user_detail = self::curl($url, $data, 'post', null);
        dd($user_detail);
    }

    function get_token_admin()
    {
        if (empty($this->admin_token)) {
            $data      = ['username' => 'info@okuloncesievrak.com', 'password' => 'acar5210_15'];
            $url       = 'http://api.mobilogrencitakip.com/api/v1/login';
            $get_token = self::curl($url, $data, 'post', $this->admin_token);
            if (empty($get_token->data->token)) {
                return 0;
            }
            $admin_token = $get_token->data->token;
            session('admin_token', $this->admin_token);
        }
        return $admin_token;

    }

    function user_control()
    {
        $data       = ['email' => Auth::user()->email];
        $user_count = self::curl('http://api.mobilogrencitakip.com/api/v1/register_control', $data, 'post', self::get_token());
        if ($user_count->data == 0) {
            $data_user = [
                'username'     => Auth::user()->email,
                'name'         => Auth::user()->name,
                'password'     => Auth::user()->password,
                'TC'           => Auth::user()->tc,
                'tel'          => Auth::user()->tel,
                'user_type_id' => 2
            ];
            $response  = self::curl('http://api.mobilogrencitakip.com/api/v1/register_api', $data_user, 'post', $this->get_token_admin());
            return response()->json(['status' => 0, 'title' => 'Bilgi', 'msg' => $response]);
        } else {
            return response()->json(['status' => 1, 'title' => 'Bilgi', 'msg' => 'Kullanıcı var']);
        }
    }

    function siniflar(Request $request)
    {
        // $request->session()->forget('mobsis_token');
        $mobsis_token = self::get_token($request);
        $siniflar     = self::curl('http://api.mobilogrencitakip.com/api/v1/ogretmen-sinif-list', null, 'post', $mobsis_token);
        dd($siniflar);
    }

    function ogretmen_sinif_galeri_list(Request $request)
    {
        $mobsis_token = self::get_token($request);
        $siniflar     = self::curl('http://api.mobilogrencitakip.com/api/v1/ogretmen-sinif-list', null, 'post', $mobsis_token);
        dd($siniflar);
    }
}