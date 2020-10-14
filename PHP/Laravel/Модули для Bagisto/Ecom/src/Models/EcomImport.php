<?php

namespace Webkul\Ecom\Models;

use Illuminate\Database\Eloquent\Model;

class EcomImport extends Model
{

    protected $casts = [
        "last_import" => 'timestamp',
        "first_runtime" => 'timestamp',
    ];

    public function types()
    {
        return $this->belongsTo(EcomImportType::class, 'ecom_import_type_id');
    }

    public function intervals()
    {
        return $this->belongsTo(EcomImportInterval::class, 'ecom_import_interval_id');
    }

    public function last_import_statuses()
    {
        return $this->belongsTo(EcomImportLastrunStatus::class, 'import_lastrun_status_id');
    }
}
