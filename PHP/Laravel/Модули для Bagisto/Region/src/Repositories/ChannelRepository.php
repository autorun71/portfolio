<?php

namespace Webkul\Region\Repositories;


use Webkul\Core\Eloquent\Repository;
use Illuminate\Support\Facades\DB;
use Webkul\Core\Models\Channel;

class ChannelRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Channel::class;
    }

    public function getStatusPoddomain($id)
    {
        return $this->model::find($id)->poddomen_status;
    }

    public function getHosts() {
        return $this->model::select(['id', 'hostname'])->get()->toArray();
    }

}