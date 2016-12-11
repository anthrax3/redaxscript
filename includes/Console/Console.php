<?php
namespace Redaxscript\Console;

/**
 * parent class to handle the command line interface
 *
 * @since 3.0.0
 *
 * @package Redaxscript
 * @category Console
 * @author Henry Ruhs
 */

class Console extends ConsoleAbstract
{
	/**
	 * init the class
	 *
	 * @since 3.0.0
	 *
	 * @param string $mode name of the mode
	 *
	 * @return mixed
	 */

	public function init($mode = null)
	{
		$parser = new Parser($this->_request);
		$parser->init($mode);

		/* run command */

		$commandKey = $parser->getArgument(0);
		$commandClass = $this->_namespaceArray[$commandKey];
		if (array_key_exists($commandKey, $this->_namespaceArray) && class_exists($commandClass))
		{
			$command = new $commandClass($this->_registry, $this->_request, $this->_config);
			return $command->run($mode);
		}
		return false;
	}
}
