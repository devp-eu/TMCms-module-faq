<?php

namespace TMCms\Modules\Faq;

use TMCms\Admin\Menu;
use TMCms\Admin\Messages;
use TMCms\HTML\Cms\CmsFormHelper;
use TMCms\HTML\Cms\CmsTable;
use TMCms\HTML\Cms\Column\ColumnData;
use TMCms\HTML\Cms\Column\ColumnDelete;
use TMCms\HTML\Cms\Column\ColumnEdit;
use TMCms\HTML\Cms\Columns;
use TMCms\HTML\Cms\Element\CmsButton;
use TMCms\Log\App;
use TMCms\Modules\Faq\Entity\FaqCategoryEntityRepository;
use TMCms\Modules\Faq\Entity\FaqCategoryEntity;
use TMCms\Modules\Faq\Entity\FaqEntity;
use TMCms\Modules\Faq\Entity\FaqEntityRepository;

defined('INC') or exit;

Menu::getInstance()->addSubMenuItem('categories');

class CmsFaq
{
    /** Faqs */

    public static function _default()
    {
        echo Columns::getInstance()
            ->add('<a class="btn btn-success" href="?p=' . P . '&do=add">Add new Faq</a>', ['align' => 'right'])
        ;

        echo '<br>';

        $faqs = new FaqEntityRepository();
        $faqs->addOrderByField('id');

        $categories = new FaqCategoryEntityRepository();

        echo CmsTable::getInstance()
            ->addData($faqs)
            ->addColumn(ColumnEdit::getInstance('title')
                ->setHref('?p=' . P . '&do=edit&id={%id%}')
                ->enableOrderableColumn()
                ->enableTranslationColumn()
            )
            ->addColumn(ColumnData::getInstance('category_id')
                ->enableOrderableColumn()
                ->setPairedDataOptionsForKeys($categories->getPairs('title'))
                ->setTitle('Category')
            )
            ->addColumn(ColumnDelete::getInstance()
                ->setHref('?p=' . P . '&do=_delete&id={%id%}')
            )
        ;
    }

    private static function __faqs_add_edit_form($data = NULL)
    {
        $categories = new FaqCategoryEntityRepository();

        return CmsFormHelper::outputForm(ModuleFaq::$tables['faq'], [
            'action' => '?p='. P .'&do=_add',
            'button' => 'Add',
            'data' => $data,
            'fields' => [
                'category_id' => [
                    'title' => 'Category',
                    'options' => $categories->getPairs('title'),
                ],
                'title' => [
                    'translation' => true,
                ],
                'text' => [
                    'translation' => true,
                    'type' => 'textarea',
                    'edit' => 'wysiwyg',
                ],
            ],
        ]);
    }

    public static function add()
    {
        echo self::__faqs_add_edit_form();
    }

    public static function edit()
    {
        if (!isset($_GET['id']) || !ctype_digit((string)$_GET['id'])) return;
        $id = $_GET['id'];

        $faq = new FaqEntity($id);

        echo self::__faqs_add_edit_form($faq)
            ->setAction('?p=' . P . '&do=_edit&id=' . $id)
            ->setSubmitButton(new CmsButton('Update'));
    }

    public static function _add()
    {
        $faq = new FaqEntity();
        $faq->loadDataFromArray($_POST);
        $faq->save();

        App::add('Faq '. $faq->getTitle() .' created');

        Messages::sendMessage('Faq created');

        go('?p=' . P . '&highlight=' . $faq->getId());
    }

    public static function _edit()
    {
        if (!isset($_GET['id']) || !ctype_digit((string)$_GET['id'])) return;
        $id = $_GET['id'];

        $faq = new FaqEntity($id);
        $faq->loadDataFromArray($_POST);
        $faq->save();

        App::add('Faq '. $faq->getTitle() .' updated');

        Messages::sendMessage('Faq updated');

        go('?p=' . P . '&highlight=' . $id);
    }

    public static function _delete()
    {
        if (!isset($_GET['id']) || !ctype_digit((string)$_GET['id'])) return;
        $id = $_GET['id'];

        $faq = new FaqEntity($id);
        $faq->deleteObject();

        App::add('Faq '. $faq->getTitle() .' deleted');

        Messages::sendMessage('Faq deleted');

        back();
    }



    /** Categories */

    public static function categories()
    {
        $categories = new FaqCategoryEntityRepository();
        $categories->addOrderByField('id');

        echo Columns::getInstance()
            ->add('<a class="btn btn-success" href="?p=' . P . '&do=categories_add">Add Category</a>', ['align' => 'right'])
        ;

        echo '<br>';

        echo CmsTable::getInstance()
            ->addData($categories)
            ->addColumn(ColumnEdit::getInstance('title')
                ->setHref('?p=' . P . '&do=categories_edit&id={%id%}')
                ->enableOrderableColumn()
                ->enableTranslationColumn()
            )
            ->addColumn(ColumnDelete::getInstance()
                ->setHref('?p=' . P . '&do=_categories_delete&id={%id%}')
            )
        ;
    }

    private static function __categories_add_edit_form($data = NULL)
    {
        return CmsFormHelper::outputForm(ModuleFaq::$tables['categories'], [
            'action' => '?p='. P .'&do=_categories_add',
            'button' => 'Add',
            'data' => $data,
            'fields' => [
                'title' => [
                    'translation' => true,
                ],
            ],
        ]);
    }

    public static function categories_add()
    {
        echo self::__categories_add_edit_form();
    }

    public static function categories_edit()
    {
        if (!isset($_GET['id']) || !ctype_digit((string)$_GET['id'])) return;
        $id = $_GET['id'];

        $category = new FaqCategoryEntity($id);

        echo self::__categories_add_edit_form($category)
            ->setAction('?p=' . P . '&do=_categories_edit&id=' . $id)
            ->setSubmitButton(new CmsButton('Update'))
        ;
    }

    public static function _categories_add()
    {
        $category = new FaqCategoryEntity();
        $category->loadDataFromArray($_POST);
        $category->save();

        App::add('Category '. $category->getTitle() .' created');

        Messages::sendMessage('Category created');

        go('?p=' . P . '&do=categories&highlight=' . $category->getId());
    }

    public static function _categories_edit()
    {
        if (!isset($_GET['id']) || !ctype_digit((string)$_GET['id'])) return;
        $id = $_GET['id'];

        $category = new FaqCategoryEntity($id);
        $category->loadDataFromArray($_POST);
        $category->save();

        App::add('Category '. $category->getTitle() .' updated');

        Messages::sendMessage('Category updated');

        go('?p=' . P . '&do=categories&highlight=' . $id);
    }

    public static function _categories_delete()
    {
        if (!isset($_GET['id']) || !ctype_digit((string)$_GET['id'])) return;
        $id = $_GET['id'];

        $category = new FaqCategoryEntity($id);
        $category->deleteObject();

        App::add('Category '. $category->getTitle() .' deleted');

        Messages::sendMessage('Category deleted');

        back();
    }
}