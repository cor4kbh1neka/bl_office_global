<?php

namespace App\Http\Controllers;

use App\Models\ConfigIp;
use App\Models\Listdomain;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LinkalternatifdsController extends Controller
{
    // Memperbaiki metode index dengan caching untuk mengurangi request API yang tidak perlu
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $url = 'https://api.cloudflare.com/client/v4/zones';

        $response = Http::withHeaders($this->getCloudflareHeaders())->get($url);

        $responseData = $response->successful() ? $response->json()["result"] : [];

        if (!empty($responseData)) {
            $links = Listdomain::pluck('link')->toArray();
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
        return view('linkalternatifds.index', [
            'title' => 'Link Alternatif',
            'data' => $responseData,
            'totalnote' => 0,
            'search' => $search,
            'pin' => '464646',
            'dataIP' => $dataIP
        ]);
    }

    public function create()
    {
        return view('linkalternatifds.create', [
            'title' => 'Add New Link Alternatif',
            'totalnote' => 0,
            'step' => 'create',
            'datans' => '',
            'datadns' => '',
            'zoneid' => '',
            'link' => ''
        ]);
    }

    // Menambahkan validasi kustom untuk input link
    public function store(Request $request)
    {
        $request->validate([
            'link' => ['required', 'string', 'regex:/^[a-zA-Z0-9-]+\.[a-zA-Z]{2,}(\.[a-zA-Z]{2,})?$/'],
        ], [
            'link.regex' => 'Link harus memiliki format yang valid dan tanpa http:// atau https://.',
        ]);

        $link = $request->input('link');
        $url = 'https://api.cloudflare.com/client/v4/zones';

        $response = Http::withHeaders($this->getCloudflareHeaders())->post($url, ['name' => $link, 'jump_start' => false]);

        if ($response->successful()) {
            $responseData = $response->json()["result"];

            $getip = ConfigIp::first();
            $ip = $getip ? $getip->ip : '47.128.186.125';

            $this->dnsRecord($responseData['id'], 'A', $link, $ip);
            $this->dnsRecord($responseData['id'], 'CNAME', 'www', $link);

            Listdomain::create([
                'link' => $link
            ]);

            return redirect('/linkalternatifds/edit/' . $responseData['id'])->with('success', 'Link alternatif berhasil disimpan.');
        }

        return redirect()->back()->with('error', 'Gagal mendaftarkan link.');
    }

    public function storedns(Request $request)
    {
        // Validasi input
        $request->validate([
            'link' => ['required', 'string', 'regex:/^[a-zA-Z0-9-]+\.[a-zA-Z]{2,}(\.[a-zA-Z]{2,})?$/'],
            'zoneid' => ['required', 'string'],
            'type' => ['required', 'string'],
            'content' => ['required', 'string'],
        ], [
            'link.regex' => 'Link harus memiliki format yang valid dan tanpa http:// atau https://.',
            'zoneid.required' => 'Zone ID harus disediakan.',
            'type.required' => 'Tipe harus disediakan.',
            'content.required' => 'Konten harus disediakan.',
        ]);

        $link = $request->input('link');
        $zoneid = $request->input('zoneid');
        $type = $request->input('type');
        $content = $request->input('content');

        try {
            // Mengirim permintaan ke API Cloudflare
            $response = $this->dnsRecord($zoneid, $type, $link, $content);

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
            'link' => $getDataNs['name']
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
            'name' => 'required|string',
            'id' => 'required|string',
        ]);

        $url = "https://api.cloudflare.com/client/v4/zones/{$request->zoneid}/dns_records/{$request->id}";
        $data = [
            'type' => 'TXT',
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
            return array_filter($response->json()["result"], function ($item) use ($name) {
                return $item['name'] === $name && $item['type'] === 'TXT';
            });
        }

        return [];
    }

    private function getCloudflareHeaders()
    {
        return [
            'X-Auth-Email' => env('EMAILCF'),
            'X-Auth-Key' => env('TOKENCF'),
            'Content-Type' => 'application/json',
        ];
    }

    private function dnsRecord($zoneid, $type, $link, $content)
    {
        $url = 'https://api.cloudflare.com/client/v4/zones/' . $zoneid . '/dns_records';

        $data = [
            'type' => $type,
            'name' => $link,
            'content' => $content,
            'ttl' => 3600
        ];

        return Http::withHeaders($this->getCloudflareHeaders())->post($url, $data);
    }
}
