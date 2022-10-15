<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alat;

class AlatController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('search'))
        {
            $data = Alat::where('nama','LIKE','%' .$request->search.'%')->paginate(5);
        }
        else
        {
            $data = Alat::paginate(5);
        }
        return view('alat.index', compact('data'));
    }

    public function add()
    {
        return view('alat.add');
    }

    public function store(Request $request)
    {
        Alat::create($request->all());
        return redirect()->route('alat')->with('success', 'data berhasil di tambahkan');
    }

    public function edit($id)
    {   
        $data = Alat::find($id);
        return view('alat.edit', compact('data'));
    }

    public function update($id, Request $request)
    {
        $data = Alat::find($id);
        $data -> update($request->except(['_token','submit']));
        return redirect()->route('alat')->with('success', 'data berhasil di update');      
    }

    public function destroy($id)
    {
        $data = Alat::where("id",$id);
        $data->delete();
        return redirect()->route('alat')->with('success', 'data berhasil di hapus');
    }
}

