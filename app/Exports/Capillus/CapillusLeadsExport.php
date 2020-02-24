<?php

namespace App\Exports\Capillus;

use App\Repositories\Capillus\CapillusLeadsRepository;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithPreCalculateFormulas;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class CapillusLeadsExport implements FromView, WithTitle, WithEvents, WithPreCalculateFormulas
{
    protected $repo;

    protected $sheet;

    public function __construct(array $options)
    {        
        $this->repo = new CapillusLeadsRepository([
            'date_from' => $options['date_from'], 
            'date_to' => $options['date_to'], 
        ]);

        $this->count = count($this->repo->data);
        $this->count = $this->count > 0 ? $this->count : 1;
    }

    public function view(): View
    {
        return view('exports.capillus.leads-report', [
            'data' => $this->repo->data,
            'title' => $this->sheet
        ]);
    }

    public function title(): string
    {
        return "Capillus Leads";
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {  
                
                // auto
                $this->sheet = $event->sheet->getDelegate();

                $this->configurePage()
                    ->formatHeaderRow()
                    ->formatDateColumn()
                    ->formatTimecolumns()
                    ->setColumnsWidth()
                    ;     

                $this->sheet->setAutoFilter("A1:O{$this->count}");
                $this->sheet->freezePane('E2');
            }
        ];
    }

    protected function setColumnsWidth()
    {    
        $this->sheet->getDefaultColumnDimension()->setWidth(10);

        $this->sheet->getRowDimension('1')->setRowHeight(32); 
                    
        foreach (range(1, 15) as $col) { 
            $this->sheet->getColumnDimensionByColumn($col)
                ->setAutoSize(true);
        }
        
        // $this->sheet->getColumnDimension('D')
        //     ->setWidth(23);
            
        // $this->sheet->getColumnDimension('F')
        //     ->setWidth(23);

        return $this;
    }

    protected function configurePage()
    {
        $this->sheet->getPageSetup()
            ->setPrintArea("A1:O{$this->count}")
            ->setFitToWidth(1)
            ->setFitToHeight(1000)
            ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);

        $this->sheet->getPageMargins()
            ->setTop(0.5)
            ->setBottom(0.17)
            ->setRight(0.17)
            ->setLeft(0.17);

        return $this;
    }

    protected function formatDateColumn()
    {
        $this->sheet->getStyle("A1:A{$this->count}")
            ->getNumberFormat()
            ->setFormatCode('mm/dd/yyyy');
        
        return $this;
    }

    protected function formatHeaderRow()
    {
        $format = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => [
                    'rgb' => 'E7E6E6',
                ]
            ],
            'borders' => [
                'bottom' => [
                    'borderStyle' => Border::BORDER_HAIR,
                    'color' => ['rgb' => '000000'],
                ]
            ],
            'font' => [
                'bold' => true,
            ]
        ];

        $this->sheet
            ->getStyle('A1:O1')
                ->applyFromArray($format)
                ->getAlignment()
                    ->setWrapText(true);

        return $this;
    }

    protected function formatTimecolumns()
    {
        $this->sheet->getStyle("B1:B{$this->count}")->getNumberFormat()
            ->setFormatCode(NumberFormat::FORMAT_DATE_TIME2);
            
        // $this->sheet->getStyle("I1:M{$this->count}")->getNumberFormat()
        //     ->setFormatCode(NumberFormat::FORMAT_DATE_TIME4);
        
        return $this;
    }
}
