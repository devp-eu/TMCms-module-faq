<?php
declare(strict_types=1);

namespace TMCms\Modules\Faq\Entity;

use TMCms\Orm\EntityRepository;
use TMCms\Orm\TableStructure;

/**
 * Class FaqCategoryEntityRepository
 * @package TMCms\Modules\Faq\Entity
 *
 * @method $this setWhereActive(int $flag)
 */
class FaqCategoryEntityRepository extends EntityRepository {
    const DB_TABLE_NAME = 'm_faq_categories';

    const FIELD_TITLE = 'title';

    protected $db_table = self::DB_TABLE_NAME;
    protected $translation_fields = [self::FIELD_TITLE];
    protected $table_structure = [
        'fields' => [
            self::FIELD_TITLE => [
                'type' => TableStructure::FIELD_TYPE_TRANSLATION,
            ],
            'order' => [
                'type' => TableStructure::FIELD_TYPE_UNSIGNED_INTEGER,
            ],
            'active' => [
                'type' => TableStructure::FIELD_TYPE_BOOL,
            ],
        ],
    ];
}
