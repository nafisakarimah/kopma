<?php

namespace App\Http\Controllers;

use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsUser;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class,'index'])->name('home');
// Route::get('cari',[ProdukController::class,'cari'])->name('cari');
Route::get('kategori/{kategori:slug}',[HomeController::class,'kategori'])->name('kategori.detail');
Route::get('produk/{produk:slug}',[ProdukController::class,'show'])->name('produk.detail');

Route::get('feedback', [FeedbackController::class,'index'])->name('feedback');
Route::get('faq', [FaqController::class,'index'])->name('faq');
Route::get('guskom', [GuskomController::class,'index'])->name('guskom');
Route::get('guskom/{slug}', [GuskomController::class,'show'])->name('guskom.show');

Route::middleware('guest')->group(function(){

    Route::get('verify/{email}',[AuthController::class,'verify'])->name('verify');
    Route::get('login',[AuthController::class,'login'])->name('login');
    Route::post('login',[AuthController::class,'login_submit'])->name('login.send');

    Route::get('register',[AuthController::class,'register'])->name('register');
    Route::post('register',[AuthController::class,'register_submit'])->name('register.send');

});

Route::middleware('auth')->group(function(){
    Route::post('feedback', [FeedbackController::class,'store'])->name('feedback.send');
    Route::get('logout',[AuthController::class,'logout'])->name('logout');
});

Route::middleware(['auth',IsUser::class])->prefix('user')->name('user.')->group(function(){

    Route::redirect('','user/transaksi')->name('index');

    Route::post('keranjang/checkout', [User\KeranjangController::class,'checkout_submit'])->name('checkout.send');
    Route::get('keranjang/checkout', [User\KeranjangController::class,'checkout'])->name('checkout.index');
    Route::get('keranjang/checkout-success', [User\KeranjangController::class,'checkout_success'])->name('checkout-success');
    Route::get('keranjang/{produk:id}', [User\KeranjangController::class,'destroy'])->name('keranjang.destroy');
    Route::post('keranjang/{produk:id}', [User\KeranjangController::class,'save'])->name('keranjang.store');
    Route::put('keranjang/update-batch', [User\KeranjangController::class,'update_batch'])->name('keranjang.update-batch');
    Route::put('keranjang/{produk:id}', [User\KeranjangController::class,'update'])->name('keranjang.update');
    Route::get('keranjang', [User\KeranjangController::class,'index'])->name('keranjang.index');

    Route::post('transaksi/{transaksi:id}/bayar',[User\TransaksiController::class,'bayar'])->name('transaksi.bayar');
    Route::post('transaksi/{transaksi:id}/terima',[User\TransaksiController::class,'terima'])->name('transaksi.terima');
    Route::resource('transaksi',User\TransaksiController::class);
    Route::get('alamat-pengiriman/utama/{id}',[User\AlamatPengirimanController::class,'set_utama'])->name('alamat-pengiriman.utama');
    Route::resource('alamat-pengiriman',User\AlamatPengirimanController::class);
    Route::post('profil/update-foto',[User\ProfilController::class,'update_foto'])->name('update_foto');
    Route::post('profil/update-nak',[User\ProfilController::class,'ubahNak'])->name('profil.update-nak');
    Route::put('profil',[User\ProfilController::class,'update'])->name('profil.update-profil');
    Route::resource('profil',User\ProfilController::class);

});

Route::middleware(['auth',IsAdmin::class])->prefix('admin')->name('admin.')->group(function(){

    Route::redirect('','admin/transaksi')->name('index');

    Route::post('transaksi/{transaksi:id}/terima',[Admin\TransaksiController::class,'terima'])->name('transaksi.terima');
    Route::post('transaksi/{transaksi:id}/tolak',[Admin\TransaksiController::class,'tolak'])->name('transaksi.tolak');
    Route::post('transaksi/{transaksi:id}/selesai',[Admin\TransaksiController::class,'selesai'])->name('transaksi.selesai');
    Route::get('transaksi/filter/',[Admin\TransaksiController::class,'filterData'])->name('transaksi.filter.category');
    Route::resource('transaksi',Admin\TransaksiController::class);
    Route::resource('guskom',Admin\GuskomController::class);
    Route::resource('faq',Admin\FaqController::class);
    Route::get('feedback/update-tampil/{id}',[Admin\FeedbackController::class,'tampilkan'])->name('feedback.update-tampil');
    Route::resource('feedback',Admin\FeedbackController::class);
    Route::get('pengguna',[Admin\PenggunaController::class,'index'])->name('pengguna');
    // Route::get('pengguna/filter/',[Admin\PenggunaController::class,'filterByDate'])->name('pengguna.filter');

    Route::get('pengguna/{id}/edit',[Admin\PenggunaController::class,'edit'])->name('pengguna.edit');
    Route::put('pengguna/{id}/edit',[Admin\PenggunaController::class,'update'])->name('pengguna.update');
    Route::put('pengguna/verif/{user:id}',[Admin\PenggunaController::class,'verif'])->name('pengguna.verif');
    Route::put('pengguna/suspen/{user:id}',[Admin\PenggunaController::class,'suspen'])->name('pengguna.suspen');
    Route::get('pengguna',[Admin\PenggunaController::class,'index'])->name('pengguna');

    Route::get('member',[Admin\MemberController::class,'index'])->name('member');
    Route::put('member/verif/{user:id}',[Admin\MemberController::class,'verif'])->name('member.verif');
    Route::put('member/suspen/{user:id}',[Admin\MemberController::class,'suspen'])->name('member.suspen');
    Route::put('member/unverif/{user:id}',[Admin\MemberController::class,'unverif'])->name('member.unverif');
    Route::get('member',[Admin\MemberController::class,'index'])->name('member');

    Route::resource('kategori', Admin\KategoriController::class);
    Route::resource('produk', Admin\ProdukController::class);


});
