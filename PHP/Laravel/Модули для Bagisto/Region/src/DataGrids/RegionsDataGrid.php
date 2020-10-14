<?php

namespace Webkul\Region\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\Region\Repositories\RegionRepository;
use Webkul\Ui\DataGrid\DataGrid;

class RegionsDataGrid extends DataGrid
{
    protected $index = 'id';

    protected $sortOrder = 'desc';

    protected $regionRepository;

    public function __construct()
    {
        parent::__construct();

        $this->regionRepository = app(RegionRepository::class);
    }

    public function prepareQueryBuilder()
    {
//        $queryBuilder = DB::table('regions')->addSelect('id', 'name', 'alias', 'enable');
        $regions = $this->regionRepository->getRegionsQuery();
        $this->setQueryBuilder($regions);


    }

    public function addColumns()
    {
        $this->addColumn([
            'index' => 'id',
            'label' => trans('region::app.section.main.fields.id'),
            'type' => 'number',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'name',
            'label' => trans('region::app.section.main.fields.name'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'alias',
            'label' => trans('region::app.section.main.fields.alias'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'enable',
            'label' => trans('region::app.section.main.fields.enable'),
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
            'title' => trans('region::app.section.main.edit'),
            'method' => 'GET',
            'route' => 'admin.region.edit',
            'icon' => 'icon pencil-lg-icon',
        ]);

        $this->addAction([
            'title' => trans('region::app.section.main.delete'),
            'method' => 'POST',
            'route' => 'admin.region.delete',
            'confirm_text' => trans('region::app.messages.delete', ['resource' => 'Exchange Rate']),
            'icon' => 'icon trash-icon',
        ]);
    }
}