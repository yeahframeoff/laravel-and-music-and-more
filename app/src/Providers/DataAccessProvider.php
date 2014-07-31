<?php

namespace Karma\Providers;

use Illuminate\Support\ServiceProvider;
 
class DataAccessProvider extends ServiceProvider 
{
 
  public function register()
  {
    $this->app->bind(
      'UserRepository',
      'EloquentUserRepository'
    );
  }
}