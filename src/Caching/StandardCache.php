<?php
namespace Librette\Texy\Caching;

use Librette\Texy\ICachingStrategy;
use Nette\Caching\Cache;
use Nette\Caching\IStorage;
use Nette\Object;

/**
 * @author David Matejka
 *
 * @method setDependencies(array $dependencies)
 * @method array getDependencies()
 */
class StandardCache extends Object implements ICachingStrategy
{

	const CACHE_NAMESPACE = "Librette.Texy";

	/** @var \Nette\Caching\Cache */
	protected $cache;

	/** @var array */
	protected $dependencies = array();


	/**
	 * @param array $dependencies
	 * @param IStorage $cacheStorage
	 */
	public function __construct(array $dependencies, IStorage $cacheStorage)
	{
		$this->cache = new Cache($cacheStorage, self::CACHE_NAMESPACE);
		$this->dependencies = $dependencies;
	}


	public function load($key, $callback)
	{
		return $this->cache->load($key, function (&$dependencies) use ($callback) {
			$dependencies = $this->dependencies;

			return call_user_func($callback);
		});
	}

}
