<?php

namespace TMCms\Modules\Faq\Entity;

use neTpyceB\TMCms\Orm\EntityRepository;

/**
 * Class FaqEntityRepository
 * @package TMCms\Modules\Faq\Entity
 *
 * @method $this setWhereCategory(FaqCategoryEntity $category)
 * @method $this setWhereCategoryId(int $category_id)
 */
class FaqEntityRepository extends EntityRepository {
    protected $db_table = 'm_faq';
    protected $translation_fields = ['title', 'text'];
}