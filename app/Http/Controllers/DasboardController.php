<?php

namespace App\Http\Controllers;

    use App\Models\Cabang;
    use App\Models\Anggota;
    use App\Models\Tingkatan;
    use Illuminate\Http\Request;

    use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;

class DasboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cabangCount = Cabang::count();
        $anggotaCount = Anggota::count();
        $tingkatanCount = Tingkatan::count();
        // Create a chart
        $chartCabang = LarapexChart::barChart()
            ->setTitle('Jumlah Cabang')
            ->addData('Total Cabang', [$cabangCount])
            ->setXAxis(['Cabang']);

            $chartAnggota = LarapexChart::pieChart()
            ->setTitle('Jumlah Anggota')
            ->addData([$anggotaCount], '#ff9800') 
            ->setLabels(['Jumlah Anggota'])
            ->setColors(['#ff9800']);

            $chartTingkatan = LarapexChart::donutChart()
            ->setTitle('Jumlah Jumlah Tingkatan')
            ->addData([$tingkatanCount], '#ff9800') 
            ->setLabels(['Jumlah Tingkatan'])
            ->setColors(['#ff9800']);

        // Pass the chart to the view
        return view('pages.dashboard', compact('chartCabang','chartAnggota','chartTingkatan'));
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
