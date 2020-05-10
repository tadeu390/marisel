<?php

namespace App\Exports\Viagem;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportarViagem implements FromView
{
    private $viagem;

    public function __construct($viagem)
    {
        $this->viagem = $viagem;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('admin.viagens.viagem_excel', ['viagem' => $this->viagem]);
    }
}
