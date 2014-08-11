<?php

namespace Karma\Controllers;

use Illuminate\Routing\Controller;

class BaseController extends Controller 
{
    protected $layout;

    public function __construct()
    {
        $this->layout = "layouts.main";
    }
    
	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if (!is_null($this->layout))
		{
			$this->layout = \View::make($this->layout);
		}
	}

}
