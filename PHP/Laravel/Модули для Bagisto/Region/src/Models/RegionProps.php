<?php

namespace Webkul\Region\Models;

use Illuminate\Database\Eloquent\Model;

class RegionProps extends Model
{
    protected $fillable = ['name', 'code', 'enable', 'placeholder', 'sort'];

    public function regions()
    {
        $result = $this->belongsToMany(Region::class, 'regions_region_props')->withPivot(['value']);
        return $result;
    }
}
