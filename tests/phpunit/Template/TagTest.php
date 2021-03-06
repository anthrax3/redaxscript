<?php
namespace Redaxscript\Tests\Template;

use Redaxscript\Template;
use Redaxscript\Tests\TestCaseAbstract;
use org\bovigo\vfs\vfsStream as Stream;
use org\bovigo\vfs\vfsStreamFile as StreamFile;
use org\bovigo\vfs\vfsStreamWrapper as StreamWrapper;

/**
 * TagTest
 *
 * @since 2.3.0
 *
 * @package Redaxscript
 * @category Tests
 * @author Henry Ruhs
 */

class TagTest extends TestCaseAbstract
{
	/**
	 * setUp
	 *
	 * @since 3.1.0
	 */

	public function setUp()
	{
		parent::setUp();
		$optionArray =
		[
			'adminName' => 'Test',
			'adminUser' => 'test',
			'adminPassword' => 'test',
			'adminEmail' => 'test@test.com'
		];
		$installer = $this->installerFactory();
		$installer->init();
		$installer->rawCreate();
		$installer->insertCategories($optionArray);
		$installer->insertArticles($optionArray);
		$installer->insertComments($optionArray);
		$installer->insertSettings($optionArray);
	}

	/**
	 * tearDown
	 *
	 * @since 3.1.0
	 */

	public function tearDown()
	{
		$installer = $this->installerFactory();
		$installer->init();
		$installer->rawDrop();
	}

	/**
	 * testBase
	 *
	 * @since 3.0.0
	 */

	public function testBase()
	{
		/* actual */

		$actual = Template\Tag::base();

		/* compare */

		$this->assertString($actual);
	}

	/**
	 * testTitle
	 *
	 * @since 3.0.0
	 */

	public function testTitle()
	{
		/* actual */

		$actual = Template\Tag::title('test');

		/* compare */

		$this->assertString($actual);
	}

	/**
	 * testLink
	 *
	 * @since 3.0.0
	 */

	public function testLink()
	{
		/* actual */

		$actual = Template\Tag::link();

		/* compare */

		$this->assertInstanceOf('Redaxscript\Head\Link', $actual);
	}

	/**
	 * testMeta
	 *
	 * @since 3.0.0
	 */

	public function testMeta()
	{
		/* actual */

		$actual = Template\Tag::meta();

		/* compare */

		$this->assertInstanceOf('Redaxscript\Head\Meta', $actual);
	}

	/**
	 * testScript
	 *
	 * @since 3.0.0
	 */

	public function testScript()
	{
		/* actual */

		$actual = Template\Tag::script();

		/* compare */

		$this->assertInstanceOf('Redaxscript\Head\Script', $actual);
	}

	/**
	 * testStyle
	 *
	 * @since 3.0.0
	 */

	public function testStyle()
	{
		/* actual */

		$actual = Template\Tag::style();

		/* compare */

		$this->assertInstanceOf('Redaxscript\Head\Style', $actual);
	}

	/**
	 * testBreadcrumb
	 *
	 * @since 2.3.0
	 */

	public function testBreadcrumb()
	{
		/* actual */

		$actual = Template\Tag::breadcrumb();

		/* compare */

		$this->assertString($actual);
	}

	/**
	 * testConsoleLine
	 *
	 * @since 3.0.0
	 */

	public function testConsoleLine()
	{
		/* setup */

		$this->_request->setPost('argv', 'help');

		/* actual */

		$actual = Template\Tag::consoleLine();

		/* compare */

		$this->assertString($actual);
	}

	/**
	 * testConsoleLineInvalid
	 *
	 * @since 3.0.0
	 */

	public function testConsoleLineInvalid()
	{
		/* setup */

		$this->_request->setPost('argv', 'invalidCommand');

		/* actual */

		$actual = Template\Tag::consoleLine();

		/* compare */

		$this->assertFalse($actual);
	}

	/**
	 * testConsoleForm
	 *
	 * @since 3.0.0
	 */

	public function testConsoleForm()
	{
		/* actual */

		$actual = Template\Tag::consoleForm();

		/* compare */

		$this->assertString($actual);
	}

