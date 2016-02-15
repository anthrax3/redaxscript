<?php
namespace Redaxscript;

/**
 * parent class to generate a flash message
 *
 * @since 3.0.0
 *
 * @package Redaxscript
 * @category Messenger
 * @author Henry Ruhs
 * @author Balázs Szilágyi
 */

class Messenger
{
	/**
	 * array of the action
	 *
	 * @var array
	 */

	protected $_actionArray = array();

	/**
	 * options of the messenger
	 *
	 * @var array
	 */

	protected $_options = array(
		'className' => array(
			'list' => 'rs-list-messenger',
			'link' => 'rs-button-messenger',
			'redirect' => 'rs-redirect-overlay'
		)
	);

	/**
	 * stringify the messenger
	 *
	 * @since 3.0.0
	 *
	 * @return string
	 */

	public function __toString()
	{
		return $this->render();
	}

	/**
	 * set the action
	 *
	 * @since 3.0.0
	 *
	 * @param string $text text of the action
	 * @param string $route route of the action
	 */

	public function setAction($text = null, $route = null)
	{
		if (strlen($text) && strlen($route))
		{
			$this->_actionArray = array(
				'text' => $text,
				'route' => $route
			);
		}
	}

	/**
	 * success message
	 *
	 * @since 3.0.0
	 *
	 * @param mixed $message message of the success
	 * @param string $title title of the success
	 *
	 * @return string
	 */

	public function success($message = null, $title = null)
	{
		return $this->render('success', $message, $title);
	}

	/**
	 * warning message
	 *
	 * @since 3.0.0
	 *
	 * @param mixed $message message of the warning
	 * @param string $title message title of the warning
	 *
	 * @return string
	 */

	public function warning($message = null, $title = null)
	{
		return $this->render('warning', $message, $title);
	}

	/**
	 * error message
	 *
	 * @since 3.0.0
	 *
	 * @param mixed $message message of the error
	 * @param string $title title of the error
	 *
	 * @return string
	 */

	public function error($message = null, $title = null)
	{
		return $this->render('error', $message, $title);
	}

	/**
	 * info message
	 *
	 * @since 3.0.0
	 *
	 * @param mixed $message message of the info
	 * @param string $title title of the info
	 *
	 * @return string
	 */

	public function info($message = null, $title = null)
	{
		return $this->render('info', $message, $title);
	}

	/**
	 * render
	 *
	 * @since 3.0.0
	 *
	 * @param string $type type of the flash
	 * @param mixed $message message of the flash
	 * @param string $title title of the flash
	 *
	 * @return string
	 */

	public function render($type = null, $message = null, $title = null)
	{
		$output = Hook::trigger('messengerStart');
		$outputItem = null;

		/* html element */

		if ($title)
		{
			$titleElement = new Html\Element();
			$titleElement->init('h2', array(
				'class' => 'rs-title-note rs-note-' . $type
			))
			->text($title);
			$output .= $titleElement->render();
		}
		$boxElement = new Html\Element();
		$boxElement->init('div', array(
			'class' => 'rs-box-note rs-note-' . $type
		));
		if ($this->_actionArray)
		{
			$linkElement = new Html\Element();
			$linkElement->init('a', array(
				'href' => $this->_actionArray['route'],
				'class' => $this->_options['className']['link']
			))
			->text($this->_actionArray['text']);
		}

		/* build a list */

		if (is_array($message))
		{
			$itemElement = new Html\Element();
			$itemElement->init('li');
			$listElement = new Html\Element();
			$listElement->init('ul', array(
				'class' => $this->_options['className']['list']
			));

			/* collect item output */

			foreach ($message as $value)
			{
				$outputItem .= '<li>' . $value . '</li>';
			}
			$boxElement->html($listElement->html($outputItem));
		}

		/* else plain text */

		else
		{
			$boxElement->text($message);
		}

		/* collect output */

		$output .= $boxElement . $linkElement;
		$output .= Hook::trigger('messengerEnd');
		return $output;
	}

	/**
	 * meta powered redirect
	 *
	 * @since 3.0.0
	 *
	 * @param string $route route of the redirect
	 * @param integer $timeout timeout of the redirect
	 *
	 * @return string $redirect
	 */

	public function redirect($route = null, $timeout = 2)
	{
		$metaElement = new Html\Element();

		/* route fallback */

		if (!$route)
		{
			$route = $this->_actionArray['route'];
		}

		/* collect output */

		$output = $metaElement->init('meta', array(
			'class' => $timeout === 0 ? $this->_options['className']['redirect'] : null,
			'content' => $timeout . ';url=/' . Registry::get('rewriteRoute') . $route,
			'http-equiv' => 'refresh'
		));
		return $output;
	}
}