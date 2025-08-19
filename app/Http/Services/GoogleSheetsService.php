<?php

namespace App\Http\Services;

use App\Models\Setting;
use Google\Client;
use Google\Service\Fitness\Session;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;

class GoogleSheetsService
{
    private $client, $service, $documentId, $sheetId, $range;

    public function __construct()
    {
        $settings = Setting::first();

        $this->client = $this->getClient();
        $this->service = new Sheets($this->client);
        $this->documentId = $settings->google_spreadsheet_id ?? null;
        $this->sheetId = $settings->google_sheet_id ?? null;
        $this->range = 'A:Z';

        session()->forget('documentId');
    }

    private function getClient()
    {
        $client = new Client();
        $client->setApplicationName('Google Sheets Test');
        $client->setAuthConfig(storage_path('app/silics-email-12012005-6c9c95596836.json'));
        $client->setScopes(Sheets::SPREADSHEETS);

        return $client;
    }

    public function readSheet()
    {
        return $this->service->spreadsheets_values->get($this->documentId, $this->range);
    }

    public function writeSheet($values)
    {
        if (!$this->documentId) {
            session()->put('documentId', 'Нет активной ссылки на Google-таблицу');
            return;
        }

        $body = new ValueRange([
            'values' => $values,
        ]);
        $params = [
            'valueInputOption' => 'RAW'
        ];
        $this->service->spreadsheets_values->update(
            $this->documentId,
            $this->range,
            $body,
            $params
        );
    }

    private function getIndexForDelete($id)
    {
        $doc = $this->service->spreadsheets_values->get($this->documentId, $this->range);

        foreach ($doc->values as $index => $row) {
            if ($row['0'] === $id) {
                return $index;
            }
        }

        return -1;
    }

    public function deleteRowFromSheet($id)
    {
        if (!$this->documentId) return;

        $rowIndex = $this->getIndexForDelete($id);

        if ($rowIndex === -1) return;

        $requests = [
            new Sheets\Request([
                'deleteDimension' => [
                    'range' => [
                        'sheetId' => $this->sheetId,
                        'dimension' => 'ROWS',
                        'startIndex' => $rowIndex,
                        'endIndex' => $rowIndex + 1,
                    ]
                ]
            ])
        ];

        $batchUpdateRequest = new Sheets\BatchUpdateSpreadsheetRequest([
            'requests' => $requests,
        ]);

        $this->service->spreadsheets->batchUpdate($this->documentId, $batchUpdateRequest);
    }

    public function clearSheet()
    {
        if (!$this->documentId) return;

        $this->service->spreadsheets_values->clear($this->documentId, $this->range, new Sheets\ClearValuesRequest());
    }
}
