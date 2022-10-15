<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use DB;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('search'))
        {
            $data = Peminjaman::where('nama','LIKE','%' .$request->search.'%')->paginate(5);
        }
        else
        {
            $data = DB::table('alats')
            ->select('alats.id','alats.nama as nama','peminjaman.peminjam as peminjam','peminjaman.qty as qty','peminjaman.deskripsi as deskripsi','peminjaman.id as id',
            'peminjaman.notelepon as notelepon','peminjaman.status as status','peminjaman.tgl_dikembalikan as tgl_dikembalikan','peminjaman.created_at as created_at','peminjaman.updated_at as updated_at')
            ->join('peminjaman','peminjaman.nama','=','alats.id')
            ->orderBy('peminjaman.id', "DESC")
            ->paginate(5);
        }
        // dd($data); 
        return view('peminjaman.index', compact('data'));
    }

    public function add()
    {
        $alat = Alat::all();

        $peminjaman = DB::table('peminjaman')
        ->select('id','nama','qty')
        ->get();


        return view('peminjaman.add', [
            'alat' => $alat,
            'peminjaman' => $peminjaman
        ]);
    }

    public function store(Request $request)
    {
        // $v = $this->validate($request, [
        //     'Alat' => 'required',
        // ]);  
        
        // if ($v)
        // {
        

        // dd($peminjaman);
        
        $jmlh = DB::table('alats')->where('id','=',$request['nama'])->select('qty')->get();
       
        if($request['qty'] > $jmlh[0]->qty) {
            return redirect()->route('peminjaman')->with('error', 'jumlah pinjaman melebihi stok');
    
        }
        else {
            
            $peminjaman = new Peminjaman();
            $peminjaman -> peminjam = $request['peminjam'];
            $peminjaman -> nama = $request['nama'];
            $peminjaman -> qty = $request['qty'];
            $peminjaman -> deskripsi = $request['deskripsi'];
            $peminjaman -> notelepon = $request['notelpon'];
            $peminjaman -> status = 'Belum Dikembalikan';
            $peminjaman -> save();
            $total = $jmlh[0]->qty - $request['qty'];
            // dd($total)
            $alat = Alat::where('id', $request['nama'])->update(['qty' => $total]);
            return redirect()->route('peminjaman')->with('success', 'data berhasil di tambahkan');
        }
        // }

        
    }

   public function status($id)
   {
    $current_date = date('Y-m-d H:i:s');
    $peminjaman = Peminjaman::where("id",$id)->update(['status' => "Sudah Dikembalikan","tgl_dikembalikan"=>$current_date]);
    $jmlh = DB::table('alats')
    ->where('peminjaman.id',$id)
    ->join('peminjaman', 'peminjaman.nama', '=','alats.id')
    ->select('alats.qty','alats.id as id_alat')->first();    
    $qtyPeminjaman = DB::table('peminjaman')
    ->where('peminjaman.id',$id)
    ->select('peminjaman.qty as qty_peminjaman')->first();
    
    
    $total = $jmlh->qty + $qtyPeminjaman->qty_peminjaman;
    
    $alat = DB::table('alats')->where("id", $jmlh->id_alat)->update(['qty' => $total]);
    

    return redirect()->route('peminjaman')->with('success', 'data berhasil di ubah');
   }
   
    public function destroy($id)
        {
            $data = Peminjaman::where("id",$id)->first();
           if( $data->status === "Sudah Dikembalikan" ){
               $data->delete();
           }else{
            $jmlh = DB::table('alats')
            ->where('peminjaman.id',$id)
            ->join('peminjaman', 'peminjaman.nama', '=','alats.id')
            ->select('alats.qty','alats.id as id_alat')->first(); 
            $total = $jmlh->qty + $data->qty;
            $alat = DB::table('alats')->where("id", $jmlh->id_alat)->update(['qty' => $total]);
            $data->delete();
           }
            return redirect()->route('peminjaman')->with('success', 'data berhasil di hapus');
        }

    public function edit($id)
    {   
        $alat = Alat::all();
        $data = Peminjaman::find($id);
        if($data->status == "Belum Dikembalikan"){
            return view('peminjaman.edit', compact('data', 'alat'));   
        }else{
            return redirect()->route('peminjaman')->with('error', 'Status Sudah Dikembalikan');
        }
    }
    public function update($id, Request $request)
    {
        $data = Peminjaman::find($id);
        $alat = DB::table('alats')
        ->where('peminjaman.id',$id)
        ->join('peminjaman', 'peminjaman.nama', '=','alats.id')
        ->select('alats.qty','alats.id as id_alat')->first(); 
        if($request->qty < $request->qty_awal){
            $totals = $request->qty_awal - $request->qty;
            $jumlah = $alat->qty + $totals;
            $alat = DB::table('alats')->where("id", $alat->id_alat)->update(['qty' => $jumlah]);
        }else{
            $totals = $request->qty - $request->qty_awal;
            $jumlah = $alat->qty - $totals;
            $alat = DB::table('alats')->where("id", $alat->id_alat)->update(['qty' => $jumlah]);
        }; 
        $data -> update($request->except(['_token','submit',"qty_awal"]));
        return redirect()->route('peminjaman')->with('success', 'data berhasil di update');      
    }
}

