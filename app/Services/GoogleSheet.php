<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\BatchUpdateSpreadsheetRequest;
use Google\Service\Sheets\Request as SheetRequest;
use Google\Service\Sheets\CopyPasteRequest;

class GoogleSheet
{
    protected $client;
    protected $service;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setApplicationName('Laravel Google Sheets');
        $this->client->setScopes([Sheets::SPREADSHEETS]);
        $this->client->setAuthConfig(storage_path('app/google/credentials.json'));
        $this->client->setAccessType('offline');

        $this->service = new Sheets($this->client);
    }

    public function getSheetData($spreadsheetId, $range)
    {
        try {
            $response = $this->service->spreadsheets_values->get($spreadsheetId, $range);
            return $response->getValues(); // คืนค่าข้อมูลทั้งหมดในช่วงที่ระบุ
        } catch (\Exception $e) {
            // จัดการข้อผิดพลาด
            \Log::error('Google Sheets API Error: ' . $e->getMessage());
            return null;
        }
    }

    public function findRowByColumnValue($data, $columnIndex, $value)
    {
        foreach ($data as $row) {
            if (isset($row[$columnIndex]) && $row[$columnIndex] == $value) {
                return $row; // คืนค่าทั้งแถวที่ตรงกับเงื่อนไข
            }
        }
        return null; // หากไม่พบค่า
    }

    public function updateCell($spreadsheetId, $cell, $value)
{
    $body = new \Google\Service\Sheets\ValueRange([
        'values' => [[$value]]
    ]);

    $params = ['valueInputOption' => 'RAW'];

    $this->service->spreadsheets_values->update(
        $spreadsheetId,
        $cell,
        $body,
        $params
    );
}


public function appendRow($spreadsheetId, $sheetName, $rowData)
{
    $range = $sheetName . '!A:E';
    $body = new \Google\Service\Sheets\ValueRange([
        'values' => [$rowData]
    ]);

    $params = ['valueInputOption' => 'USER_ENTERED'];

    return $this->service->spreadsheets_values->append(
        $spreadsheetId,
        $range,
        $body,
        $params
    );
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
                    'startColumnIndex' => 3, // D
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

public function getService()
{
    return $this->service;
}


}
