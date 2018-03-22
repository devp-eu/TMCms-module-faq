<?php
declare(strict_types=1);

namespace TMCms\Modules\Faq\Entity;

use TMCms\Orm\Entity;

/**
 * Class FaqEntity
 * @package TMCms\Modules\Faq\Entity
 *
 * @method int getAactive()
 * @method int getOrder()
 * @method string getText()
 * @method string getTitle()
 */
class FaqEntity extends Entity {
    protected $db_table = FaqEntityRepository::DB_TABLE_NAME;
    protected $translation_fields = [FaqEntityRepository::FIELD_TEXT, FaqEntityRepository::FIELD_TITLE];
}
