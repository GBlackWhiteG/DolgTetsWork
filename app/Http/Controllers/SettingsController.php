<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\RedirectResponse;

class SettingsController extends Controller
{
    public function setGoogleSheetUrl(): RedirectResponse
    {
        session()->forget('documentId');

        request()->validate([
            'google-sheet-url' => 'required|string'
        ]);

        $url = request()->only('google-sheet-url');

        $parts = explode('/', explode('d/', $url['google-sheet-url'])[1]);
        $spreadSheetId = $parts[0];
        $sheetId = explode('=', explode('#', $parts[1])[1])[1];

        Setting::updateOrCreate([
            'google_spreadsheet_url' => $url['google-sheet-url'],
            'google_spreadsheet_id' => $spreadSheetId,
            'google_sheet_id' => $sheetId
        ]);

        return redirect()->back();
    }
}
