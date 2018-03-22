<?php
declare(strict_types=1);

namespace TMCms\Modules\Faq;

use TMCms\Admin\Messages;
use TMCms\HTML\BreadCrumbs;
use TMCms\HTML\Cms\CmsForm;
use TMCms\HTML\Cms\CmsFormHelper;
use TMCms\HTML\Cms\CmsTableHelper;
use TMCms\Log\App;
use TMCms\Modules\Faq\Entity\FaqCategoryEntity;
use TMCms\Modules\Faq\Entity\FaqCategoryEntityRepository;
use TMCms\Modules\Faq\Entity\FaqEntity;
use TMCms\Modules\Faq\Entity\FaqEntityRepository;

\defined('INC') or exit;

/**
 * Class CmsFaq
 * @package TMCms\Modules\Faq
 */
class CmsFaq
{
    /** Faqs */

    public static function _default()
    {
        BreadCrumbs::getInstance()
            ->addAction('Add Faq', '?p=' . P . '&do=add')
        ;

        $faqs = new FaqEntityRepository();
        $faqs->addOrderByField();

        $categories = new FaqCategoryEntityRepository();

        echo CmsTableHelper::outputTable([
            'data' => $faqs,
            'columns' => [
                'title' => [
                    'translation' => true,
                ],
                'category_id' => [
                    'title' => 'Category',
                    'options' => $categories->getPairs('title'),
                ],
            ],
            'active' => true,
            'edit' => true,
            'orders' => true,
            'delete' => true,
        ]);
    }

    /**
     * @param int $faq_id
     *
     * @return CmsForm
     */
    private static function _faqs_add_edit_form(int $faq_id = 0): CmsForm
    {
        $categories = new FaqCategoryEntityRepository();

        $faq = new FaqEntity($faq_id);

        return CmsFormHelper::outputForm($faq->getDbTableName(), [
            'button' => 'Save',
            'data' => $faq,
            'fields' => [
                FaqEntityRepository::FIELD_CATEGORY_ID => [
                    'title' => 'Category',
                    'options' => $categories->getPairs('title'),
                ],
                FaqEntityRepository::FIELD_TITLE => [
                    'translation' => true,
                ],
                FaqEntityRepository::FIELD_TEXT => [
                    'translation' => true,
                    'type' => 'textarea',
                    'edit' => 'wysiwyg',
                ],
            ],
        ]);
    }

    public static function add()
    {
        echo self::_faqs_add_edit_form();
    }

    public static function edit()
    {
        echo self::_faqs_add_edit_form((int)$_GET['id']);
    }

    public static function _add()
    {
        $faq = new FaqEntity();
        $faq->loadDataFromArray($_POST);
        $faq->save();

        App::add('Faq '. $faq->getTitle() .' created');
        Messages::sendMessage('Faq '. $faq->getTitle() .' created');

        go('?p=' . P . '&highlight=' . $faq->getId());
    }

    public static function _edit()
    {
        $faq = new FaqEntity($_GET['id']);
        $faq->loadDataFromArray($_POST);
        $faq->save();

        App::add('Faq '. $faq->getTitle() .' updated');
        Messages::sendMessage('Faq '. $faq->getTitle() .' updated');

        go('?p=' . P . '&highlight=' . $faq->getId());
    }

    public static function _active()
    {
        $faq = new FaqEntity($_GET['id']);
        $faq->flipBoolValue('active');
        $faq->save();

        App::add('Faq '. $faq->getTitle() .' updated');
        Messages::sendGreenAlert('Faq '. $faq->getTitle() .' updated');

        if (IS_AJAX_REQUEST) {
            die('1');
        }

        back();
    }

    public function _order()
    {
        $faq = new FaqEntity($_GET['id']);
        $faq->processOrderAction();
    }

    public static function _delete()
    {
        $faq = new FaqEntity($_GET['id']);
        $faq->deleteObject();

        App::add('Faq '. $faq->getTitle() .' deleted');
        Messages::sendMessage('Faq '. $faq->getTitle() .' deleted');

        back();
    }


    /** Categories */

    public static function categories()
    {
        BreadCrumbs::getInstance()
            ->addAction('Add Category', '?p=' . P . '&do=categories_add')
        ;

        $categories = new FaqCategoryEntityRepository();

        echo CmsTableHelper::outputTable([
            'data' => $categories,
            'columns' => [
                'title' => [
                    'translation' => true,
                ],
            ],
            'active' => true,
            'edit' => true,
            'orders' => true,
            'delete' => true,
        ]);
    }

    /**
     * @param int $category_id
     *
     * @return CmsForm
     */
    private static function _categories_add_edit_form(int $category_id = 0): CmsForm
    {
        $category = new FaqCategoryEntity($category_id);

        return CmsFormHelper::outputForm([
            'table' => $category->getDbTableName(),
            'data' => $category,
            'button' => 'save',
            'fields' => [
                'title' => [
                    'translation' => true,
                ],
            ],
        ]);
    }

    public static function categories_add()
    {
        echo self::_categories_add_edit_form();
    }

    public static function categories_edit()
    {
        echo self::_categories_add_edit_form((int)$_GET['id']);
    }

    public static function _categories_add()
    {
        $category = new FaqCategoryEntity();
        $category->loadDataFromArray($_POST);
        $category->save();

        App::add('Category '. $category->getTitle() .' created');
        Messages::sendMessage('Category '. $category->getTitle() .' created');

        go('?p=' . P . '&do=categories&highlight=' . $category->getId());
    }

    public static function _categories_edit()
    {
        $category = new FaqCategoryEntity($_GET['id']);
        $category->loadDataFromArray($_POST);
        $category->save();

        App::add('Category '. $category->getTitle() .' updated');
        Messages::sendMessage('Category '. $category->getTitle() .' updated');

        go('?p=' . P . '&do=categories&highlight=' . $category->getId());
    }

    public static function _categories_delete()
    {
        $category = new FaqCategoryEntity($_GET['id']);
        $category->deleteObject();

        App::add('Category '. $category->getTitle() .' deleted');
        Messages::sendMessage('Category '. $category->getTitle() .' deleted');

        back();
    }

    /**
     *
     */
    public static function _categories_active()
    {
        $category = new FaqCategoryEntity($_GET['id']);
        $category->flipBoolValue('active');
        $category->save();

        App::add('Category '. $category->getTitle() .' updated');
        Messages::sendGreenAlert('Category '. $category->getTitle() .' updated');

        if (IS_AJAX_REQUEST) {
            die('1');
        }

        back();
    }

    public function _categories_order()
    {
        $category = new FaqCategoryEntity($_GET['id']);
        $category->processOrderAction();
    }
}
