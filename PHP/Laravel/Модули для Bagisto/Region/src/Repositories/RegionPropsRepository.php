<?php

namespace Webkul\Region\Repositories;

use Illuminate\Container\Container as App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Event;
use Webkul\Core\Eloquent\Repository;
use Webkul\Category\Models\Category;
use Webkul\Category\Models\CategoryTranslation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class RegionPropsRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    private $selectDefault = ['id', 'name', 'code', 'enable', 'sort'];

    public function model()
    {
        return 'Webkul\Region\Models\RegionProps';
    }

    public function getEdit($id)
    {
        return $this->model::find($id);
    }

    public function getProps()
    {
        return $this->model::select($this->selectDefault)->orderBy('id', 'ASC')->get();
    }

    public function getPropsQuery()
    {
        return $this->model::select($this->selectDefault)->orderBy('id', 'ASC');
    }

    public function getPropsWithValueForRegion($regionId)
    {
        $result = $this
            ->getPropsQuery()->with([
                'regions' => function ($query) use ($regionId) {
                    $query->select(['id'])->whereId($regionId);
                },
            ])
            ->whereEnable(1)
            ->get();
        $items = [];
        foreach ($result as $item){
            $item->value = !empty($item->regions->first()->pivot) ? $item->regions->first()->pivot->value : false;
            $items[] = $item;
        }

        return $items;

    }

    public function getPropsWithValueForRegionAndChannel($regionId, $channelId = 1)
    {
        $result = $this
            ->getPropsQuery()->with([
                'regions' => function ($query) use ($regionId, $channelId) {
                    $query->select(['id'])
                        ->whereId($regionId)
                        ->where('regions_region_props.channels_id', $channelId);
                },
            ])
            ->whereEnable(1)
            ->get();
        $items = [];
        foreach ($result as $item){
            $item->value = !empty($item->regions->first()->pivot) ? $item->regions->first()->pivot->value : false;
            $item->channel = !empty($item->regions->first()->pivot) ? $item->regions->first()->pivot->channel_id : false;
            $items[] = $item;
        }

        return $items;

    }



}