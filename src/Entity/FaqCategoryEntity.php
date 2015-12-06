<?php

namespace TMCms\Modules\Faq\Entity;

use neTpyceB\TMCms\Orm\Entity;

/**
 * Class FaqCategoryEntity
 * @package TMCms\Modules\Faq\Entity
 *
 * @method string getTitle()
 */
class FaqCategoryEntity extends Entity {
    protected $db_table = 'm_faq_categories';
    protected $translation_fields = ['title'];
}