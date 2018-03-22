<?php
declare(strict_types=1);

namespace TMCms\Modules\Faq;

use TMCms\Modules\Faq\Entity\FaqEntityRepository;
use TMCms\Modules\IModule;
use TMCms\Traits\singletonInstanceTrait;

\defined('INC') or exit;

/**
 * Class ModuleFaq
 * @package TMCms\Modules\Faq
 */
class ModuleFaq implements IModule {
    use singletonInstanceTrait;

    /**
     * @param array $params
     *
     * @return FaqEntityRepository
     */
    public static function getFaqs(array $params = []): FaqEntityRepository
    {
        $faqs = new FaqEntityRepository();

        if (isset($params[FaqEntityRepository::FIELD_CATEGORY_ID])){
            $faqs->setWhereCategoryId($params[FaqEntityRepository::FIELD_CATEGORY_ID]);
        }

        if (isset($params['active'])){
            $faqs->setWhereActive($params['active']);
        }

        $faqs->addOrderByField();

        return $faqs;
    }
}
