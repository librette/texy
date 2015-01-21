<?php
namespace Librette\Texy\Configurators;

use Librette\Texy\IConfigurator;
use Texy;
use TexyConfigurator;

/**
 * @author David Matejka
 */
class DisableLinksConfigurator implements IConfigurator
{

	public function configure(Texy $texy)
	{
		TexyConfigurator::disableLinks($texy);
	}

}
