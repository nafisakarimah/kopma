<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AlamatPengiriman;
use App\Models\DetailTransaksi;
use App\Models\Keranjang;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\UkuranProduk;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function index()
    {
        $data = Keranjang::where(['user_id' => auth()->id()])->get();

        $total = 0;

        foreach($data as $item){
            $total += ($item->produk->harga * $item->jumlah);
        }

        $alamat = AlamatPengiriman::where(['user_id' => auth()->id(),'utama' => '1'])->get();

        return view('user.keranjang',[
            'keranjang' => $data,
            'total' => $total,
            'alamat' => $alamat
        ]);
    }


    public function save($id,Request $request)
    {

        $request->validate([
            'jumlah' => 'required',
            'ukuran' => 'nullable'
        ]);


        $cek = Produk::findOrFail($id);

        if($cek->kategori->ukuran == '1')
        {
            $request->validate([
                'jumlah' => 'required',
                'ukuran' => 'required'
            ]);

            $cekUkuran = UkuranProduk::find($request->ukuran);
            if($cekUkuran->stok == 0)
            {
                return redirect()->back()->withErrors(['error' => 'Stok produk tidak tersedia']);
            }
        }else{
            if($cek->stok == 0)
            {
                return redirect()->back()->withErrors(['error' => 'Stok produk tidak tersedia']);
            }
        }


        $cekKeranjang = Keranjang::where(['user_id' => auth()->id(),'produk_id' => $id])->first();
        if($cekKeranjang)
        {
            if($cekKeranjang->ukuran_produk_id == $request->ukuran)
            {
                if($cekKeranjang->produk->kategori->ukuran == '1')
                {
                    if($cekKeranjang->jumlah + $request->jumlah > $cekKeranjang->ukuran->stok)
                    {
                        return redirect()->back()->withErrors(['error' => 'Sisa stok produk '.$cekKeranjang->ukuran->stok]);
                    }
                }else{
                    if(($cekKeranjang->jumlah + $request->jumlah) > $cek->stok)
                    {
                        return redirect()->back()->withErrors(['error' => 'Sisa stok produk '.$cek->stok]);
                    }
                }
                $cekKeranjang->update([
                    'jumlah' => $cekKeranjang->jumlah + $request->jumlah,
                ]);
            }else{
                $ukuran = UkuranProduk::find($request->ukuran);
                if($cekKeranjang->jumlah + $request->jumlah > $ukuran->stok)
                {
                    return redirect()->back()->withErrors(['error' => 'Sisa stok produk '.$ukuran->stok]);
                }
                Keranjang::create([
                    'user_id' => auth()->id(),
                    'produk_id' => $id,
                    'jumlah' => $request->jumlah,
                    'ukuran_produk_id' => $request->ukuran,
                ]);
            }
        }else{
        
            if($cek->kategori->ukuran == '1')
            {
                $ukuran = UkuranProduk::find($request->ukuran);

                if($request->jumlah > $ukuran->stok)
                {
                    return redirect()->back()->withErrors(['error' => 'Sisa stok produk '.$ukuran->stok]);
                }
            }else{
                if($request->jumlah > $cek->stok)
                {
                    return redirect()->back()->withErrors(['error' => 'Sisa stok produk '.$cek->stok]);
                }
            }

            Keranjang::create([
                'user_id' => auth()->id(),
                'produk_id' => $id,
                'jumlah' => $request->jumlah,
                'ukuran_produk_id' => $request->ukuran,
            ]);
        }

        return redirect()->route('user.keranjang.index')->with('success','Berhasil menambahkan kekeranjang');

    }

    public function update($id,Request $request)
    {
        $request->validate([
            'jumlah' => 'required',
            'ukuran' => 'nullable'
        ]);

        $cek = Produk::findOrFail($id);

        if($cek->kategori->ukuran == '1')
        {
            $request->validate([
                'jumlah' => 'required',
                'ukuran' => 'required'
            ]);

            $cekKeranjang = Keranjang::where(['user_id' => auth()->id(),'produk_id' => $id])->first();
            // dd($cekKeranjang);
            if($cekKeranjang->ukuran->stok == 0)
            {
                return redirect()->back()->withErrors(['error' => 'Stok produk tidak tersedia']);
            }
        }else{
            if($cek->stok == 0)
            {
                return redirect()->back()->withErrors(['error' => 'Stok produk tidak tersedia']);
            }
        }

        $cekKeranjang = Keranjang::where(['user_id' => auth()->id(),'produk_id' => $id])->first();
        if($cekKeranjang)
        {
            if($cekKeranjang->produk->kategori->ukuran == '1')
            {
                $ukuran = UkuranProduk::find($request->ukuran);
                if($cekKeranjang->jumlah + $request->jumlah > $ukuran->stok)
                {
                    return redirect()->back()->withErrors(['error' => 'Sisa stok produk '.$ukuran->stok]);
                }
            }else{
                if(($cekKeranjang->jumlah + $request->jumlah) > $cek->stok)
                {
                    return redirect()->back()->withErrors(['error' => 'Sisa stok produk '.$cek->stok]);
                }
            }

        }

        $cekKeranjang->update([
            'jumlah' => $request->jumlah,
            'ukuran_produk_id' => $request->ukuran
        ]);

        return redirect()->route('user.keranjang.index')->with('success','Berhasil mengubah kekeranjang');

    }

    public function update_batch($request)
    {
        $request->validate([
            'keranjang' => 'required|array',
            'keranjang.*.jumlah' => 'required',
            'keranjang.*.ukuran' => 'nullable'
        ]);

        $total = 0;

        foreach($request->keranjang as $item){
            $keranjang = Keranjang::find($item['id']); 
            $total += ($keranjang->produk->harga * $item['jumlah']);
        }

        if($total < 50000)
        {
            return redirect()->route('user.keranjang.index')->withErrors(['error' => 'Minimal nominal pembelanjaan Rp 50.000 rupiah']);
        }

        $index = 0;
        foreach($request->keranjang as $item){
            $keranjang = Keranjang::find($item['id']); 
            if($keranjang->produk->kategori->ukuran == '1')
            {
                $request->validate([
                    'keranjang.'.$index.'.ukuran' => 'required'
                ]);

                $ukuran = $keranjang->produk->ukuran->find($item['ukuran']);
                if($ukuran->stok < $item['jumlah']){
                    return redirect()->route('user.keranjang.index')->withErrors(['error' => 'Sisa Stok produk <b>'.$keranjang->produk->nama.'('.$ukuran->ukuran.')'.'</b> adalah "'.$ukuran->stok.'"']);
                }

            }else{
                if($keranjang->produk->stok < $item['jumlah'])
                {
                    return redirect()->route('user.keranjang.index')->withErrors(['error' => 'Sisa Stok produk <b>'.$keranjang->produk->nama.'</b> adalah "'.$keranjang->produk->stok.'"']);
                }
            }
            $keranjang->update([
                'jumlah' => $item['jumlah'],
                'ukuran_produk_id' => $item['ukuran']?? null
            ]);
            $index++;
        }

        // return redirect()->route('user.checkout.index')->with('success','Berhasil mengubah keranjang');

    }

    public function checkout()
    {

        $data = Keranjang::where(['user_id' => auth()->id()])->get();

        $total = 0;

        foreach($data as $item){
            $total += ($item->produk->harga * $item->jumlah);
        }

        $alamat = AlamatPengiriman::where(['user_id' => auth()->id()])->get();
        return view('user.checkout',[
            'user' => auth()->user(),
            'keranjang' => $data,
            'total' => $total,
            'alamat' => $alamat
        ]);
    }

    public function checkout_submit(Request $request)
    {
        $this->update_batch($request);
        if(auth()->user()->status == '3')
        {
            return redirect()->route('user.keranjang.index')->withErrors(['error' => 'Gagal melakukan pemesanan, akun anda dibekukan']);
        }

        $request->validate([
            'alamat' => 'required',
        ]);

        $keranjang = Keranjang::where(['user_id' => auth()->id()]);

        if($keranjang->count() == 0)
        {
            return redirect()->route('user.keranjang.index')->withErrors(['error' => 'Keranjang kosong']);
        }

        // $total = 0;

        // foreach($keranjang->get() as $item){
        //     $total += ($item->produk->harga * $item->jumlah);
        // }

        // if($total < 50000)
        // {
        //     return redirect()->route('user.checkout.index')->withErrors(['error' => 'Minimal nominal pembelanjaan Rp 50.000 rupiah']);
        // }

        $trx_no = Transaksi::where(['user_id' => auth()->id()])->orderBy('id','desc')->first();

        $no_po = "TRX-".date('Ymd').'-'.auth()->id().'-0001';

        if($trx_no)
        {
            $trx = str_replace("TRX-".date('Ymd').'-'.auth()->id().'-','',$trx_no->no_po);
            $no_po = "TRX-".date('Ymd').'-'.auth()->id().'-'.str_pad($trx,4,'0',STR_PAD_LEFT);
        }

        $sv_transaksi = Transaksi::create([
            'user_id' => auth()->id(),
            'no_po' => $no_po,
            'alamat_pengiriman_id' => $request->alamat,
            'total' => 0,
            'status' => 0,
        ]);

        if($sv_transaksi)
        {
            $subTotal = 0;
            $detail = [];

            foreach($keranjang->get() as $item){
                $detail[] = [
                    'transaksi_id' => $sv_transaksi->id,
                    'produk_id' => $item->produk_id,
                    'ukuran_produk_id' => $item->ukuran_produk_id,
                    'harga' => $item->produk->harga,
                    'jumlah' => $item->jumlah,
                    'total' => ($item->produk->harga * $item->jumlah),
                ];
                $subTotal += ($item->produk->harga * $item->jumlah);

                if($item->ukuran_produk_id)
                {
                    $stokSebelumnya = UkuranProduk::find($item->ukuran_produk_id);
                    $stokSebelumnya->update([
                        'stok' => $stokSebelumnya->stok - $item->jumlah
                    ]);
                }else{
                    Produk::find($item->produk_id)->update([
                        'stok' => $item->produk->stok - $item->jumlah
                    ]);
                }
            }

            DetailTransaksi::insert($detail);
            $sv_transaksi->update([
                'total' => $subTotal
            ]);
            Keranjang::where(['user_id' => auth()->id()])->delete();

        }


        return redirect()->route('user.checkout-success',['po' => $no_po])->with('success','Berhasil membuat pesanan');
    }

    public function destroy(Request $request,Produk $produk)
    {
        
        Keranjang::where(['user_id' => auth()->id(),'produk_id' => $produk->id])->delete();
        
        return redirect()->route('user.keranjang.index')->with('success','Berhasil menghapus data keranjang');

    }

    public function checkout_success(Request $request)
    {
        if(!$request->input('po'))
        {
            abort(404);
        }
        $data['detail'] = Transaksi::where(['no_po' => $request->po])->first();
        return view('user.checkout-success',$data);
    }

}
