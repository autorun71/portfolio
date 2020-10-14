<?php

namespace Webkul\Region\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Core\Models\Channel;

class Region extends Model
{
    protected $fillable = ['name', 'alias', 'enable'];


    public function regionProps()
    {
        $result = $this->belongsToMany(RegionProps::class, 'regions_region_props')->withPivot(['value']);
//        $result = $this->hasManyThrough(RegionProps::class, 'regions_region_props')->withPivot(['value']);
        return $result;
    }

    public function channels() {
        $result = $this->belongsToMany(Channel::class, 'regions_channels');
        return $result;
    }
}
