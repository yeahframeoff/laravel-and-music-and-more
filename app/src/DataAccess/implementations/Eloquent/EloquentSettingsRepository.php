<?php

namespace Karma\DataAccess;

class EloquentSettingsRepository implements SettingsRepository
{
    public function find($id)
    {
        return Setting::find($id);
    }
    
    public function all()
    {
        return Setting::all();
    }
    
    public function create()
    {
        return new Setting;
    }
}