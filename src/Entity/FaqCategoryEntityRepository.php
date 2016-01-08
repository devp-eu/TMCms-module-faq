<?php

namespace TMCms\Modules\Faq\Entity;

use TMCms\Orm\EntityRepository;

class FaqCategoryEntityRepository extends EntityRepository {
    protected $db_table = 'm_faq_categories';
    protected $translation_fields = ['title'];
    protected $table_structure = [
        'fields' => [
            'title' => [
                'type' => 'translation',
            ],
        ],
    ];
}