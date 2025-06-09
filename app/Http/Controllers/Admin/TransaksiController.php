<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index()
     {
         // Ambil semua data transaksi tanpa filter
         $data = Transaksi::orderBy('created_at', 'desc')->get();

         return view('admin.transaksi.index', [
             'data' => $data
         ]);
     }

    public function show(Transaksi $transaksi)
    {
        return view('admin.transaksi.show',[
            'transaksi' => $transaksi
        ]);
    }

    public function tolak(Transaksi $transaksi)
    {
        $transaksi->update([
            'status' => 3,
        ]);

        return redirect()->route('admin.transaksi.index')->with('success','Berhasil menolak pesanan');

    }

    public function terima(Transaksi $transaksi)
    {
        $transaksi->update([
            'status' => 1
        ]);

        foreach($transaksi->detail as $detail){
            Produk::find($detail->produk_id)->update([
                'stok' => ($detail->produk->stok - $detail->jumlah)
            ]);
        }

        return redirect()->route('admin.transaksi.show',$transaksi->id)->with('success','Berhasil menerima pesanan');

    }

    public function selesai(Transaksi $transaksi, Request $request)
    {

        $request->validate([
            'bukti_barang_sampai' => 'required|image'
        ]);
        $gambar = 'error';

        if($request->hasFile('bukti_barang_sampai'))
        {
            $folder = 'transaksi/bukti';
            $file = $request->file('bukti_barang_sampai');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $newName = 'IMG-' . DATE("Ymd") . '-' . time();
            $newNameWithExtension = $newName . '.' . $extension;

            $upload = $file->move(base_path('/public/uploads/' . $folder), $newNameWithExtension);

            $gambar = $folder . '/' . $newNameWithExtension;
        }

        $transaksi->update([
            'status' => 2,
            'bukti_barang_sampai' => $gambar
        ]);

        $poin = ceil($transaksi->total/2000);
        $user = User::find($transaksi->user_id);
        if($user->member == 1)
        {
            $user->update([
                'member_poin' => $user->member_poin + $poin
            ]);
        }

        return redirect()->route('admin.transaksi.index')->with('success','Berhasil menyelesaikan pesanan');

    }

      public function filterByDate(Request $request)
    {

        if ($request->basedOn == 'hari') {

            $data = DB::table('transaksi')
                ->join('users', 'transaksi.user_id', '=', 'users.id')
                ->whereBetween('transaksi.created_at', [$request->from, $request->to])
                ->where('transaksi.status', 2)
                ->select(DB::raw('DATE(transaksi.created_at) as tanggal'), 'users.nama', DB::raw('SUM(transaksi.total) as total'))->groupBy('tanggal', 'nama')->get();
            } else {
            $data = DB::table('transaksi')
                ->join('users', 'transaksi.user_id', '=', 'users.id')
                ->whereYear('transaksi.created_at', date('Y'))
                ->whereMonth('transaksi.created_at', date('m'))
                ->where('transaksi.status', 2)
                ->select(DB::raw('DATE(transaksi.created_at) as tanggal'), 'users.nama', DB::raw('SUM(transaksi.total) as total'))->groupBy('tanggal', 'nama')->get();
            }

    $chartData = array(
        'labels' => array(),
        'datasets' => array()
    );

    $uniqueDates = [];

    $groupedData = [];

    foreach ($data as $item) {
        $userName = $item->nama;
        $date = $item->tanggal;
        $total = (int) $item->total;

        if (!in_array($date, $uniqueDates)) {
            $uniqueDates[] = $date;
        }

        if (!isset($groupedData[$userName])) {
            $groupedData[$userName] = [
                'label' => $userName,
                'data' => array_fill(0, count($uniqueDates), 0) // Initialize data array with zeros
            ];
        }

        $dateIndex = array_search($date, $uniqueDates);
        $groupedData[$userName]['data'][$dateIndex] = $total;
    }

    asort($uniqueDates);

    $datasets = [];
    foreach ($groupedData as $user) {
        $datasets[] = [
            'label' => $user['label'],
            'data' => array_values($user['data'])
        ];
    }


    return response()->json([
        "label" => $uniqueDates,
        "datasets" => $datasets
    ]);
}

    public function filterData(Request $request){

       if ($request->category == 'swalayan') {

             $data = DB::table('detail_transaksi')
                ->join('transaksi', 'detail_transaksi.transaksi_id', '=', 'transaksi.id')
                ->join('users', 'transaksi.user_id', '=', 'users.id')
                ->join('produk', 'detail_transaksi.produk_id', '=', 'produk.id')
                ->when(isset($request->from), function ($query) use ($request) {
                    return $query->whereBetween('transaksi.created_at', [$request->from, $request->to]);
                })
                ->where('produk.kategori_id',2)
                ->where('transaksi.status', 2)
                ->select(
                    DB::raw('DATE(transaksi.created_at) as tanggal'),
                    'produk.nama as nama_barang',
                    DB::raw('SUM(detail_transaksi.jumlah) as total_barang')
                )
                ->groupBy('tanggal', 'produk.nama')
                ->get();

        } else {
            $data = DB::table('detail_transaksi')
                ->join('transaksi', 'detail_transaksi.transaksi_id', '=', 'transaksi.id')
                ->join('users', 'transaksi.user_id', '=', 'users.id')
                ->join('produk', 'detail_transaksi.produk_id', '=', 'produk.id')
                ->when(isset($request->from), function ($query) use ($request) {
                    return $query->whereBetween('transaksi.created_at', [$request->from, $request->to]);
                })
                ->where('produk.kategori_id', 1)
                ->where('transaksi.status', 2)
                ->select(
                    DB::raw('DATE(transaksi.created_at) as tanggal'),
                    'produk.nama as nama_barang',
                    DB::raw('SUM(detail_transaksi.jumlah) as total_barang')
                )
                ->groupBy('tanggal', 'produk.nama')
                ->get();
        }

        $chartData = [
            'labels' => [],
            'datasets' => [],
        ];

        $uniqueDates = [];
        $groupedData = [];

        foreach ($data as $item) {
            $barangName = $item->nama_barang;
            $date = $item->tanggal;
            $total = (int) $item->total_barang;

            if (!in_array($date, $uniqueDates)) {
                $uniqueDates[] = $date;
            }

            if (!isset($groupedData[$barangName])) {
                $groupedData[$barangName] = [
                    'label' => $barangName,
                    'data' => array_fill(0, count($uniqueDates), 0)
                ];
            }

            $dateIndex = array_search($date, $uniqueDates);
            $groupedData[$barangName]['data'][$dateIndex] = $total;
        }

        asort($uniqueDates);

        $datasets = array_map(function ($barang) {
            return [
                'label' => $barang['label'],
                'data' => array_values($barang['data'])
            ];
        }, $groupedData);

        return response()->json([
            "label" => $uniqueDates,
            "datasets" => $datasets
        ]);

    }
}
