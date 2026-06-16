<?php

namespace App\Models\Concerns;

use App\Models\Meta;

trait HasMetaSeo
{
    public function meta()
    {
        return $this->morphOne(Meta::class, 'metaable');
    }
}
