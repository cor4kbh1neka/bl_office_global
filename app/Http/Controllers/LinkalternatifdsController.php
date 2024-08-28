<?php

namespace App\Http\Controllers;

use App\Models\ConfigIp;
use App\Models\Dashboard;
use App\Models\Listdomain;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LinkalternatifdsController extends Controller
{
    public function index(Request $request, $dashboard_id = "1")
    {
        $search = $request->input('search', '');
        $url = 'https://api.cloudflare.com/client/v4/zones?per_page=150';

        $response = Http::withHeaders($this->getCloudflareHeaders())->get($url);

        $responseData = $response->successful() ? $response->json()["result"] : [];

        if (!empty($responseData)) {
            $links = Listdomain::where('dashboard_id', $dashboard_id)->pluck('link')->toArray();
            $responseData = array_filter($responseData, function ($item) use ($links) {
                return in_array($item['name'], $links);
            });

            if ($search) {
                $responseData = array_filter($responseData, function ($item) use ($search) {
                    return stripos($item['name'], $search) !== false;
                });
            }

            $responseData = array_map(function ($item) {
                $item['created_on'] = Carbon::parse($item['created_on'])->format('Y-m-d');
                return $item;
            }, $responseData);
        }

        $dataIP = ConfigIp::get();
        $dataDashboard = Dashboard::get();
        $dashboard = Dashboard::where('id', $dashboard_id)->first();
        return view('linkalternatifds.index', [
            'title' => 'Link Alternatif',
            'data' => $responseData,
            'totalnote' => 0,
            'search' => $search,
            'pin' => '464646',
            'dataIP' => $dataIP,
            'data_dashboard' => $dataDashboard,
            'dashboard' =>  $dashboard ? $dashboard->nama : '',
            'dashboard_id' => $dashboard_id
        ]);
    }

    public function create($dashboard_id)
    {
        return view('linkalternatifds.create', [
            'title' => 'Add New Link Alternatif',
            'totalnote' => 0,
            'step' => 'create',
            'dashboard_id' => $dashboard_id,
            'datans' => '',
            'datadns' => '',
            'zoneid' => '',
            'link' => ''
        ]);
    }

    public function createdns($zoneid)
    {
        return view('linkalternatifds.createdns', [
            'title' => 'Add New Link Alternatif',
            'totalnote' => 0,
            'zoneid' => $zoneid
        ]);
    }

    // Menambahkan validasi kustom untuk input link
    public function store(Request $request)
    {
        $dashboard = Dashboard::where('id', $request->dashboard_id)->first();
        $request->validate([
            'dashboard_id' => ['required', 'integer'],
            'link' => ['required', 'string', 'regex:/^[a-zA-Z0-9-]+\.[a-zA-Z]{2,}(\.[a-zA-Z]{2,})?$/'],
        ], [
            'dashboard_id.required' => 'Dashboard ID harus diisi.',
            'dashboard_id.integer' => 'Dashboard ID harus berupa angka.',
            'link.regex' => 'Link harus memiliki format yang valid dan tanpa http:// atau https://.',
        ]);

        $link = $request->input('link');
        $url = 'https://api.cloudflare.com/client/v4/zones';

        $response = Http::withHeaders($this->getCloudflareHeaders())->post($url, ['name' => $link]);

        if ($response->successful()) {
            $responseData = $response->json()["result"];

            $dataip = ConfigIp::first();

            // Set Always Use HTTPS
            $this->enableAlwaysUseHttps($responseData['id']);

            // Add A AND CNAME
            $this->addDns($responseData['id'], 'A', $responseData['name'], $dataip->ip, true);
            $this->addDns($responseData['id'], 'CNAME', 'www', $responseData['name'], true);

            // SSL to flexible
            $this->changeSSL($responseData['id']);

            //create to Database
            Listdomain::create([
                'dashboard_id' => $request->dashboard_id,
                'link' => $link,
            ]);

            $dashboard = Dashboard::where('id', $request->dashboard_id)->first();
            $domain = $this->getDomainName($responseData['name']);
            $this->configureNginx($domain["domain"], $dataip->ip, $domain["ext"], $domain["domain"] . $domain["ext"], $dashboard->nama);

            return redirect('/linkalternatifds/edit/' . $responseData['id'])->with('success', 'Link alternatif berhasil disimpan.');
        }

        return redirect()->back()->with('error', 'Gagal mendaftarkan link.');
    }

    public function storedns(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => ['required', 'string'],
            'zoneid' => ['required', 'string'],
            'type' => ['required', 'string'],
            'content' => ['required', 'string'],
        ], [
            'name.regex' => 'Link harus disediakan',
            'zoneid.required' => 'Zone ID harus disediakan.',
            'type.required' => 'Tipe harus disediakan.',
            'content.required' => 'Konten harus disediakan.',
        ]);

        $name = $request->input('name');
        $zoneid = $request->input('zoneid');
        $type = $request->input('type');
        $content = $request->input('content');

        try {
            // Mengirim permintaan ke API Cloudflare
            $response = $this->addDns($zoneid, $type, $name, $content, true);

            if ($response->successful()) {
                // Jika sukses, kembalikan data hasil respons
                $responseData = $response->json()["result"];
                return response()->json([
                    'success' => true,
                    'message' => 'Link alternatif berhasil disimpan.',
                    'data' => $responseData
                ]);
            } else {
                // Jika gagal, kembalikan pesan kesalahan
                $errors = $response->json('errors', []);
                $errorMessage = !empty($errors) ? $errors[0]['message'] : 'Gagal mendaftarkan link.';
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], $response->status());
            }
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, kembalikan pesan kesalahan
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghubungi API Cloudflare: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $getDataNs = $this->getDataNs($id);
        $getDataDetailDNS = $this->getDataDetailDNS($id, $getDataNs["name"]);

        return view('linkalternatifds.create', [
            'title' => 'Link Alternatif',
            'datans' => $getDataNs,
            'datadns' => $getDataDetailDNS,
            'totalnote' => 0,
            'zoneid' => $id,
            'step' => 'edit',
            'link' => $getDataNs['name'],
            'dashboard_id' => "",
        ]);
    }

    public function delete($zoneid, $id)
    {
        try {
            $url = "https://api.cloudflare.com/client/v4/zones/{$zoneid}/dns_records/{$id}";

            $response = Http::withHeaders($this->getCloudflareHeaders())->delete($url);

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item berhasil dihapus.'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus item: ' . $response->json()['errors'][0]['message']
            ], $response->status());
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus item.'
            ], 500);
        }
    }

    public function updatedns(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'zoneid' => 'required|string',
            'type' => 'required|string',
            'name' => 'required|string',
            'id' => 'required|string',
        ]);

        $url = "https://api.cloudflare.com/client/v4/zones/{$request->zoneid}/dns_records/{$request->id}";

        $data = [
            'type' => $request->type,
            'name' => $request->name,
            'content' => $request->content,
            'ttl' => 120
        ];

        $response = Http::withHeaders($this->getCloudflareHeaders())->put($url, $data);

        return $response->successful()
            ? response()->json($response->json(), 200)
            : response()->json($response->json(), $response->status());
    }

    public function removeDomain($id, $link)
    {
        $url = "https://api.cloudflare.com/client/v4/zones/" . $id;
        try {
            $response = Http::withHeaders($this->getCloudflareHeaders())->delete($url);
            if ($response->successful()) {
                $listdomain = Listdomain::where('link', $link)->first();
                if ($listdomain) {
                    $listdomain->delete();
                }
                return response()->json(['message' => 'Link berhasil dihapus'], 200);
            } else {
                return response()->json(['error' => 'Gagal menghapus link'], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateIp(Request $request, $id)
    {
        $request->validate([
            'ip' => 'required|ip'
        ]);

        $configIp = ConfigIp::find($id);
        if (!$configIp) {
            return response()->json(['message' => 'IP tidak ditemukan.'], 404);
        }

        $configIp->ip = $request->input('ip');
        $configIp->save();

        return response()->json(['message' => 'IP berhasil diperbarui.']);
    }

    private function getDataNs($id)
    {
        $url = "https://api.cloudflare.com/client/v4/zones/{$id}";

        $response = Http::withHeaders($this->getCloudflareHeaders())->get($url);

        return $response->successful() ? $response->json()["result"] : [];
    }

    private function getDataDetailDNS($id, $name)
    {
        $url = "https://api.cloudflare.com/client/v4/zones/{$id}/dns_records";

        $response = Http::withHeaders($this->getCloudflareHeaders())->get($url);

        if ($response->successful()) {
            // return array_filter($response->json()["result"], function ($item) use ($name) {
            //     return $item['name'] === $name && $item['type'] === 'TXT';
            // });
            return $response->json()["result"];
        }

        return [];
    }

    // Membuat fungsi reusable untuk mendapatkan headers Cloudflare
    private function getCloudflareHeaders()
    {
        return [
            'X-Auth-Email' => env('EMAILCF'),
            'X-Auth-Key' => env('TOKENCF'),
            'Content-Type' => 'application/json',
        ];
    }

    private function addDns($zoneid, $type, $name, $content, $proxied)
    {
        $url = 'https://api.cloudflare.com/client/v4/zones/' . $zoneid . '/dns_records';

        $data = [
            'type' => $type,
            'name' => $name,
            'content' => $content,
            'proxied' => $proxied
        ];

        return Http::withHeaders($this->getCloudflareHeaders())->post($url, $data);
    }

    private function configureNginx($domain, $server_ip, $ext, $domext, $nama)
    {
        try {
            exec("sudo /bl_office_global/storage/app/public/script.sh $domain $server_ip $ext $domext $nama > /dev/null 2>&1 &");
        } catch (\Exception $e) {
        }
        return;
    }

    private function enableAlwaysUseHttps($zoneId)
    {
        $url = "https://api.cloudflare.com/client/v4/zones/{$zoneId}/settings/always_use_https";
        Http::withHeaders($this->getCloudflareHeaders())->patch($url, [
            'value' => 'on'
        ]);
    }

    function getDomainName($domain)
    {
        $domain = preg_replace('/^www\./', '', $domain);

        $parts = explode('.', $domain);
        $count = count($parts);

        $extension = end($parts);

        if ($count > 2) {
            $domainName = implode('.', array_slice($parts, 0, $count - 1));
        } else {
            $domainName = $parts[0];
        }

        return ["domain" => $domainName, "ext" => $extension];
    }

    private function changeSSL($zoneid)
    {
        // Mengatur SSL menjadi Flexible
        $sslUrl = "https://api.cloudflare.com/client/v4/zones/$zoneid/settings/ssl";
        $sslData = [
            'value' => 'flexible'
        ];

        return Http::withHeaders($this->getCloudflareHeaders())->patch($sslUrl, $sslData);
    }
}