	/**
	 * testSearchForm
	 *
	 * @since 3.0.0
	 */

	public function testSearchForm()
	{
		/* actual */

		$actual = Template\Tag::searchForm();

		/* compare */

		$this->assertString($actual);
	}

	/**
	 * testPartial
	 *
	 * @since 2.3.0
	 */

	public function testPartial()
	{
		/* setup */

		Stream::setup('root');
		$file = new StreamFile('partial.phtml');
		StreamWrapper::getRoot()->addChild($file);

		/* actual */

		$actual = Template\Tag::partial(Stream::url('root/partial.phtml'));

		/* compare */

		$this->assertString($actual);
	}

	/**
	 * testGetRegistry
	 *
	 * @since 2.6.0
	 */

	public function testGetRegistry()
	{
		/* setup */

		$this->_registry->set('testKey', 'testValue');

		/* actual */

		$actual = Template\Tag::getRegistry('testKey');

		/* compare */

		$this->assertEquals('testValue', $actual);
	}

	/**
	 * testGetLanguage
	 *
	 * @since 2.6.0
	 */

	public function testGetLanguage()
	{
		/* setup */

		$this->_language->set('testKey', 'testValue');

		/* actual */

		$actual = Template\Tag::getLanguage('testKey');

		/* compare */

		$this->assertEquals('testValue', $actual);
	}

	/**
	 * testGetSetting
	 *
	 * @since 2.6.0
	 */

	public function testGetSetting()
	{
		/* actual */

		$actual = Template\Tag::getSetting('charset');

		/* compare */

		$this->assertEquals('utf-8', $actual);
	}

	/**
	 * testCategoryRaw
	 *
	 * @since 3.0.0
	 */

	public function testCategoryRaw()
	{
		/* actual */

		$actual = Template\Tag::categoryRaw();

		/* compare */

		$this->assertInstanceOf('Redaxscript\Db', $actual);
	}

	/**
	 * testArticleRaw
	 *
	 * @since 3.0.0
	 */

	public function testArticleRaw()
	{
		/* actual */

		$actual = Template\Tag::articleRaw();

		/* compare */

		$this->assertInstanceOf('Redaxscript\Db', $actual);
	}

	/**
	 * testExtraRaw
	 *
	 * @since 3.0.0
	 */

	public function testExtraRaw()
	{
		/* actual */

		$actual = Template\Tag::extraRaw();

		/* compare */

		$this->assertInstanceOf('Redaxscript\Db', $actual);
	}

	/**
	 * testNavigationCategories
	 *
	 * @since 3.3.1
	 */

	public function testNavigationCategories()
	{
		/* actual */

		$actual = Template\Tag::navigation('categories');

		/* compare */

		$this->assertInstanceOf('Redaxscript\Navigation\Category', $actual);
	}

	/**
	 * testNavigationArticles
	 *
	 * @since 3.3.1
	 */

	public function testNavigationArticles()
	{
		/* actual */

		$actual = Template\Tag::navigation('articles');

		/* compare */

		$this->assertInstanceOf('Redaxscript\Navigation\Article', $actual);
	}

	/**
	 * testNavigationComments
	 *
	 * @since 3.3.1
	 */

	public function testNavigationComments()
	{
		/* actual */

		$actual = Template\Tag::navigation('comments');

		/* compare */

		$this->assertInstanceOf('Redaxscript\Navigation\Comment', $actual);
	}

	/**
	 * testNavigationLanguages
	 *
	 * @since 3.3.1
	 */

	public function testNavigationLanguages()
	{
		/* actual */

		$actual = Template\Tag::navigation('languages');

		/* compare */

		$this->assertInstanceOf('Redaxscript\Navigation\Language', $actual);
	}

	/**
	 * testNavigationTemplates
	 *
	 * @since 3.3.1
	 */

	public function testNavigationTemplates()
	{
		/* actual */

		$actual = Template\Tag::navigation('templates');

		/* compare */

		$this->assertInstanceOf('Redaxscript\Navigation\Template', $actual);
	}
}
