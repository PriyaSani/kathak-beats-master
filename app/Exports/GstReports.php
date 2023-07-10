<?php
  
namespace App\Exports;
  
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;    

class GstReports implements FromArray,WithHeadings,ShouldAutoSize
{

	protected $data;

	protected $heading;

	public function __construct(array $data,array $heading)
    {
        $this->data = $data;

        $this->heading = $heading;
    }

    public function headings(): array
    {
        return $this->heading;
    }

    public function array(): array
    {
        return $this->data;
    }
}