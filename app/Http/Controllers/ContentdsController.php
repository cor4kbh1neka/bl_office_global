<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Companys;
use App\Models\Currencys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ContentdsController extends Controller
{
    public function index()
    {
        $url = env('DOMAIN') . '/content/ctgeneral';
        $response = Http::withTokenHeader()->get($url);
        $raw = json_decode($response);
        $data = $raw->data;
        return view('contentds.index', [
            'title' => 'Content',
            'data' => $data,
            'totalnote' => 0,
        ]);
    }
    public function generalUpdate(Request $request, $id)
    {
        $raw = $request->validate([
            'sitename' => 'required',
            'urllogo' => 'required',
            'urlicon' => 'required',
            'urlapk' => 'required',
            'runningtext' => 'required',
        ]);
        $validatedData = [
            'nmwebsite' => $raw['sitename'],
            'logrl' => $raw['urllogo'],
            'icrl' => $raw['urlicon'],
            'pkrl' => $raw['urlapk'],
            'rnntxt' => $raw['runningtext'],
        ];
        $url = env('DOMAIN') . '/content/ctgeneral/1';
        $response = Http::withTokenHeader()->put($url, $validatedData);
        if ($response->successful()) {
            return redirect('/contentds')->with('success', 'Data Berhasil di Edit!');
        } else {
            return redirect('/contentds')->with('error', 'Data Berhasil di Edit!');
        }
    }

    public function apiContentPromo()
    {
        $url = env('DOMAIN') . '/content/prm';
        $response = Http::withTokenHeader()->get($url);
        $raw = json_decode($response);
        $data = $raw->data;
        return $data;
    }
    public function promo()
    {
        $data = $this->apiContentPromo();
        usort($data, function ($a, $b) {
            return $a->pssprm <=> $b->pssprm;
        });
        return view('contentds.promo', [
            'title' => 'Content',
            'data' => $data,
            'totalnote' => 0,
        ]);
    }

    public function promoadd()
    {
        return view('contentds.promo_add', [
            'title' => 'Content',
            'totalnote' => 0,
        ]);
    }
    public function promostore(Request $request)
    {
        $data = $this->apiContentPromo();
        $pssprmValues = array_map(function ($item) {
            return $item->pssprm;
        }, $data);
        $lastPssprm = max($pssprmValues);
        $url = env('DOMAIN') . '/content/prm';
        $validatedData = $request->validate([
            'titlepromo' => 'required',
            'imgurl' => 'required',
            'description' => 'required',
            'targeturl' => 'required',
            'statuspromo' => 'required',
        ]);
        $validatedData = [
            'ctprmur' => $validatedData['imgurl'],
            'ttlectprm' => $validatedData['titlepromo'],
            'trgturctprm' => $validatedData['targeturl'],
            'statusctprm' => $validatedData['statuspromo'],
            'dskprm' => $validatedData['description'],
            'pssprm' => (string)($lastPssprm + 1),
        ];
        $response = Http::withTokenHeader()->post($url, $validatedData);
        if ($response->successful()) {
            return redirect('/contentds/promo')->with('success', 'Berhasil Menambah Data');
        } else {
            return redirect('/contentds/promo')->with('error', 'Gagal Menambah Data');
        }
    }
    public function promoedit($id)
    {
        $raw = $this->apiContentPromo();
        $data = null;
        foreach ($raw as $item) {
            if ($item->idctprm == $id) {
                $data = $item;
                break;
            }
        }
        if ($data === null) {
            abort(404);
        }
        return view('contentds.promo_edit', [
            'title' => 'Content',
            'data' => $data,
            'totalnote' => 0,
        ]);
    }
    public function promoupdate(Request $request, $id)
    {
        if (request('urutan') && request('urutanlain')) {
            $raw = $this->apiContentPromo();
            $data1 = null;
            foreach ($raw as $item) {
                if ($item->pssprm == request('urutan')) {
                    $data1 = $item;
                    break;
                }
            }

            if ($data1) {
                $url1 = env('DOMAIN') . '/content/prm/' . $data1->idctprm;
                $ctprmur = $data1->ctprmur;
                $ttlectprm = $data1->ttlectprm;
                $trgturctprm = $data1->trgturctprm;
                $statusctprm = $data1->statusctprm;
                $dskprm = $data1->dskprm;

                $validatedData1 = [
                    'ctprmur' => $ctprmur,
                    'ttlectprm' => $ttlectprm,
                    'trgturctprm' => $trgturctprm,
                    'statusctprm' => $statusctprm,
                    'dskprm' => $dskprm,
                    'pssprm' => request('urutanlain'),
                ];
            }

            $data2 = null;
            foreach ($raw as $item) {
                if ($item->pssprm == request('urutanlain')) {
                    $data2 = $item;
                    break;
                }
            }

            if ($data2) {
                $url2 = env('DOMAIN') . '/content/prm/' . $data2->idctprm;
                $ctprmur = $data2->ctprmur;
                $ttlectprm = $data2->ttlectprm;
                $trgturctprm = $data2->trgturctprm;
                $statusctprm = $data2->statusctprm;
                $dskprm = $data2->dskprm;

                $validatedData2 = [
                    'ctprmur' => $ctprmur,
                    'ttlectprm' => $ttlectprm,
                    'trgturctprm' => $trgturctprm,
                    'statusctprm' => $statusctprm,
                    'dskprm' => $dskprm,
                    'pssprm' => request('urutan'),
                ];
            }
            $response1 = Http::withTokenHeader()->put($url1, $validatedData1);
            $response2 = Http::withTokenHeader()->put($url2, $validatedData2);
            if ($response1 && $response2->successful()) {
                return redirect('/contentds/promo')->with('success', 'Data Berhasil di Edit!');
            } else {
                return redirect('/contentds/promo')->with('error', 'Data Gagal di Edit!');
            }
        }
        $urutanpromo = null;
        if (request('urutanpromo') === null) {
            $raw = $this->apiContentPromo();
            foreach ($raw as $item) {
                if ($item->idctprm == $id) {
                    $urutanpromo = $item->pssprm;
                    break;
                }
            }
        } else {
            $urutanpromo = request('urutanpromo');
        }

        $url = env('DOMAIN') . '/content/prm/' . $id;
        $validatedData = $request->validate([
            'titlepromo' => 'required',
            'imgurl' => 'required',
            'description' => 'required',
            'targeturl' => 'required',
            'statuspromo' => 'required',
        ]);
        $validatedData['urutanpromo'] = $urutanpromo;
        $validatedData = [
            'ctprmur' => $validatedData['imgurl'],
            'ttlectprm' => $validatedData['titlepromo'],
            'trgturctprm' => $validatedData['targeturl'],
            'statusctprm' => $validatedData['statuspromo'],
            'dskprm' => $validatedData['description'],
            'pssprm' => $validatedData['urutanpromo'],
        ];
        $response = Http::withTokenHeader()->put($url, $validatedData);

        if ($response->successful()) {
            return redirect('/contentds/promo')->with('success', 'Data Berhasil di Edit!');
        } else {
            return redirect('/contentds/promo')->with('error', 'Data Gagal di Edit!');
        }
    }
    public function promodelete($id)
    {
        $url = env('DOMAIN') . '/content/prm/' . $id;
        $raw = $this->apiContentPromo();
        $data = null;
        foreach ($raw as $item) {
            if ($item->idctprm === $id) {
                $data = $item;
                break;
            }
        }
        $response = Http::withTokenHeader()->delete($url, $data);
        if ($response->successful()) {
            return redirect('/contentds/promo')->with('success', 'Berhasil Hapus Data ' . $id);
        } else {
            return redirect('/contentds/promo')->with('error', 'Gagal Hapus Data ' . $id);
        }
    }
    public function apiSlider()
    {
        $url = env('DOMAIN') . '/content/ctslider';
        $response = Http::withTokenHeader()->get($url);
        $raw = json_decode($response);
        $data = $raw->data;
        return $data;
    }

    public function slider()
    {
        $data = $this->apiSlider();
        usort($data, function ($a, $b) {
            return $a->idctsldr <=> $b->idctsldr;
        });
        return view('contentds.slider', [
            'title' => 'Content',
            'data' => $data,
            'totalnote' => 0,
        ]);
    }

    public function slideradd()
    {
        return view('contentds.slider_add', [
            'title' => 'Content',
            'totalnote' => 0,
        ]);
    }

    public function sliderEdit($id)
    {
        $raw = $this->apiSlider();
        $data = null;
        foreach ($raw as $item) {
            if ($item->idctsldr == $id) {
                $data = $item;
                break;
            }
        }
        if ($data === null) {
            abort(404);
        }
        return view('contentds.slider_edit', [
            'title' => 'Content',
            'data' => $data,
            'totalnote' => 0,
        ]);
    }
    public function sliderUpdate(Request $request, $id)
    {
        $url = env('DOMAIN') . '/content/ctslider/' . $id;
        $raw = $request->validate([
            'titleslider' => 'required',
            'imgurl' => 'required',
            'targeturl' => 'required',
            'statuspromo' => 'required',
        ]);
        $validatedData = [
            'ctsldrur' => $raw['imgurl'],
            'ttlectsldr' => $raw['titleslider'],
            'trgturctsldr' => $raw['targeturl'],
            'statusctsldr' => $raw['statuspromo'],
        ];

        $response = Http::withTokenHeader()->put($url, $validatedData);
        if ($response->successful()) {
            return redirect('contentds/slider')->with('success', 'Berhasil Edit Data');
        } else {
            return redirect('contentds/slider')->with('error', 'Berhasil Edit Data');
        }
    }

    public function apiLinkContent()
    {
        $url = env('DOMAIN') . "/content/ctlink";
        $response = Http::withTokenHeader()->get($url);
        $raw = json_decode($response);
        $data = $raw->data;
        return $data;
    }

    public function link()
    {
        $data = $this->apiLinkContent();
        usort($data, function ($a, $b) {
            return $a->idctlnk <=> $b->idctlnk;
        });
        return view('contentds.link', [
            'title' => 'Content',
            'data' => $data,
            'totalnote' => 0,
        ]);
    }

    public function linkEdit($id)
    {
        $raw = $this->apiLinkContent();
        $data = null;
        foreach ($raw as $item) {
            if ($item->idctlnk == $id) {
                $data = $item;
                break;
            }
        }
        if ($data === null) {
            abort(404);
        }
        return view('contentds.link_edit', [
            'title' => 'Content',
            'data' => $data,
            'totalnote' => 0,
        ]);
    }
    public function linkUpdate(Request $request, $id)
    {
        $url = env('DOMAIN') . '/content/ctlink/' . $id;
        $validatedData = $request->validate([
            'name' => 'required',
            'urldomain' => 'required',
            'statuspromo' => 'required',
        ]);
        $validatedData = [
            'ctlnkname' => $validatedData['name'],
            'ctlnkdmn' => $validatedData['urldomain'],
            'statusctlnk' => $validatedData['statuspromo'],
        ];
        $response = Http::withTokenHeader()->put($url, $validatedData);
        if ($response->successful()) {
            return redirect('contentds/link')->with('success', 'Berhasil Edit Data');
        } else {
            return redirect('contentds/link')->with('error', 'Gagal Edit Data');
        }
    }

    public function apiSocialmedia()
    {
        $url = env('DOMAIN') . '/content/socmed';
        $response = Http::withTokenHeader()->get($url);
        $raw = json_decode($response);
        $data = $raw->data;
        return $data;
    }
    public function socialmedia()
    {
        $data = $this->apiSocialmedia();
        usort($data, function ($a, $b) {
            return $a->idctscmed <=> $b->idctscmed;
        });
        return view('contentds.socialmedia', [
            'title' => 'Content',
            'data' => $data,
            'totalnote' => 0,
        ]);
    }

    public function socialmediaedit($id)
    {
        $raw = $this->apiSocialmedia();
        $data = null;
        foreach ($raw as $item) {
            if ($item->idctscmed == $id) {
                $data = $item;
                break;
            }
        }
        if ($data === null) {
            abort(404);
        }
        return view('contentds.socialmedia_edit', [
            'title' => 'Content',
            'data' => $data,
            'totalnote' => 0,
        ]);
    }
    public function socialmediaupdate(Request $request, $id)
    {
        $url = env('DOMAIN') . '/content/socmed/' . $id;
        $validatedData = $request->validate([
            'name' => 'required',
            'urltarget' => 'required',
            'statuspromo' => 'required',
        ]);
        $validatedData = [
            'ctscmedur' => 'https://example.com/4',
            'lvchturctscmed' => 'https://examplelivechat.com/',
            'fdbckurctscmed' => 'https://examplefeedback.com/',
            'nmectscmed' => $validatedData['name'],
            'trgturctscmed' => $validatedData['urltarget'],
            'statusctscmed' => $validatedData['statuspromo'],
        ];
        $response = Http::withTokenHeader()->put($url, $validatedData);
        if ($response->successful()) {
            return redirect('/contentds/socialmedia')->with('success', 'Berhasil Edit Data');
        } else {
            return redirect('/contentds/socialmedia')->with('error', 'Gagal Edit Data');
        }
    }
    public function apiStatusMaintenance()
    {
        $url = env('DOMAIN') . '/content/sts';
        $response = Http::withTokenHeader()->get($url);
        $raw = json_decode($response);
        $data = $raw->data;
        return $data;
    }
    public function statusMaintenance()
    {
        $data = $this->apiStatusMaintenance();
        return view('contentds.maintenance', [
            'title' => 'Content',
            'data' => $data,
            'totalnote' => 0
        ]);
    }
    public function statusMaintenanceEdit()
    {
        $data = $this->apiStatusMaintenance();
        return view('contentds.maintenance_edit', [
            'title' => 'Content',
            'data' => $data,
            'totalnote' => 0,
        ]);
    }
    public function statusMaintenanceUpdate(Request $request, $status)
    {
        $url = env('DOMAIN') . '/content/sts/1';
        $validatedData = $request->validate([
            'status' => 'required'
        ]);
        $validatedData = [
            'stsmtncnc' => $validatedData['status']
        ];
        $response = Http::withTokenHeader()->put($url, $validatedData);
        if ($response->successful()) {
            return redirect('contentds/maintenance')->with('success', 'Berhasil Edit Data');
        } else {
            return redirect('contentds/maintenance')->with('error', 'Gagal Edit Data');
        }
    }
}
