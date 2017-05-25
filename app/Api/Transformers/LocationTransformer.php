<?php
/**
 * Created by PhpStorm.
 * User: Andrew K.
 * Date: 25.05.17
 * Time: 14:12
 */

namespace App\Api\Transformers;

use League\Fractal\TransformerAbstract;
use App\Api\Models\Location;

class LocationTransformer extends TransformerAbstract
{
    public function transform(Location $location)
    {
        return [
            'id' => $location->id,
            'title' => $location->title
        ];
    }
}

