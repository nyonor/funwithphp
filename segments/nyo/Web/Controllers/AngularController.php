<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 7/19/18
 * Time: 7:48 PM
 */

namespace Segments\Nyo\Web\Controllers;


use App\Modules\Mvc\Controller\AbstractMvcController;

class AngularController extends AbstractMvcController
{
	protected function theAppAction()
	{
		return $this->view();
	}
}