<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    protected $fillable = ['date', 'total_invoices', 'total_value', 'total_expenses', 'expenses', 'invoices', 'value'];
    public $timestamps = false;

    public function getDates() {
        return ['date'];
    }
}
