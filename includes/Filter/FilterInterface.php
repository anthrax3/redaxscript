<?php
namespace Redaxscript\Filter;

/**
 * interface to define a filter class
 *
 * @since 2.2.0
 *
 * @package Redaxscript
 * @category Filter
 * @author Henry Ruhs
 */

interface FilterInterface
{
	/**
	 * sanitize the value
	 *
	 * @since 2.2.0
	 *
	 * @param string $value general value to sanitize
	 *
	 * @return string
	 */

	public function sanitize($value = null);
}
