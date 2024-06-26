<?php

namespace Modules\Slider\Entities;

use Modules\Admin\Ui\AdminTable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Modules\Media\Eloquent\HasMedia;
use Modules\Support\Eloquent\Translatable;

class MobileSlider extends Model
{
    use HasMedia;

    /**
     * Get product's additional images.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getImagesAttribute()
    {
        return $this->files->where('pivot.zone', 'images')->sortBy('pivot.id');
    }

    
}
