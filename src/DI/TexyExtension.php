<?php
namespace Librette\Texy\DI;

use Nette\DI\Statement;

/**
 * @author David Matejka
 */
class TexyExtension extends \Nette\DI\CompilerExtension
{

	const SERVICE_NAME_PATTERN = '%sEngine';

	protected static $defaultConfigurators = array(
		'safeMode'      => '\Librette\Texy\Configurators\SafeModeConfigurator',
		'disableImages' => '\Librette\Texy\Configurators\DisableImagesConfigurator',
		'disableLinks'  => '\Librette\Texy\Configurators\DisableLinksConfigurator',
	);


	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();
		$config = $this->getConfig();

		$builder->addDefinition($this->prefix('texyAccessor'))
				->setClass('Librette\Texy\TexyAccessor', array(1 => $this->name));

		foreach ($config as $name => $envConfig) {
			if (array_key_exists('factory', $envConfig)) {
				$factory = new Statement($envConfig['factory']);
			} else {
				$factory = $builder->addDefinition($this->prefix($name . 'Factory'))
								   ->setClass('\Librette\Texy\DefaultTexyFactory');

				foreach (empty($envConfig['configurators']) ? array() : $envConfig['configurators'] as $configurator) {
					if (isset(self::$defaultConfigurators[$configurator])) {
						$configurator = self::$defaultConfigurators[$configurator];
					}
					$configurator = $configurator[0] == '@' ? $configurator : new Statement($configurator);
					$factory->addSetup('addConfigurator', array($configurator));
				}
				if (!empty($envConfig['options'])) {
					$optionsConfigurator = new Statement('Librette\Texy\\Configurators\OptionsConfigurator', array($envConfig['options']));
					$factory->addSetup('addConfigurator', array($optionsConfigurator));
				}
			}

			$cacheStrategy = NULL;
			if (!array_key_exists('cache', $envConfig) || is_array($envConfig['cache'])) {
				$cacheDependencies = empty($envConfig['cache']) ? array() : $envConfig['cache'];
				$builder->addDefinition($this->prefix($name . 'CacheStrategy'))
						->setClass('Librette\Texy\Caching\StandardCache', array($cacheDependencies));
				$cacheStrategy = new Statement($this->prefix('@' . $name . 'CacheStrategy'));
			} elseif (is_string($envConfig['cache'])) { //service reference
				$cacheStrategy = new Statement($envConfig['cache']);
			} else {
				$cacheStrategy = new Statement('Librette\Texy\Caching\NoCache');
			}


			$builder->addDefinition($this->prefix(sprintf(self::SERVICE_NAME_PATTERN, $name)))
					->setClass('\Librette\Texy\Engine', array($factory, $cacheStrategy));

		}

	}

}
