<?php

namespace App\Livewire\WellMasters;

use App\Models\WellMaster;
use App\Repositories\Contracts\IDBRepository;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Import extends Component
{
    use WithPagination, WithFileUploads;
    protected IDBRepository $dbRepos;
    protected WellMaster $well;

    #[Validate('required|file|mimes:csv,txt')]
    public ?UploadedFile $csvFile = null;

    #[Layout('layouts.app')]
    public function render(): View
    {
        $wellMasters = WellMaster::paginate();

        return view('livewire.well-master.import', compact('wellMasters'))
            ->with('i', $this->getPage() * $wellMasters->perPage());
    }

    public function booted(IDBRepository $dbRepos): void
    {
        $this->well = new WellMaster();
        $this->dbRepos = $dbRepos;
    }

    private function readCSV($csvFile, $delimiter = ','): ?array
    {
        $line_of_text = null;
        $file_handle = fopen($csvFile, 'r');
        while ($csvRow = fgetcsv($file_handle, null, $delimiter)) {
            $line_of_text[] = $csvRow;
        }
        fclose($file_handle);
        return $line_of_text;
    }

    private function removeBom($filePath): void
    {
        $content = file_get_contents($filePath);

        $bom = "\xEF\xBB\xBF"; // BOM UTF-8
        if (substr($content, 0, 3) === $bom) {
            $content = substr($content, 3);
            file_put_contents($filePath, $content);
        }
    }

    public function import(): void
    {
        try {
            $this->validate();
            $this->dbRepos->async();

            $columns = $this->well->fillable;
            $report = ['added' => 0, 'skipped' => 0];

            $tempPath = $this->csvFile->getRealPath();
            $this->removeBom($tempPath);
            $csv = $this->readCSV($tempPath);

            if (is_null($csv)) return;
            foreach ($csv as $rawRow) {
                $rowInput = [];
                $row = explode(';', collect($rawRow)->first());
                $matchRow = WellMaster::query();
                foreach ($row as $i => $cell) {
                    $rowInput[$columns[$i] ?? $i] = $cell;
                    $matchRow->where($columns[$i], '=', $cell);
                }
                if ($matchRow->exists()) {
                    $report['skipped']++;
                    continue;
                }
                if (empty($rowInput['actual_spud'])) {
                    $rowInput['actual_spud'] = null;// date('Y-m-d H:i:s');
                }
                if (empty($rowInput['actual_drmo'])) {
                    $rowInput['actual_drmo'] = null;// date('Y-m-d H:i:s');
                }
                WellMaster::query()->create($rowInput);
                $report['added']++;
            }
            $message = 'Hasil eksekusi file yang anda upload adalah ';
            $message .= 'skipped: ' . $report['skipped'] . ', added: ' . $report['added'];
            session()->flash('message', $message);
            $this->dbRepos->await();

        } catch (\Throwable $exception) {
            $this->dbRepos->cancel();
            $message = $exception->getMessage();

            $this->addError('error', $message);
            Log::debug($message);
        }
    }
}
