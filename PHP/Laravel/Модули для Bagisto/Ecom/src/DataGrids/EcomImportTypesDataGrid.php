<?php

namespace Webkul\Ecom\DataGrids;

use Webkul\Ecom\Repositories\EcomImportTypeRepository;
use Webkul\Ui\DataGrid\DataGrid;

class EcomImportTypesDataGrid extends DataGrid
{
    protected $index = 'id';

    protected $sortOrder = 'desc';

    /**
     * @var EcomImportTypeRepository
     */
    protected $importTypeRepository;

    public function __construct()
    {
        parent::__construct();

        $this->importTypeRepository = app(EcomImportTypeRepository::class);
    }

    public function prepareQueryBuilder()
    {
//        $queryBuilder = DB::table('regions')->addSelect('id', 'name', 'alias', 'enable');
        $imports = $this->importTypeRepository->getTypesQuery();
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
            'index' => 'code',
            'label' => trans('ecom::app.section.import.fields.code'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
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


    }
}