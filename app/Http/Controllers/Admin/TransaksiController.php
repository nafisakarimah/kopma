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
    public function index(Request $request)
    {
        $data = new Transaksi;
        if($request->input('status') != '')
        {
            $data = $data->where('status',$request->status);
        }
        $data = $data->orderBy('created_at','desc')->get();

        $transaksi = DB::table('transaksi')
            ->join('users', 'transaksi.user_id', '=', 'users.id')
            ->join('detail_transaksi', 'transaksi.id', '=', 'detail_transaksi.transaksi_id')
            ->join('produk', 'detail_transaksi.produk_id', '=', 'produk.id')
            ->join('kategori', 'produk.kategori_id', '=', 'kategori.id')
            ->whereYear('transaksi.created_at', date('Y'))
            ->whereMonth('transaksi.created_at', date('m'))
            ->whereDate('transaksi.created_at', '<=', now())
            ->where('transaksi.status', 2)
            ->where('kategori.nama','=', "Swalayan")
            ->select(
                DB::raw('DATE(transaksi.created_at) as tanggal'),
                'produk.nama as nama_barang',
                DB::raw('SUM(detail_transaksi.jumlah) as total_barang')
            )
            ->groupBy('tanggal', 'produk.nama')
            ->get();

        $chartData = array(
            'labels' => array(),
            'datasets' => array()
            );

        $uniqueDates = [];

        $groupedData = [];
        foreach ($transaksi as $item) {
            $productName = $item->nama_barang;
            $date = $item->tanggal;
            $total = (int) $item->total_barang;

            if (!in_array($date, $uniqueDates)) {
                $uniqueDates[] = $date;
            }

            if (!isset($groupedData[$productName])) {
                $groupedData[$productName] = [
                    'label' => $productName,
                    'data' => array_fill(0, count($uniqueDates), 0)
                ];
            }

            $dateIndex = array_search($date, $uniqueDates);
            $groupedData[$productName]['data'][$dateIndex] = $total;
        }

        asort($uniqueDates);

        $datasets = [];
        foreach ($groupedData as $item) {
            $datasets[] = [
                'label' => $item['label'],
                'data' => array_values($item['data'])
            ];
        }


        // status pesanan
        $allTransaksi =  count(Transaksi::get());

        $new =   count(Transaksi::where("status",'=',0)->whereYear("created_at",date('Y'))->whereMonth("created_at",date('m'))->get());
        $ongoing = count(Transaksi::where("status",'=',1)->whereYear("created_at",date('Y'))->whereMonth("created_at",date('m'))->get());
        $done = count(Transaksi::where("status",'=',2)->whereYear("created_at",date('Y'))->whereMonth("created_at",date('m'))->get());
        $cancelled = count(Transaksi::where("status",'=',3)->whereYear("created_at",date('Y'))->whereMonth("created_at",date('m'))->get());


        if($allTransaksi != 0) {
            $newPresentase =   intval(count(Transaksi::where("status",'=',0)->whereYear("created_at",date('Y'))->whereMonth("created_at",date('m'))->get())/$allTransaksi * 100);
            $ongoingPresentase = intval(count(Transaksi::where("status",'=',1)->whereYear("created_at",date('Y'))->whereMonth("created_at",date('m'))->get())/$allTransaksi * 100);
            $donePresentase = intval(count(Transaksi::where("status",'=',2)->whereYear("created_at",date('Y'))->whereMonth("created_at",date('m'))->get())/$allTransaksi * 100);
            $cancelledPresentase = intval(count(Transaksi::where("status",'=',3)->whereYear("created_at",date('Y'))->whereMonth("created_at",date('m'))->get())/$allTransaksi * 100);

        } else {
            $newPresentase =  0;
            $ongoingPresentase = 0;
            $donePresentase = 0;
            $cancelledPresentase = 0;

        }


        return view('admin.transaksi.index',[
            'data' => $data,
            'labels' => $uniqueDates,
            'datasets' => $datasets,
            'new' => $new,
            'ongoing' => $ongoing,
            'done' => $done,
            'cancelled' => $cancelled,
            'newPresentase' => $newPresentase,
            'ongoingPresentase' => $ongoingPresentase,
            'donePresentase' => $donePresentase,
            'cancelledPresentase' => $cancelledPresentase,
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
            'bukti_barang_sampai' => 'required|image|mimes:png,jpg'
        ]);
        $gambar = 'error';
        $path = $request->file('bukti_barang_sampai')->store('public/transaksi/bukti');
        if($path)
        {
            $gambar = Storage::url($path);
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
