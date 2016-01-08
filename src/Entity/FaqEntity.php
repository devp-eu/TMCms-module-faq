<?php

namespace TMCms\Modules\Faq\Entity;

use TMCms\Orm\Entity;

/**
 * Class FaqEntity
 * @package TMCms\Modules\Faq\Entity
 *
 * @method string getText()
 * @method string getTitle()
 */
class FaqEntity extends Entity {
    protected $db_table = 'm_faq';
    protected $translation_fields = ['title', 'text'];
}