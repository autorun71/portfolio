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

class RegionRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'Webkul\Region\Models\Region';
    }

    public function getEdit($id)
    {
        return $this->model::find($id);
    }

    public function getRegionByCode($code)
    {
        return $this->model::with(['channels:id,name'])->whereAlias($code)->whereEnable(1)->first();
    }

    /**
     * Метод обновляет привязку региона к свойству через канал
     * !!!!!!! ВРЕМЕННОЕ РЕШЕНИЕ, ПЕРЕДЕЛАТЬ !!!!!!!
     * @todo updateExistingPivot()
     * @param $regionId
     * @param $propsId
     * @param $channelId
     * @param $value
     * @return int
     */
    public function saveRegionWithPropsAndChannel($regionId, $propsId, $channelId, $value)
    {
        $query = 'update `regions_region_props`
            set value = "' . $value . '"
            where
                channels_id = ' . $channelId . '
                and region_props_id = ' . $propsId . '
                and region_id = ' . $regionId;
        return DB::update($query);
    }

    public function getRegions()
    {
        return $this->model::orderBy('id', 'ASC')->get();
    }

    public function getRegionsQuery()
    {
        return $this->model::orderBy('id', 'ASC');
    }

    public function getProps($regionId)
    {
        return $this->model::with(['regionProps:id,name,code'])
            ->find($regionId)
            ->regionProps
            ->sortBy('region_id');
    }

    public function getChannelsForRegion($regionId)
    {
        return $this->model::with(['channels:id'])
            ->find($regionId)
            ->channels;

        return $items;

    }


}