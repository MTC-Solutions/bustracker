<?php

namespace App\Exports;

use App\Driver;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DriversExport implements FromView, ShouldAutoSize
{
    public $title;
    public $drivers;
    public function __construct($title, $drivers)
    {
        $this->title = $title;
        $this->drivers = $drivers;
    }

    public function view(): View
    {
        return view('drivers.report', [
            'drivers' => $this->drivers,
            'title' => $this->title,
        ]);
    }
}
