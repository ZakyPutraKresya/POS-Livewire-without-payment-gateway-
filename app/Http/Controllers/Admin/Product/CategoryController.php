<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Alert;
use Illuminate\Support\Facades\Crypt;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::all();

        return view('admin.product.category.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validasi = array(
            'kategori' => 'required|unique:categories'
        );

        $validator = Validator::make($request->all(), $validasi);
        if ($validator->fails()) {
            Alert::error('Gagal', 'Data Category Sudah Ada');
            return redirect()->route('category.index');

        } else {

            $tambahdata = Category::create(
                [
                    'kategori' => $request->kategori
                ]
            );
    
            if ($tambahdata){
                Alert::success('Berhasil', 'Data Category Berhasil Ditambahkan');
                return redirect()->route('category.index');
            } else {
                Alert::error('Gagal', 'Data Category Gagal Ditambahkan');
                return redirect()->route('category.index');
            }

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Mengdecrypt id yang dituju atau mendeksripsikan enskripsi yang dituju
        $id = Crypt::decrypt($id);

        $category = Category::where('id', $id)->first();
        return view('admin.product.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //get data Blog by ID
        $category = Category::findOrFail($id);

        $category->update([
            'kategori'     => $request->kategori
        ]);

        if ($category) {
            Alert::success('Berhasil', 'Data Kategori Berhasil Di Update');
            return redirect()->route('category.index');
        } else {
            Alert::error('Gagal', 'Data Kategori Gagal Di Update');
            return redirect()->route('category.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findorfail($id);
        $category->delete();
        Alert::success('Berhasil', 'Data Produk Berhasil Dihapus');
        return redirect()->route('category.index');
    }
}
