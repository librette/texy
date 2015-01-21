<?php
namespace Librette\Texy\Configurators;

use Librette\Texy\IConfigurator;
use Texy;
use TexyConfigurator;

/**
 * @author David Matejka
 */
class DisableImagesConfigurator implements IConfigurator
{

	public function configure(Texy $texy)
	{
		TexyConfigurator::disableImages($texy);
	}

}
