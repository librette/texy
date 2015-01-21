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
class EngineTestCase extends Tester\TestCase
{

	/** @var Librette\Texy\Engine */
	protected $texy;


	public function setUp()
	{
		$this->texy = new Librette\Texy\Engine(new Librette\Texy\DefaultTexyFactory(), new Librette\Texy\Caching\NoCache());
		Texy::$advertisingNotice = FALSE;
	}


	public function testBasic()
	{
		$result = $this->texy->process("Hello world!\n=======");
		Tester\Assert::same("\n<h1>Hello world!</h1>\n", $result);
	}


	public function testAdditionalOptions()
	{
		$result = $this->texy->process("Hello world!\n=====", array('headingModule' => array('top' => 2)));
		Tester\Assert::same("\n<h2>Hello world!</h2>\n", $result);
	}
}


\run(new EngineTestCase());
