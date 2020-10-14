<?php

namespace Webkul\Ecom\DataGrids;

use Webkul\Ecom\Repositories\EcomImportIntervalRepository;
use Webkul\Ecom\Repositories\EcomImportTypeRepository;
use Webkul\Ui\DataGrid\DataGrid;

class EcomImportIntervalsDataGrid extends DataGrid
{
    protected $index = 'id';

    protected $sortOrder = 'desc';

    /**
     * @var EcomImportIntervalRepository
     */
    protected $importIntervalRepository;

    public function __construct()
    {
        parent::__construct();

        $this->importIntervalRepository = app(EcomImportIntervalRepository::class);
    }

    public function prepareQueryBuilder()
    {
//        $queryBuilder = DB::table('regions')->addSelect('id', 'name', 'alias', 'enable');
        $imports = $this->importIntervalRepository->getIntervalsQuery();
        $this->setQueryBuilder($imports);


    }

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
            'index' => 'name',
            'label' => trans('ecom::app.section.import.fields.name'),
            'type' => 'name',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'interval',
            'label' => trans('ecom::app.section.interval.fields.interval'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
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


    }
}