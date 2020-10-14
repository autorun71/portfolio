<?php

namespace Webkul\Ecom\DataGrids;

use Illuminate\Support\Carbon;
use Webkul\Ecom\Repositories\EcomImportRepository;
use Webkul\Ui\DataGrid\DataGrid;

class EcomImportDataGrid extends DataGrid
{
    protected $index = 'id';

    protected $sortOrder = 'desc';

    /**
     * @var EcomImportRepository
     */
    protected $importRepository;

    public function __construct()
    {
        parent::__construct();

        $this->importRepository = app(EcomImportRepository::class);
    }

    public function prepareQueryBuilder()
    {
//        $queryBuilder = DB::table('regions')->addSelect('id', 'name', 'alias', 'enable');
        $imports = $this->importRepository->getImportsQuery();
        $this->setQueryBuilder($imports);


    }
//Carbon::createFromTimestamp(-1)->toDateTimeString();
    public function addColumns()
    {
        $this->addColumn([
            'index' => 'id',
            'label' => trans('ecom::app.section.import.fields.id'),
            'type' => 'number',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'title',
            'label' => trans('ecom::app.section.import.fields.name'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'code',
            'label' => trans('ecom::app.section.import.fields.code'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'first_runtime',
            'label' => trans('ecom::app.section.import.fields.time'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
            'closure'    => true,
            'wrapper'    => function ($value) {
                return Carbon::createFromTimestamp($value->first_runtime)->toDateTimeString();
            },
        ]);

        $this->addColumn([
            'index' => 'interval',
            'label' => trans('ecom::app.section.import.fields.interval'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
            'closure'    => true,
            'wrapper'    => function ($value) {
                return $value->intervals()->first()->name;

            },
        ]);

        $this->addColumn([
            'index' => 'last_import',
            'label' => trans('ecom::app.section.import.fields.last_import'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
            'closure'    => true,
            'wrapper'    => function ($value) {
                return $value->last_import ? Carbon::createFromTimestamp($value->last_import)->toDateTimeString() : 'не запускался';

            },
        ]);

        $this->addColumn([
            'index' => 'last_import_status',
            'label' => trans('ecom::app.section.import.fields.last_import_status'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
            'closure'    => true,
            'wrapper'    => function ($value) {
                return $value->last_import_statuses ? '<span style="color: ' . $value->last_import_statuses->color . '">' . $value->last_import_statuses->name . '</span>' : '';
            },
        ]);

        $this->addColumn([
            'index' => 'type',
            'label' => trans('ecom::app.section.import.fields.type'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
            'closure'    => true,
            'wrapper'    => function ($value) {
                return $value->types()->first()->name;

            },
        ]);





        $this->addColumn([
            'index' => 'enable',
            'label' => trans('ecom::app.section.import.fields.enable'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
            'closure'    => true,
            'wrapper'    => function ($value) {
                if ($value->enable == 1) {
                    return '<span style="color: ' . trans('region::app.default.active-status-color') . '">' . trans('region::app.default.active-status') . '</span>';
                }
                return '<span style="color: ' . trans('region::app.default.not-active-status-color') . '">' . trans('region::app.default.not-active-status') . '</span>';

            },
        ]);
    }

    public function prepareActions()
    {
        $this->addAction([
            'title' => trans('ecom::app.default.edit'),
            'method' => 'GET',
            'route' => 'admin.region.edit',
            'icon' => 'icon pencil-lg-icon',
        ]);

        $this->addAction([
            'title' => trans('ecom::app.default.delete'),
            'method' => 'POST',
            'route' => 'admin.region.delete',
            'confirm_text' => trans('region::app.messages.delete', ['resource' => 'Exchange Rate']),
            'icon' => 'icon trash-icon',
        ]);

        $this->addAction([
        'title' => trans('ecom::app.section.import.run'),
        'method' => 'GET',
        'route' => 'admin.region.edit',
        'icon' => 'icon import-icon',
    ]);
    }
}