<?php
namespace Librette\Texy\Configurators;

use Librette\Texy\IConfigurator;
use Texy;
use TexyConfigurator;

/**
 * @author David Matejka
 */
class SafeModeConfigurator implements IConfigurator
{

	public function configure(Texy $texy)
	{
		TexyConfigurator::safeMode($texy);
	}

}
