<?php
namespace Librette\Texy\Configurators;

use Librette\Texy\IConfigurator;
use TexyConfigurator;
use Texy;

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
