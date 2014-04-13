<?php
namespace LibretteTests\Texy;

use Librette;
use Nette;
use Tester\Assert;
use Tester;

require_once __DIR__ . '/../bootstrap.php';


/**
 * @author David Matějka
 */
class FactoryTestCase extends Tester\TestCase
{

	public function setUp()
	{
	}


	public function testFactory()
	{
		$defaultFactory = new Librette\Texy\DefaultTexyFactory();
		$defaultFactory->addConfigurator(new Librette\Texy\Configurators\DisableImagesConfigurator());
		$defaultFactory->addConfigurator(new Librette\Texy\Configurators\DisableLinksConfigurator());

		$texy = $defaultFactory->create();

		Assert::false($texy->allowed['image']);
		Assert::false($texy->allowed['link/url']);
	}
}


\run(new FactoryTestCase());