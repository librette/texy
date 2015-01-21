<?php
namespace Librette\Texy;

/**
 * @author David Matejka
 */
interface ICachingStrategy
{

	/**
	 * @param mixed cache identifier. NOT serialized
	 * @param callable
	 * @return string
	 */
	public function load($key, $callback);
}
