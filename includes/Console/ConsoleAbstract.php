<?php
namespace Redaxscript\Console;

use Redaxscript\Config;
use Redaxscript\Registry;
use Redaxscript\Request;

/**
 * abstract class to handle the command line interface
 *
 * @since 3.0.0
 *
 * @package Redaxscript
 * @category Console
 * @author Henry Ruhs
 */

abstract class ConsoleAbstract
{
	/**
	 * instance of the registry class
	 *
	 * @var object
	 */

	protected $_registry;

	/**
	 * instance of the request class
	 *
	 * @var object
	 */

	protected $_request;

	/**
	 * instance of the config class
	 *
	 * @var object
	 */

	protected $_config;

	/**
	 * array of namespaces
	 *
	 * @var string
	 */

	protected $_namespaceArray =
	[
		'backup' => 'Redaxscript\Console\Command\Backup',
		'cache' => 'Redaxscript\Console\Command\Cache',
		'config' => 'Redaxscript\Console\Command\Config',
		'help' => 'Redaxscript\Console\Command\Help',
		'install' => 'Redaxscript\Console\Command\Install',
		'restore' => 'Redaxscript\Console\Command\Restore',
		'setting' => 'Redaxscript\Console\Command\Setting',
		'status' => 'Redaxscript\Console\Command\Status',
		'uninstall' => 'Redaxscript\Console\Command\Uninstall'
	];

	/**
	 * constructor of the class
	 *
	 * @since 3.0.0
	 *
	 * @param Registry $registry instance of the registry class
	 * @param Request $request instance of the request class
	 * @param Config $config instance of the config class
	 */

	public function __construct(Registry $registry, Request $request, Config $config)
	{
		$this->_registry = $registry;
		$this->_request = $request;
		$this->_config = $config;
	}
}