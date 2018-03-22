<?php
declare(strict_types=1);

namespace TMCms\Modules\Faq\Entity;

use TMCms\Orm\EntityRepository;
use TMCms\Orm\TableStructure;

/**
 * Class FaqEntityRepository
 * @package TMCms\Modules\Faq\Entity
 *
 * @method $this setWhereActive(int $flag)
 * @method $this setWhereCategory(FaqCategoryEntity $category)
 * @method $this setWhereCategoryId(int $category_id)
 */
class FaqEntityRepository extends EntityRepository {
    const DB_TABLE_NAME = 'm_faq';

    const FIELD_CATEGORY_ID = 'category_id';
    const FIELD_TEXT = 'text';
    const FIELD_TITLE = 'title';

    protected $db_table = self::DB_TABLE_NAME;
    protected $translation_fields = [self::FIELD_TEXT, self::FIELD_TITLE];
    protected $table_structure = [
        'fields' => [
            self::FIELD_CATEGORY_ID => [
                'type' => TableStructure::FIELD_TYPE_INDEX,
            ],
            self::FIELD_TITLE => [
                'type' => TableStructure::FIELD_TYPE_TRANSLATION,
            ],
            self::FIELD_TEXT => [
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
