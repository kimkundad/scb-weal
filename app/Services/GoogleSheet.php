<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;

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
}
