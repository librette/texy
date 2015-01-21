<?php
namespace LibretteTests\Texy;

use Librette;
use Librette\Texy\ICachingStrategy;
use Librette\Texy\ITexyFactory;
use Nette;
use Tester;
use Texy;

require_once __DIR__ . '/../bootstrap.php';


class EngineMock extends Librette\Texy\Engine
{

	public $cachingStrategy;

	public $texyFactory;


	public function __construct(ITexyFactory $texyFactory, ICachingStrategy $cachingStrategy)
	{
		$this->cachingStrategy = $cachingStrategy;
		$this->texyFactory = $texyFactory;
	}

}


class MyTexyFactory implements ITexyFactory
{

	/**
	 * @return \Texy
	 */
	public function create()
	{
		return new Texy();
	}

}


class MockApplyExtension extends Nette\DI\CompilerExtension
{

	public function beforeCompile()
	{
		$this->getContainerBuilder()->getDefinition('texy.commentEngine')
			->factory->entity = '\LibretteTests\Texy\EngineMock';
		$this->getContainerBuilder()->getDefinition('texy.fooEngine')
			->factory->entity = '\LibretteTests\Texy\EngineMock';
	}

}


/**
 * @author David Matějka
 */
class ExtensionTestCase extends Tester\TestCase
{

	public function setUp()
	{
	}


	public function testBasic()
	{
		$configurator = new Nette\Configurator();
		unset($configurator->defaultExtensions['nette']);
		$configurator->addConfig(__DIR__ . '/config/basic.neon');
		$configurator->setTempDirectory(TEMP_DIR);
		$container = $configurator->createContainer();

		/** @var Librette\Texy\TexyAccessor $accessor */
		$accessor = $container->getByType('Librette\Texy\TexyAccessor');
		Tester\Assert::type('Librette\Texy\TexyAccessor', $accessor);
		$engine = $accessor->get('article');
		$texy = $engine->getTexy();

		Tester\Assert::same('bar', $texy->emoticonModule->class);
		Tester\Assert::same(2, $texy->headingModule->top);
		Tester\Assert::false($texy->allowed['image']);
		Tester\Assert::false($texy->allowed['link/url']);

		/** @var EngineMock $engine */
		$engine = $accessor->get('comment');
		Tester\Assert::type('\Librette\Texy\Caching\StandardCache', $cache = $engine->cachingStrategy);
		Tester\Assert::same(['expiration' => '+1 hour'], $cache->getDependencies());

		/** @var EngineMock $engine */
		$engine = $accessor->get('foo');
		Tester\Assert::type('\Librette\Texy\Caching\NoCache', $engine->cachingStrategy);
		Tester\Assert::type('\LibretteTests\Texy\MyTexyFactory', $engine->texyFactory);

	}
}


\run(new ExtensionTestCase());
