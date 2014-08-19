<?php

namespace Karma\Entities;

use \DB;

class ImportedTrack extends \Eloquent
{
    protected $table = 'imported_tracks';
    protected $fillable = array('id', 'social_id', 'track_id', 'track_url');
    public $timestamps = false;
    
    public function track()
    {
        return $this->hasOne('Karma\Entities\Track', 'id', 'track_id');
    }
    
    public function connectWithUser($id)
    {
        DB::table('imported_track_user')->insert(array(
            'user_id' => $id,
            'imported_track_id' => $this->id
        ));
    }
}