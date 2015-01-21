<?php
namespace LibretteTests\Texy;

use Librette;
use Nette;
use Tester;
use Texy;

require_once __DIR__ . '/../bootstrap.php';


/**
 * @author David Matějka
 */
class ConfiguratorsTestCase extends Tester\TestCase
{

	public function setUp()
	{
	}


	public function testDisableImages()
	{
		$texy = new Texy();
		Tester\Assert::true($texy->allowed['image']);
		$disableImagesConfigurator = new Librette\Texy\Configurators\DisableImagesConfigurator();
		$disableImagesConfigurator->configure($texy);
		Tester\Assert::false($texy->allowed['image']);
	}


	public function testDisableLinks()
	{
		$texy = new Texy();
		Tester\Assert::true($texy->allowed['link/url']);
		$disableLinksConfigurator = new Librette\Texy\Configurators\DisableLinksConfigurator();
		$disableLinksConfigurator->configure($texy);
		Tester\Assert::false($texy->allowed['link/url']);
	}


	public function testSafeMode()
	{
		$texy = new Texy();
		Tester\Assert::true($texy->allowed['image']);
		$safeModeConfigurator = new Librette\Texy\Configurators\SafeModeConfigurator();
		$safeModeConfigurator->configure($texy);
		Tester\Assert::false($texy->allowed['image']);
	}


	public function testOptionsConfigurator()
	{
		$texy = new Texy();
		$options = [
			'nontextParagraph' => 'foo',
			'scriptModule'     => [
				'separator' => ';'
			]
		];
		$configurator = new Librette\Texy\Configurators\OptionsConfigurator($options);
		$configurator->configure($texy);
		Tester\Assert::same('foo', $texy->nontextParagraph);
		Tester\Assert::same(';', $texy->scriptModule->separator);

	}
}


\run(new ConfiguratorsTestCase());
