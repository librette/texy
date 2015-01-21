<?php
namespace Librette\Texy\Configurators;

use Librette\Texy\IConfigurator;
use TexyConfigurator;
use Texy;

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
