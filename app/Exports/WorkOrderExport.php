<?php

namespace App\Exports;

use App\Models\Information;
use App\Models\PostWoPlanOrder;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WorkOrderExport implements
    FromView, WithDrawings, WithStyles, ShouldAutoSize //, FromCollection, WithMapping
{
    private array $barcodeImages;
    private string $generatedWoNumber;

    private Information $information;
    private PostWoPlanOrder $planOrder;
    private Collection $planTrips;
    /**
    * @return void
    */
    public function __construct(
        Post $post, string $generatedWoNumber, string $qrBase64DataOrPath, bool $isPath = false) {
        $this->information = $post->information;
        $this->planOrder = $post->planOrder;
        $this->planTrips = $post->planTrips;

        /*Log::debug("WorkOrderExport __construct");
        Log::debug(json_encode($this->information));*/
        $this->generatedWoNumber = $generatedWoNumber;

        $this->barcodeImages[$generatedWoNumber] = $isPath
            ? $qrBase64DataOrPath
            : $this->generateBarcodeImagePath($qrBase64DataOrPath);
    }

    protected function generateBarcodeImagePath(string $barcode): false|string
    {
        $barcodeImage = base64_decode($barcode);
        $barcodePath = public_path('images/barcodes');
        if (!file_exists($barcodePath)) {
            mkdir($barcodePath, 0777, true);
        }
        // $filePath = tempnam(sys_get_temp_dir(), 'barcode') . '.png';
        $filePath = $barcodePath .'/'. $this->generatedWoNumber . '.png';
        file_put_contents($filePath, $barcodeImage);
        return $filePath;
    }


    public function drawings(): array
    {
        $drawings = [];

        $drawing = new Drawing();
        $drawing->setName('QRcode');
        $drawing->setDescription('QRcode for WorkOrder Number ' . $this->generatedWoNumber);
        try {
            $drawing->setPath($this->barcodeImages[$this->generatedWoNumber]);
        } catch (Exception $e) {

            Log::debug($e->getMessage());
        }
        $drawing->setWidth(80);
        $drawing->setCoordinates('H2');
        $drawings[] = $drawing;

        return $drawings;
    }
    public function view(): View
    {

        return view('livewire.workorders.blueprint-tabled', [
            "information" => $this->information,
            "planOrder" => $this->planOrder,
            "planTrips" => $this->planTrips,
            "generatedWoNumber" => $this->generatedWoNumber
        ]);
    }
    public function styles(Worksheet $sheet): void
    {
        /*$highestRowAndColumn = $sheet->getHighestRowAndColumn();

        $highestRow = $highestRowAndColumn['row']; //'column'
        $dashboardCoordinate = self::HORIZONTAL_RANGE . $highestRow;
        $dashboard = $sheet->getStyle($dashboardCoordinate);

        $dashboard->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setWrapText(true);
        try {
            $dashboard->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);
        } catch (Exception $e) {

            Log::debug($e->getMessage());
        }
        $header = $sheet->getStyle(self::HORIZONTAL_RANGE.'2');

        $header->getFont()
            ->setBold(true);

        $header->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->setStartColor(new Color('BDD7EE'));*/
    }
    /*public function map($order): array
    {

        $DNS1D = new DNS1D();
        $barcode = $DNS1D->getBarcodePNG($order->id, 'C39');


        $this->barcodeImages[$order->id] = $this->generateBarcodeImage($barcode);

        return [
            $order->id,
            $order->status,
            $order->description,

            'barcode' => '',
        ];
    }*/

}
