<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['google_spreadsheet_url', 'google_spreadsheet_id', 'google_sheet_id'];
}
