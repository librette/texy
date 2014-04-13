<?php
namespace Librette\Texy;

/**
 * @author David Matejka
 */
interface ICachingStrategy
{

	/**
	 * @param mixed $key cache identifier. NOT serialized
	 * @param callable $callback
	 * @return string
	 */
	public function load($key, $callback);
}
