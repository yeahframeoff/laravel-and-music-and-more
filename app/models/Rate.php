<?php
/**
 * Created by PhpStorm.
 * User: Антон
 * Date: 11.09.14
 * Time: 9:23
 */

namespace Karma\Entities;


class Rate extends \Eloquent
{
    public function rater()
    {
        return $this->belongsTo('Karma\Entities\User', 'rater_id');
    }

    public function ratedObject()
    {
        return $this->morphTo('rated_object');
    }
} 