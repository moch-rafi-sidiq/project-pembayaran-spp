<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;
    protected $title;
    
    public function __construct($data, $title)
    {
        $this->data = $data;
        $this->title = $title;
    }
    
    public function collection()
    {
        return $this->data;
    }
    
    public function headings(): array
    {
        return [
            'No',
            'Tanggal Bayar',
            'NIS',
            'Nama Siswa',
            'Bulan',
            'Tahun',
            'Jumlah',
            'Metode',
            'Status'
        ];
    }
    
    public function map($row): array
    {
        static $no = 1;
        return [
            $no++,
            date('d/m/Y', strtotime($row->tanggal_bayar)),
            $row->siswa->nis ?? '-',
            $row->siswa->name ?? '-',
            $row->bulan,
            $row->tahun,
            $row->jumlah,
            $row->metode,
            $row->status
        ];
    }
}