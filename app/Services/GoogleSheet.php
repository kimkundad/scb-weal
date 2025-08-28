<?php
namespace App\Services;

use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\BatchUpdateSpreadsheetRequest;
use Google\Service\Sheets\Request as SheetRequest;
use Google\Service\Sheets\CopyPasteRequest;
use Google\Service\Sheets\ValueRange;

class GoogleSheet
{
    protected $client;
    protected $service;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setApplicationName('Laravel Google Sheets');
        $this->client->setScopes([Sheets::SPREADSHEETS]); // แก้/เขียนได้
        $this->client->setAuthConfig(storage_path('app/google/credentials.json'));
        $this->client->setAccessType('offline');

        $this->service = new Sheets($this->client);
    }

    public function getService() { return $this->service; }

    /** ใส่ single quotes ให้ชื่อชีตถ้าจำเป็น */
    private function quoteSheetName(string $sheetName): string
    {
        // ถ้ามีช่องว่างหรืออักขระพิเศษ ให้ครอบด้วย '
        if (preg_match('/[^A-Za-z0-9_]/', $sheetName)) {
            // escape single quote ภายในชื่อชีต
            $sheetName = str_replace("'", "''", $sheetName);
            return "'{$sheetName}'";
        }
        return $sheetName;
    }

    /** อ่านช่วงข้อมูล (เดิมของคุณ) */
    public function getSheetData($spreadsheetId, $range)
    {
        try {
            $response = $this->service->spreadsheets_values->get($spreadsheetId, $range);
            return $response->getValues();
        } catch (\Exception $e) {
            \Log::error('Google Sheets API Error(getSheetData): ' . $e->getMessage());
            return null;
        }
    }

    /** อ่านค่าเซลล์เดียว */
    public function getCellValue(string $spreadsheetId, string $sheetName, int $row, string $col): ?string
    {
        $sheet = $this->quoteSheetName($sheetName);
        $range = "{$sheet}!{$col}{$row}";
        $res = $this->service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $res->getValues();
        return ($values && isset($values[0][0])) ? (string)$values[0][0] : null;
    }

    /** เขียนค่าเซลล์เดียว (คืน response หรือโยน error ออกไปให้ controller จับ) */
    public function updateCell(string $spreadsheetId, string $cell, string $value, string $input = 'RAW')
    {
        $body = new ValueRange(['values' => [[$value]]]);
        $params = ['valueInputOption' => $input]; // RAW|USER_ENTERED
        return $this->service->spreadsheets_values->update($spreadsheetId, $cell, $body, $params);
    }

    public function appendRow($spreadsheetId, $sheetName, $rowData)
    {
        $sheet = $this->quoteSheetName($sheetName);
        $range = $sheet . '!A:E';
        $body = new ValueRange(['values' => [$rowData]]);
        $params = ['valueInputOption' => 'USER_ENTERED'];
        return $this->service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);
    }

    public function copyPasteFormat($spreadsheetId, $sheetId, $fromRow, $toRow)
    {
        $requests = [
            new SheetRequest([
                'copyPaste' => new CopyPasteRequest([
                    'source' => [
                        'sheetId' => $sheetId,
                        'startRowIndex' => $fromRow,
                        'endRowIndex' => $fromRow + 1,
                        'startColumnIndex' => 3, // D = index 3 (zero-based)
                        'endColumnIndex' => 4,
                    ],
                    'destination' => [
                        'sheetId' => $sheetId,
                        'startRowIndex' => $toRow,
                        'endRowIndex' => $toRow + 1,
                        'startColumnIndex' => 3,
                        'endColumnIndex' => 4,
                    ],
                    'pasteType' => 'PASTE_FORMAT'
                ])
            ])
        ];

        $body = new BatchUpdateSpreadsheetRequest(['requests' => $requests]);
        return $this->service->spreadsheets->batchUpdate($spreadsheetId, $body);
    }

    public function findRowByColumnValue($data, $columnIndex, $value)
    {
        foreach ($data as $row) {
            if (isset($row[$columnIndex]) && $row[$columnIndex] == $value) {
                return $row;
            }
        }
        return null;
    }
}
