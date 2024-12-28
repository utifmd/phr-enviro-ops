<?php

namespace App\Livewire\WorkTrips;

use App\Models\WorkTrip;
use App\Repositories\Contracts\IDBRepository;
use App\Repositories\Contracts\IPostRepository;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\IWorkTripRepository;
use App\Utils\WorkTripStatusEnum;
use App\Utils\WorkTripTypeEnum;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use PhpOffice\PhpSpreadsheet\Writer\Exception;

class Import extends Component
{
    use WithPagination, WithFileUploads;
    protected IDBRepository $dbRepos;
    protected IUserRepository $usrRepos;
    protected IPostRepository $pstRepos;
    protected IWorkTripRepository $wtRepos;
    public array $authUsr, $columns, $dateAndPostIdState, $areaState, $dateAndNoteState;

    public ?UploadedFile $csvFile = null;

    public function boot(
        IDBRepository $dbRepos,
        IUserRepository $usrRepos,
        IPostRepository $pstRepos,
        IWorkTripRepository $wtRepos): void
    {
        $this->dbRepos = $dbRepos;
        $this->usrRepos = $usrRepos;
        $this->pstRepos = $pstRepos;
        $this->wtRepos = $wtRepos;
    }

    public function mount(): void
    {
        $this->initForm();
        $this->initAuthUser();
    }

    private function initForm(): void
    {
        $this->columns = [
            'date', 'time', 'act_name', 'act_process', 'act_unit', 'act_value', 'area_name', 'area_loc', 'type', 'status', 'post_id', 'user_id'
        ];
    }

    private function readCSV($csvFile, $delimiter = ','): array
    {
        $line_of_text = [];
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

    private function initAuthUser(): void
    {
        $this->authUsr = $this->usrRepos->authenticatedUser()->toArray();
    }

    private function mapCsvToWorkTrip(array $csv): array
    {
        $workTrips = [];
        foreach ($csv as $rawRow) {
            $rowInput = []; $row = explode(';', collect($rawRow)->first());

            foreach ($this->columns as $i => $col) {
                $rowInput[$col] = $row[$i] ?? null;
            }
            $this->dateAndPostIdState[$row[0]] = null;
            $this->dateAndNoteState[$row[0]] = null;
            $this->areaState[$row[6]] = null;
            $workTrips[] = $rowInput;
        }
        return $workTrips;
    }

    private function assignNotes(
        string $date, string $note, string $postId, string $userId): void
    {
        if (!is_null($this->dateAndNoteState[$date])) return;

        $this->wtRepos->addNotesWith($postId, $userId, $note);
        $this->dateAndNoteState[$date] = $postId;
    }

    private function generateTripPlan(array $report): array
    {
        $dates = array_keys($this->dateAndPostIdState);
        $areas = array_keys($this->areaState);
        foreach ($areas as $area) {
            $infos = $this->wtRepos->getInfoByDateOrDatesAndArea($dates, $area);

            foreach ($infos as $trip) {
                $trip['type'] = WorkTripTypeEnum::ACTUAL->value;
                $matchRow = $this->wtRepos->tripsExistByDateTimeTypeProcLocBuilder($trip);
                if (!$matchRow->exists()) continue; // $existing = $matchRow->first()->toArray(); $existing['act_value'] = $trip['act_value']; $this->wtRepos->updateTrip($trip); // $matchRow->update(['act_value' => $trip['act_value']]); // $report['updated']++;

                $trip['type'] = WorkTripTypeEnum::PLAN->value;
                $trip['status'] = WorkTripStatusEnum::APPROVED->value;
                $this->wtRepos->addTrip($trip);
                $report['added']++;
            }
        }
        return $report;
    }

    /**
     * @throws Exception
     */
    private function generateTripActual(array $workTrips, array $report): array
    {
        foreach ($workTrips as $trip) {
            $trip['type'] = WorkTripTypeEnum::ACTUAL->value;
            $matchRow = $this->wtRepos->tripsExistByDateTimeTypeProcLocBuilder($trip);

            if ($matchRow->exists()) { // $existing = $matchRow->first()->toArray(); $existing['act_value'] = $trip['act_value']; $this->wtRepos->updateTrip($existing);
                $matchRow->update(['act_value' => $trip['act_value']]);
                $report['updated']++;
                continue;
            }
            if (is_null($this->dateAndPostIdState[$date = $trip['date']])) {
                $post = $this->pstRepos->getPostByDate($date);
                $postId = $post->isNotEmpty()
                    ? $post->first()->id
                    : throw new Exception('Trouble while getting the post');
                $this->dateAndPostIdState[$trip['date']] = $postId;
                $report['batch']++;
            }
            $trip['type'] = WorkTripTypeEnum::ACTUAL->value;
            $trip['status'] = WorkTripStatusEnum::APPROVED->value;
            $trip['post_id'] = $this->dateAndPostIdState[$trip['date']];
            $trip['user_id'] = $this->authUsr['id']; /*$this->assignNotes($trip['date'], $trip['note'], $trip['post_id'], $trip['user_id']);*/

            $this->wtRepos->addTrip($trip);
            $report['added']++;
        }
        return $report;
    }

    public function import(): void
    {
        $this->validate(['csvFile' => 'required|file|mimes:csv,txt']);
        $report = ['updated' => 0, 'added' => 0, 'batch' => 0];
        try {
            $this->dbRepos->async();

            $tempPath = $this->csvFile->getRealPath();
            $this->removeBom($tempPath);
            $csv = $this->readCSV($tempPath);
            $workTrips = $this->mapCsvToWorkTrip($csv);
            $report = $this->generateTripActual($workTrips, $report);
            $report = $this->generateTripPlan($report);

            $message = 'Hasil eksekusi file yang anda upload adalah ';
            $message .= 'updated: ' . $report['updated'] . ', added: ' . $report['added'];

            if ($report['added'] > 0) {
                $message .= ', batch: ' . $report['batch'];
            }
            session()->flash('message', $message);
            $this->dbRepos->await();

        } catch (\Throwable $exception) {
            $this->dbRepos->cancel();
            $message = $exception->getMessage();

            $this->addError('error', $message);
            Log::debug($message);
        }
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.work-trip.import');
    }
}
