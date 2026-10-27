<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\HalamanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Layanan
Route::get('/layanan', [LayananController::class, 'index'])->name('layanan.index');
Route::get('/layanan/{layanan}', [LayananController::class, 'show'])->name('layanan.show');

// Portofolio
Route::get('/portofolio', [PortofolioController::class, 'index'])->name('portofolio.index');
Route::get('/portofolio/{portofolio}', [PortofolioController::class, 'show'])->name('portofolio.show');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/kategori/{kategori}', [BlogController::class, 'index'])->name('blog.kategori');
Route::get('/blog/{artikel}', [BlogController::class, 'show'])->name('blog.show');

// Halaman statis
Route::get('/harga', [HalamanController::class, 'harga'])->name('harga');
Route::get('/tentang', [HalamanController::class, 'tentang'])->name('tentang');
Route::get('/faq', [HalamanController::class, 'faq'])->name('faq');
Route::get('/kontak', [HalamanController::class, 'kontak'])->name('kontak');
Route::post('/kontak', [HomeController::class, 'kirimPesan'])
    ->middleware('throttle:5,1')
    ->name('kontak.kirim');

// SEO
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
