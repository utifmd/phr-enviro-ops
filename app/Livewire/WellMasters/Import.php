<?php

namespace App\Livewire\WellMasters;

use App\Models\WellMaster;
use App\Repositories\Contracts\IDBRepository;
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

    public function import(): void
    {
        try {
            $this->validate();
            $this->dbRepos->async();

            $columns = $this->well->fillable;
            $report = ['added' => 0, 'skipped' => 0];

            $tempPath = $this->csvFile->getRealPath();
            $wellMasters = $this->readCSV($tempPath);

            if (is_null($wellMasters)) return;
            foreach ($wellMasters as $wellMaster) {
                $rowInput = [];
                $cells = explode(';', collect($wellMaster)->first());
                $matchRow = WellMaster::query();
                foreach ($cells as $i => $cell) {
                    $rowInput[$columns[$i] ?? $i] = $cell;
                    $matchRow->where($columns[$i], '=', $cell);
                }
                if ($matchRow->exists()) {
                    $report['skipped']++;
                    continue;
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
