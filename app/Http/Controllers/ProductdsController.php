<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Validator;

class ProductdsController extends Controller
{
    public function index()
    {
        $dashboard = Product::latest()->get();
        return view('productds.index', [
            'title' => 'Product Management',
            'data' => $dashboard
        ]);
    }

    public function create()
    {
        return view('productds.create', [
            'title' => 'Product Management'
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'portfolio' => 'required',
        ], [
            'portfolio.required' => 'Nama tidak boleh kosong.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            try {
                $data = [
                    'productsname' => $request->productsname,
                    'portfolio' => $request->portfolio,
                    'ismaintenance' => 0,
                    'pesan_referral' => 0,
                    'jenis_bonus' => 'cashback',
                    'min_lose_bet' => 0,
                    'pesan_bonus' => 0,
                ];
                Product::create($data);
                return redirect('/productds')->with('success', 'Data berhasil disimpan.');
            } catch (\Exception $e) {
                dd($e->getMessage());
                return redirect('/productds')->with('error', 'Terjadi kesalahan saat menyimpan data.');
            }
        }
    }


    public function edit($id)
    {
        $var1 = str_replace("&", " ", $id);
        $var2 = explode("values[]=", $var1);
        $var3 = array_slice($var2, 1);
        $var4 = str_replace(" ", "", $var3);

        if (!empty($var4)) {
            $id = $var4;
            foreach ($id as $index => $ids) {
                $dashboard[$index] = Product::where('id', $ids)->first();
            }
        } else {
            $dashboard = [Product::where('id', $id)->first()];
        }

        return view('productds.update', [
            'title' => 'Product Management',
            'data' => $dashboard,
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
                $dashboard[$index] = Product::where('id', $ids)->first();
            }
        } else {
            $dashboard = [Product::where('id', $id)->first()];
        }
        return view('productds.update', [
            'title' => 'Product Management',
            'data' => $dashboard,
            'disabled' => 'disabled'
        ]);
    }


    public function data($id)
    {
        $data = Product::find($id);
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $ids = $request->id;
        $data = $request->all();
        $errors = [];
        foreach ($ids as $index => $id) {
            $alldata = [
                'id' => $data["id"][$index],
                'portfolio' => $data["portfolio"][$index],
                'productsname' => $data["productsname"][$index]
            ];

            $validator = Validator::make($alldata, [
                'portfolio' => 'required',
                'productsname' => 'required',
            ]);

            if ($validator->fails()) {
                $errors[] = $validator->errors()->all();
            } else {
                try {

                    $dashboard = Product::find($id);
                    $dashboard->portfolio = $alldata['portfolio'];
                    $dashboard->productsname = $alldata['productsname'];

                    $dashboard->save();
                } catch (\Exception $e) {
                    $errors[] = ['Terjadi kesalahan saat menyimpan data.'];
                }
            }
        }

        if (!empty($errors)) {
            return redirect()->back()
                ->withErrors($errors)
                ->withInput()
                ->with('error', 'Terdapat kesalahan dalam pembaruan data.');
        }

        return redirect('/productds')->with('success', 'Product berhasil diupdate!');
    }


    public function destroy(Request $request)
    {
        $ids = $request->input('values');

        if (!is_array($ids)) {
            $ids = [$ids];
        }

        foreach ($ids as $id) {
            $dashboard = Product::findOrFail($id);

            // Menghapus gambar terkait jika ada
            if ($dashboard->image) {
                Storage::delete('public/profileImg/' . $dashboard->image);
            }

            // Menghapus data pengguna
            $dashboard->delete();
        }

        return response()->json(['success' => 'Data berhasil dihapus!']);
    }


    public function updateProfile(Request $request)
    {
        $id = $request->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:500',
        ], [
            'name.required' => 'Nama tidak boleh kosong.',
            'image.required' => 'Pilih gambar yang ingin diunggah.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar yang diterima: JPEG, PNG, JPG, GIF.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 500KB.',
        ]);

        if ($validator->fails()) {
            $errors[] = $validator->errors()->all();
        } else {
            try {
                $alldata = $request->all();
                $dashboard = Product::find($id);
                $dashboard->name = $alldata['name'];

                if ($alldata['password'] != '') {
                    $dashboard->password = bcrypt($alldata['password']);
                }

                if ($request->hasFile('image')) {
                    // Hapus gambar sebelumnya jika ada
                    if ($dashboard->image) {
                        Storage::delete('public/profileImg/' . $dashboard->image);
                    }

                    $image = $request->file('image');
                    $imageName = time() . '.' . $image->getClientOriginalExtension();
                    $image->storeAs('public/profileImg', $imageName);
                    $dashboard->image = $imageName;
                }

                $dashboard->save();
            } catch (\Exception $e) {
                $errors[] = ['Terjadi kesalahan saat menyimpan data.'];
            }
        }


        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }

        return response()->json(['success' => 'Item berhasil diupdate!']);
    }
}
