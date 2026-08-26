<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GraduationExport implements FromCollection, WithHeadings
{
    protected $data;
    protected $customHeadings;

    public function __construct($data, $customHeadings = null)
    {
        $this->data = $data;
        $this->customHeadings = $customHeadings;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        if ($this->customHeadings) {
            return $this->customHeadings;
        }

        if (!empty($this->data)) {
            $first = collect($this->data)->first();
            if (is_array($first)) {
                return array_keys($first);
            }
        }

        return [
            'NISN',
            'Nama Siswa',
            'Kelas Asal',
            'Angkatan',
            'Status',
            'Tanggal',
        ];
    }
}
