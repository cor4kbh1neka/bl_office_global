<?php

namespace App\Http\Controllers;

use App\Models\Allowedip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AllowedipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allowedip = Allowedip::latest() // Menambahkan batasan limit 10
            ->get();
        // $results = Allowedip::orderBy('created_at', 'desc')->paginate(8);
        return view('allowedip.index', [
            'title' => 'Allowed IP',
            'data' => $allowedip,
            'totalnote' => 0
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('allowedip.create', [
            'title' => 'Allowed IP',
            'totalnote' => 0
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ip_address' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            Allowedip::create($request->all());
            return redirect()->route('allowedip')->with('success', 'Data berhasil disimpan.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Allowedip $Allowedip)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $var1 = str_replace("&", " ", $id);
        $var2 = explode("values[]=", $var1);
        $var3 = array_slice($var2, 1);
        $var4 = str_replace(" ", "", $var3);

        if (!empty($var4)) {
            $id = $var4;
            foreach ($id as $index => $ids) {
                $allowedip[$index] = Allowedip::where('id', $ids)->first();
            }
        } else {
            $allowedip = [Allowedip::where('id', $id)->first()];
        }

        return view('allowedip.update', [
            'title' => 'Allowed IP',
            'data' => $allowedip,
            'disabled' => ''
        ]);
    }

    public function views($id)
    {
        $var1 = str_replace("&", " ", $id);
        $var2 = explode("values[]=", $var1);
        $var3 = array_slice($var2, 1);
        $var4 = str_replace(" ", "", $var3);

        if (!empty($var4)) {
            $id = $var4;
            foreach ($id as $index => $ids) {
                $allowedip[$index] = Allowedip::where('id', $ids)->first();
            }
        } else {
            $allowedip = [Allowedip::where('id', $id)->first()];
        }

        return view('allowedip.update', [
            'title' => 'Allowed IP',
            'data' => $allowedip,
            'disabled' => 'disabled'
        ]);
    }


    public function data($id)
    {
        $data = Allowedip::find($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->id;
        foreach ($id as $index => $idx) {
            $validator = Validator::make($request->all(), [
                'ip_address.*' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            } else {
                try {
                    $result = Allowedip::find($idx);
                    $result->ip_address = $request->ip_address[$index];
                    $result->save();
                } catch (\Exception $e) {
                    return response()->json(['errors' => ['Terjadi kesalahan saat menyimpan data.']]);
                }
            }
        }
        return response()->json(['success' => 'Item berhasil diupdate!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $ids = $request->input('values');

        if (!is_array($ids)) {
            $ids = [$ids];
        }

        foreach ($ids as $id) {
            $Allowedip = Allowedip::findOrFail($id);
            $Allowedip->delete();
        }

        return response()->json(['success' => 'Data berhasil dihapus!']);
    }
}
