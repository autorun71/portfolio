<?php

namespace Webkul\Ecom\Repositories;

use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Event;
use Webkul\Core\Eloquent\Repository;
use Webkul\Category\Models\Category;
use Webkul\Category\Models\CategoryTranslation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class EcomImportRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'Webkul\Ecom\Models\EcomImport';
    }

    public function getEdit($id)
    {
        return $this->model::find($id);
    }


    public function getAll($get = false)
    {
        $result =  $this->model::with(['types:id,name,enable', 'intervals:id,name,interval', 'last_import_statuses:id,name,color'])->whereEnable(1);
        return $get ? $result->get() : $result;

    }

    public function getImportsExcludeRun($get = false) {
        $result = $this->getAll()->whereNotIn('import_lastrun_status_id', ['2', '3']);
        return $get ? $result->get() : $result;
    }

    public function getImports()
    {
        return $this->model::orderBy('id', 'ASC')->get();
    }

    public function getImportsQuery()
    {
        return $this->model::orderBy('id', 'ASC');
    }



}