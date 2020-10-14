<?php

namespace Webkul\Ecom\Repositories;

use Illuminate\Container\Container as App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Event;
use Webkul\Core\Eloquent\Repository;
use Webkul\Category\Models\Category;
use Webkul\Category\Models\CategoryTranslation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class EcomImportIntervalRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'Webkul\Ecom\Models\EcomImportInterval';
    }

    public function getEdit($id)
    {
        return $this->model::find($id);
    }

    public function getRegionByCode($code)
    {
        return $this->model::with(['types:id,name'])->whereAlias($code)->whereEnable(1)->first();
    }


    public function geIntervals()
    {
        return $this->model::orderBy('id', 'ASC')->get();
    }

    public function getIntervalsQuery()
    {
        return $this->model::orderBy('id', 'ASC');
    }



}