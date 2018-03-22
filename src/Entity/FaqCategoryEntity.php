<?php
declare(strict_types=1);

namespace TMCms\Modules\Faq\Entity;

use TMCms\Orm\Entity;

/**
 * Class FaqCategoryEntity
 * @package TMCms\Modules\Faq\Entity
 *
 * @method int getActive()
 * @method int getOrder()
 * @method string getTitle()
 */
class FaqCategoryEntity extends Entity {
    protected $db_table = FaqCategoryEntityRepository::DB_TABLE_NAME;
    protected $translation_fields = [FaqCategoryEntityRepository::FIELD_TITLE];
}
