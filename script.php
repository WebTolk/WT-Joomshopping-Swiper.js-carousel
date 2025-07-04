<?php

/**
 * @package    WT JShopping Swiper carousel
 * @version       1.1.3
 * @Author        Sergey Tolkachyov, https://web-tolk.ru
 * @copyright     Copyright (C) 2023 Sergey Tolkachyov
 * @license       GNU/GPL http://www.gnu.org/licenses/gpl-3.0.html
 * @since         1.0.0
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Application\AdministratorApplication;
use Joomla\CMS\Factory;
use Joomla\CMS\Installer\InstallerAdapter;
use Joomla\CMS\Installer\InstallerScriptInterface;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Version;
use Joomla\Database\DatabaseDriver;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;

return new class () implements ServiceProviderInterface {
	public function register(Container $container)
	{
		$container->set(InstallerScriptInterface::class, new class ($container->get(AdministratorApplication::class)) implements InstallerScriptInterface {
			/**
			 * The application object
			 *
			 * @var  AdministratorApplication
			 *
			 * @since  1.0.0
			 */
			protected AdministratorApplication $app;

			/**
			 * The Database object.
			 *
			 * @var   DatabaseDriver
			 *
			 * @since  1.0.0
			 */
			protected DatabaseDriver $db;

			/**
			 * Minimum Joomla version required to install the extension.
			 *
			 * @var  string
			 *
			 * @since  1.0.0
			 */
			protected string $minimumJoomla = '4.1';

			/**
			 * Minimum PHP version required to install the extension.
			 *
			 * @var  string
			 *
			 * @since  1.0.0
			 */
			protected string $minimumPhp = '7.4';

			/**
			 * Constructor.
			 *
			 * @param   AdministratorApplication  $app  The application object.
			 *
			 * @since 1.0.0
			 */
			public function __construct(AdministratorApplication $app)
			{
				$this->app = $app;
				$this->db  = Factory::getContainer()->get('DatabaseDriver');
			}

			/**
			 * Function called after the extension is installed.
			 *
			 * @param   InstallerAdapter  $adapter  The adapter calling this method
			 *
			 * @return  boolean  True on success
			 *
			 * @since   1.0.0
			 */
			public function install(InstallerAdapter $adapter): bool
			{

				return true;
			}

			/**
			 * Function called after the extension is updated.
			 *
			 * @param   InstallerAdapter  $adapter  The adapter calling this method
			 *
			 * @return  boolean  True on success
			 *
			 * @since   1.0.0
			 */
			public function update(InstallerAdapter $adapter): bool
			{
				return true;
			}

			/**
			 * Function called after the extension is uninstalled.
			 *
			 * @param   InstallerAdapter  $adapter  The adapter calling this method
			 *
			 * @return  boolean  True on success
			 *
			 * @since   1.0.0
			 */
			public function uninstall(InstallerAdapter $adapter): bool
			{

				return true;
			}

			/**
			 * Function called before extension installation/update/removal procedure commences.
			 *
			 * @param   string            $type     The type of change (install or discover_install, update, uninstall)
			 * @param   InstallerAdapter  $adapter  The adapter calling this method
			 *
			 * @return  boolean  True on success
			 *
			 * @since   1.0.0
			 */
			public function preflight(string $type, InstallerAdapter $adapter): bool
			{
				return true;
			}

			/**
			 * Function called after extension installation/update/removal procedure commences.
			 *
			 * @param   string            $type     The type of change (install or discover_install, update, uninstall)
			 * @param   InstallerAdapter  $adapter  The adapter calling this method
			 *
			 * @return  boolean  True on success
			 *
			 * @since   1.0.0
			 */
			public function postflight(string $type, InstallerAdapter $adapter): bool
			{
				$smile = '';

				if ($type !== 'uninstall')
				{
					if ($type != 'uninstall')
					{
						$smiles    = ['&#9786;', '&#128512;', '&#128521;', '&#128525;', '&#128526;', '&#128522;', '&#128591;'];
						$smile_key = array_rand($smiles, 1);
						$smile     = $smiles[$smile_key];
					}
				}
				else
				{
					$smile = ':(';
				}

				$element = strtoupper($adapter->getElement());
				$type    = strtoupper($type);

				$html = '
				<div class="row m-0">
				<div class="col-12 col-md-8 p-0 pe-2">
				<h2>' . $smile . ' ' . Text::_($element . '_AFTER_' . $type) . ' <br/>' . Text::_($element) . '</h2>
				' . Text::_($element . '_DESC');

				$html .= Text::_($element . '_WHATS_NEW');

				$html .= '</div>
				<div class="col-12 col-md-4 p-0 d-flex flex-column justify-content-start">
				<img width="180" src="https://web-tolk.ru/web_tolk_logo_wide.png">
				<p>Joomla Extensions</p>
				<p class="btn-group">
					<a class="btn btn-sm btn-outline-primary" href="https://web-tolk.ru" target="_blank"> https://web-tolk.ru</a>
					<a class="btn btn-sm btn-outline-primary" href="mailto:info@web-tolk.ru"><i class="icon-envelope"></i> info@web-tolk.ru</a>
				</p>
				<div class="btn-group-vertical mb-3 web-tolk-btn-links" role="group" aria-label="Joomla community links">
				<a class="btn btn-danger text-white w-100" href="https://t.me/joomlaru" target="_blank">' . Text::_($element . '_JOOMLARU_TELEGRAM_CHAT') . '</a>
				<a class="btn btn-primary text-white w-100" href="https://t.me/webtolkru" target="_blank">' . Text::_($element . '_WEBTOLK_TELEGRAM_CHANNEL') . '</a>
				</div>
				' . Text::_($element . "_MAYBE_INTERESTING") . '
				</div>

				';
				$this->app->enqueueMessage($html, 'info');

				return  true;
			}

			/**
			 * Method to check compatible.
			 *
			 * @return  boolean True on success, False on failure.
			 *
			 * @throws  Exception
			 *
			 * @since  1.1.2
			 */
			protected function checkCompatible(string $element): bool
			{
				$element = strtoupper($element);
				// Check joomla version
				if (!(new Version)->isCompatible($this->minimumJoomla))
				{
					$this->app->enqueueMessage(
						Text::sprintf($element . '_ERROR_COMPATIBLE_JOOMLA', $this->minimumJoomla),
						'error'
					);

					return false;
				}

				// Check PHP
				if (!(version_compare(PHP_VERSION, $this->minimumPhp) >= 0))
				{
					$this->app->enqueueMessage(
						Text::sprintf($element . '_ERROR_COMPATIBLE_PHP', $this->minimumPhp),
						'error'
					);

					return false;
				}

				return true;
			}

		});
	}
};