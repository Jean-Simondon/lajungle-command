<?php

namespace YOUR_THEME_NAME\Models;

use \WP_Query;
use YOUR_THEME_NAME\Features\Cpt\CptExample;
use Iquitheme\Core\Models\BaseModel;

class ExampleModel extends BaseModel
{
	protected $ppp = 8;
	protected $CPTClass = CptExample::class;

	public function getLatest($ppp = -1)
	{
		$args = [
			'posts_per_page'	=> $ppp,
			'orderby'			=> 'date',
			'order'				=> 'DESC',
		];
		return parent::findAll($args);
	}

	public function search($params)
	{
		$params['posts_per_page'] = $this->ppp;
		return parent::findAll([$params]);
	}

}
