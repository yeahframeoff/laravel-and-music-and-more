<?php

namespace Karma\Entities;

class GroupTrack extends \Eloquent
{
    protected $table = 'group_track';
    protected $fillable = array('id', 'group_id', 'imported_track_id');
    public $timestamps = false;

    public function group()
    {
        return $this->belongsTo('Karma\Entities\Group', 'group_id');
    }
}