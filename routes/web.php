    <?php

use App\Http\Controllers\admin2;
use App\Http\Controllers\CabangController;
    use App\Http\Controllers\DataAnggotaController;
    use App\Http\Controllers\DasboardController;
    use App\Http\Controllers\DashboardPelatihController;
use App\Http\Controllers\kaderController;
use App\Http\Controllers\LoginController;
    use App\Http\Controllers\PelatihController;
use App\Http\Controllers\PendekarController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\TingnkatanController;
    use App\Http\Controllers\UktController;
use App\Http\Controllers\uktPimdaController;
use App\Models\Pendekar;
use Illuminate\Support\Facades\Route;

    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider and all of them will
    | be assigned to the "web" middleware group. Make something great!
    |
    */

    Route::get('/', function () {
        return view('welcome');
    })->name('welcome')->middleware('Loginv2');
    Route::get('/dashboard',[DasboardController::class, 'index'])->name('dashboard.index')->middleware('Login');
    Route::post('/login',[LoginController::class, 'loginPost'])->name('loginPost');
    Route::delete('/logout',[LoginController::class, 'destroy'])->name('logout');
    Route::get('/cabang', [CabangController::class, 'index'])->name('cabang.index');
    Route::put('/cabang/{cabang}/update', [CabangController::class, 'update'])->name('cabang.update');
    Route::put('/tingkatan/{tingkatan}/update', [TingnkatanController::class, 'update'])->name('tingkatan.update');
    Route::delete('/tingkatan/{tingkatan}/destroy', [TingnkatanController::class, 'destroy'])->name('tingkatan.destroy');
    Route::delete('/anggota/{anggota}/destroy', [DataAnggotaController::class, 'destroy'])->name('anggota.destroy');
    Route::delete('/cabang/{cabang}/destroy', [CabangController::class, 'destroy'])->name('cabang.destroy');
    Route::put('/anggota/{anggota}/update', [DataAnggotaController::class, 'update'])->name('anggota.update');
    Route::post('/cabang', [CabangController::class, 'store'])->name('cabang.store');
    Route::get('/tingkatan', [TingnkatanController::class, 'index'])->name('tingkatan.index');
    Route::post('/tingkatan', [TingnkatanController::class, 'store'])->name('tingkatan.store');
    Route::get('/anggota', [DataAnggotaController::class, 'index'])->name('anggota.index');
    Route::post('/anggota', [DataAnggotaController::class, 'store'])->name('anggota.store');
    Route::get('/pelatih',[PelatihController::class, 'index'])->name('pelatih.index')->middleware('LoginPelatih');
    Route::post('/pelatih',[PelatihController::class, 'store'])->name('pelatih.store')->middleware('LoginPelatih');
    Route::put('/pelatih/{siswa}/update', [PelatihController::class, 'update'])->name('pelatih.update');
    Route::get('/ukt',[UktController::class, 'index'])->name('ukt.index')->middleware('LoginPelatih');
    Route::post('/ukt',[UktController::class, 'store'])->name('ukt.store');
    Route::delete('/ukt/{ukt}/destroy',[UktController::class, 'destroy'])->name('ukt.destroy')->middleware('LoginPelatih');
    Route::get('/Dashpelatih', [DashboardPelatihController::class, 'index'])->name('Dashpelatih.index')->middleware('LoginPelatih');
    Route::get('/prestasi',[PrestasiController::class, 'index'])->name('prestasi.index')->middleware('LoginPelatih');
    Route::post('/prestasi',[PrestasiController::class, 'store'])->name('prestasi.store');
    Route::put('/prestasi/{prestasi}/update',[PrestasiController::class, 'update'])->name('prestasi.update');
    Route::delete('/prestasi/{prestasi}/destroy',[PrestasiController::class, 'destroy'])->name('prestasi.destroy');
    Route::get('/uktpimda',[uktPimdaController::class, 'index'])->name('uktpimda.index');
    Route::post('/uktpimda',[uktPimdaController::class, 'store'])->name('uktpimda.store');
    Route::delete('/uktpimda/{uktpimda}/destroy',[uktPimdaController::class,'destroy'])->name('uktpimda.destroy');
    Route::put('/uktpimda/{uktpimda}/update',[uktPimdaController::class,'update'])->name('uktpimda.update');
    Route::get('/kader',[kaderController::class, 'index'])->name('kader.index');
    Route::post('/kader',[kaderController::class, 'store'])->name('kader.store');
    Route::delete('/kader/{kader}/destroy',[kaderController::class,'destroy'])->name('kader.destroy');
    Route::get('/admin2',[admin2::class, 'index'])->name('admin2.index');
    Route::post('/admin2',[admin2::class, 'store'])->name('admin2.store');
    Route::get('/kader/fetchAnggota', [KaderController::class, 'fetchAnggota']);
    Route::get('/pendekar',[PendekarController::class, 'index'])->name('pendekar.index');
    Route::post('/pendekar',[PendekarController::class, 'store'])->name('pendekar.store');
    Route::delete('/pendekar/{pendekar}/destroy',[PendekarController::class,'destroy'])->name('pendekar.destroy');

