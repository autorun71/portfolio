<?php

namespace Webkul\Region\DataGrids;

use Webkul\Region\Repositories\RegionPropsRepository;
use Webkul\Ui\DataGrid\DataGrid;

class RegionPropsDataGrid extends DataGrid
{
    protected $index = 'id';

    protected $sortOrder = 'desc';

    protected $regionPropsRepository;

    public function __construct()
    {
        parent::__construct();

        $this->regionPropsRepository = app(RegionPropsRepository::class);
    }

    public function prepareQueryBuilder()
    {
//        $queryBuilder = DB::table('regions')->addSelect('id', 'name', 'alias', 'enable');
        $props = $this->regionPropsRepository->getPropsQuery();

        $this->setQueryBuilder($props);


    }

    public function addColumns()
    {
        $this->addColumn([
            'index' => 'id',
            'label' => trans('region::app.section.props.fields.id'),
            'type' => 'number',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'name',
            'label' => trans('region::app.section.props.fields.name'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'sort',
            'label' => trans('region::app.section.props.fields.sort'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'code',
            'label' => trans('region::app.section.props.fields.code'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);



        $this->addColumn([
            'index' => 'template',
            'label' => trans('region::app.section.props.fields.template'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
            'closure'    => true,
            'wrapper'    => fn ($value) =>  '<span style="
                                                    background: rgb(247, 247, 247);
                                                    padding: 5px;
                                                    border: 1px solid #bfbfbf;
                                                    font-weight: bold;">#' . $value->code . '#</span>',
        ]);

        $this->addColumn([
            'index' => 'placeholder',
            'label' => trans('region::app.section.props.fields.placeholder'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'enable',
            'label' => trans('region::app.section.props.fields.enable'),
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
            'title' => trans('region::app.section.props.edit'),
            'method' => 'GET',
            'route' => 'admin.region.props.edit',
            'icon' => 'icon pencil-lg-icon',
        ]);

        $this->addAction([
            'title' => trans('region::app.section.props.delete'),
            'method' => 'POST',
            'route' => 'admin.region.props.delete',
            'confirm_text' => trans('region::app.messages.delete', ['resource' => 'Exchange Rate']),
            'icon' => 'icon trash-icon',
        ]);
    }
}