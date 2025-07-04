<?php
/**
 * @package     WT JShopping Swiper carousel
 * @copyright   Copyright (C) 2022-2023 Sergey Tolkachyov. All rights reserved.
 * @author      Sergey Tolkachyov
 * @link        https://web-tolk.ru
 * @version     1.1.3
 * @license     GNU General Public License version 3 or later
 */

namespace Joomla\Module\Wtjshoppingswipercarousel\Site\Fields;

use Joomla\CMS\Form\Field\ListField;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\Component\Jshopping\Site\Helper\Helper;

defined('_JEXEC') or die;

class JshoppingcategoriesField extends ListField
{

    protected $type = 'Jshoppingcategories';

    protected function getOptions()
    {
        if (!file_exists(JPATH_SITE . '/components/com_jshopping/bootstrap.php')) {
            return [HTMLHelper::_('select.option', -1, '-- JoomShopping component is not installled --')];
        }

        require_once(JPATH_SITE . '/components/com_jshopping/bootstrap.php');

        $allcats = Helper::buildTreeCategory(0);
        $options = [];
        foreach ($allcats as $category) {
            if ($category->category_id == 0) {
                unset($category);
            } else {
                $options[] = HTMLHelper::_('select.option', $category->category_id, $category->name);
            }
        }

        return $options;
    }
}
