<?php

namespace App\Http\Controllers;

    use App\Models\Cabang;
    use App\Models\Anggota;
    use App\Models\Tingkatan;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;

    use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;

class DasboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
    
        $jumlahPendekarbesar = Anggota::whereHas('tingkatan', function($query) {
            $query->where('nama_tingkatan', 'pendekar besar');
        })->count();
        $jumlahPendekarutama = Anggota::whereHas('tingkatan', function($query) {
            $query->where('nama_tingkatan', 'pendekar utama');
        })->count();
        $jumlahPendekarkepala = Anggota::whereHas('tingkatan', function($query) {
            $query->where('nama_tingkatan', 'pendekar kepala');
        })->count();
        $jumlahPendekarmadya = Anggota::whereHas('tingkatan', function($query) {
            $query->where('nama_tingkatan', 'pendekar madya');
        })->count();
        $jumlahPendekarMuda = Anggota::whereHas('tingkatan', function($query) {
            $query->where('nama_tingkatan', 'pendekar muda');
        })->count();

        $jumlahKaderMuda = Anggota::whereHas('tingkatan', function($query) {
            $query->where('nama_tingkatan', 'kader muda');
        })->count();
        $jumlahKaderkepala = Anggota::whereHas('tingkatan', function($query) {
            $query->where('nama_tingkatan', 'kader kepala');
        })->count();
        $jumlahKaderutama = Anggota::whereHas('tingkatan', function($query) {
            $query->where('nama_tingkatan', 'kader utama');
        })->count();
        $jumlahKadermadya = Anggota::whereHas('tingkatan', function($query) {
            $query->where('nama_tingkatan', 'kader madya');
        })->count();
        $jumlahKaderdsasar = Anggota::whereHas('tingkatan', function($query) {
            $query->where('nama_tingkatan', 'kader dasar');
        })->count();
        $jumlahsiswa4 = Anggota::whereHas('tingkatan', function($query) {
            $query->where('nama_tingkatan', 'siswa 4');
        })->count();
        $jumlahsiswa3 = Anggota::whereHas('tingkatan', function($query) {
            $query->where('nama_tingkatan', 'siswa 3');
        })->count();
       $jumlahsiswa2 = Anggota::whereHas('tingkatan', function($query) {
            $query->where('nama_tingkatan', 'siswa 2');
        })->count();
       $jumlahsiswa1 = Anggota::whereHas('tingkatan', function($query) {
            $query->where('nama_tingkatan', 'siswa 1');
        })->count();
       $jumlahsiswadasar = Anggota::whereHas('tingkatan', function($query) {
            $query->where('nama_tingkatan', 'siswa dasar');
        })->count();
       

        $totalCabang = Cabang::count();

    // Menyiapkan data untuk pie chart jumlah cabang
    $chartTotalCabang = LarapexChart::pieChart()
        ->setTitle('Jumlah Total Cabang')
        ->addData([$totalCabang])  // Menggunakan satu segmen untuk total cabang
        ->setLabels(['Total Cabang'])
        ->setColors([sprintf('#%06X', mt_rand(0, 0xFFFFFF))]);
        
        
        
        function generateRandomColor() {
            return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        }

        $cabangs = Cabang::all();

        $cabangCounts = Anggota::join('table_cabang', 'table_anggota.kode_cabang', '=', 'table_cabang.nomor_induk_cabang')
            ->select('table_cabang.nomor_induk_cabang', 'table_cabang.nama_cabang as cabang', DB::raw('count(*) as total'))
            ->groupBy('table_cabang.nomor_induk_cabang', 'table_cabang.nama_cabang')
            ->get();

        $labels = [];
        $data = [];
        $colors = [];

        foreach ($cabangs as $cabang) {
            $labels[] = $cabang->nama_cabang;

            $count = $cabangCounts->firstWhere('nomor_induk_cabang', $cabang->nomor_induk_cabang);
            $data[] = $count ? $count->total : 0;

            $colors[] = generateRandomColor();
        }

       
        $chartCabang = LarapexChart::barChart()
            ->setTitle('Jumlah Anggota per Cabang')
            ->addData('Jumlah Anggota', $data)
            ->setXAxis($labels)
            ->setColors($colors); 
            
        
        return view('pages.dashboard', compact('jumlahPendekarutama','jumlahsiswadasar','jumlahsiswa1','jumlahsiswa2','jumlahsiswa3','jumlahsiswa4','jumlahKaderdsasar','jumlahKadermadya','jumlahKaderutama','jumlahKaderkepala','jumlahPendekarbesar','jumlahPendekarmadya','chartTotalCabang','jumlahPendekarbesar','jumlahPendekarkepala','chartCabang','jumlahPendekarMuda','jumlahKaderMuda'));
    }

    



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
