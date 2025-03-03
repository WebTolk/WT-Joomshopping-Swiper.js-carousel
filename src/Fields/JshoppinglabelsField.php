<?php
/**
 * @package     WT JShopping Swiper carousel
 * @copyright   Copyright (C) 2022-2023 Sergey Tolkachyov. All rights reserved.
 * @author      Sergey Tolkachyov
 * @link        https://web-tolk.ru
 * @version     1.1.2
 * @license     GNU General Public License version 3 or later
 */

namespace Joomla\Module\Wtjshoppingswipercarousel\Site\Fields;

use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Form\Field\ListField;
use JSFactory;

defined('_JEXEC') or die;

FormHelper::loadFieldClass('list');

class JshoppinglabelsField extends ListField
{

	protected $type = 'jshoppinglabels';

	protected function getOptions()
	{


		if (!class_exists('JSHelper') && file_exists(JPATH_SITE . '/components/com_jshopping/bootstrap.php'))
		{
			require_once(JPATH_SITE . '/components/com_jshopping/bootstrap.php');
		}
		elseif (!file_exists(JPATH_SITE . '/components/com_jshopping/bootstrap.php'))
		{
			return '-- JoomShopping component is not installled --';
		}

		$labels    = JSFactory::getModel("Productlabels");
		$alllabels = $labels->getList();

		$options = [];
		foreach ($alllabels as $label)
		{
			$options[] = HTMLHelper::_('select.option', $label->id, $label->name);
		}

		return $options;
	}
}
