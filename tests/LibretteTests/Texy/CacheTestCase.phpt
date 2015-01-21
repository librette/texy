<?php
namespace LibretteTests\Texy;

use Librette;
use Nette;
use Tester;


require_once __DIR__ . '/../bootstrap.php';


class MyConfigurator implements Librette\Texy\IConfigurator
{

	public $counter = 0;


	public function configure(\Texy $texy)
	{
		$texy->addHandler('beforeParse', function () {
			$this->counter++;
		});
	}

}


/**
 * @author David Matějka
 */
class CacheTestCase extends Tester\TestCase
{

	public function setUp()
	{
	}


	public function testCache()
	{
		$memoryStorage = new Nette\Caching\Storages\MemoryStorage();
		$factory = new Librette\Texy\DefaultTexyFactory();
		$factory->addConfigurator($myConfigurator = new MyConfigurator());
		$engine = new Librette\Texy\Engine($factory, new Librette\Texy\Caching\StandardCache([], $memoryStorage));
		$src = 'Hi!';
		$engine->process($src);
		Tester\Assert::same(1, $myConfigurator->counter);
		$engine->process($src);
		Tester\Assert::same(1, $myConfigurator->counter);
	}


	public function testNoCache()
	{
		$factory = new Librette\Texy\DefaultTexyFactory();
		$factory->addConfigurator($myConfigurator = new MyConfigurator());
		$engine = new Librette\Texy\Engine($factory, new Librette\Texy\Caching\NoCache());
		$src = 'Hi!';
		$engine->process($src);
		Tester\Assert::same(1, $myConfigurator->counter);
		$engine->process($src);
		Tester\Assert::same(2, $myConfigurator->counter);
	}
}


\run(new CacheTestCase());
