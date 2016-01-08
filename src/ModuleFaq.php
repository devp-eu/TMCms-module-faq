<?php

namespace TMCms\Modules\Faq;

use TMCms\Modules\IModule;
use TMCms\Traits\singletonInstanceTrait;
use TMCms\Modules\Faq\Entity\FaqCategoryEntityRepository;
use TMCms\Modules\Faq\Entity\FaqEntityRepository;

defined('INC') or exit;

class ModuleFaq implements IModule {
	use singletonInstanceTrait;

	public static $tables = array(
		'faq' => 'm_faq',
		'categories' => 'm_faq_categories',
	);

	/**
	 * @return array
	 */
	public static function getCategoryPairs() {
		$categories = new FaqCategoryEntityRepository();
		return $categories->getPairs('title');
	}

	/**
	 * @param int $category_id
	 * @return array
	 */
	public static function getFaqByCategoryId($category_id) {
		$faqs = new FaqEntityRepository();
		$faqs->setWhereCategoryId($category_id);
		return $faqs->getAsArrayOfObjects();
	}
}