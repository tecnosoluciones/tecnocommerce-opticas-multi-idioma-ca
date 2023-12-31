<?php

class ameRexCapability implements ArrayAccess {
	public $usedByComponents = array();
	/**
	 * @var ameRexComponentCapabilityInfo[]
	 */
	public $componentContext = array();

	public $menuItems = array();
	public $componentId = null;

	public $usedByPostTypes = array();

	/**
	 * $permissions, $documentationUrl, and $notes are set dynamically based on
	 * the component context selected for the capability. Some of them will usually
	 * remain unset/unmodified.
	 *
	 * @see \ameRoleEditor::assignCapabilitiesToComponents()
	 *
	 * @var string[]|null
	 */
	public $permissions = null;
	/**
	 * @var string|null
	 */
	public $documentationUrl = null;
	/**
	 * @var string|null
	 */
	public $notes = null;

	/**
	 * @param string $componentId
	 * @param ameRexComponentCapabilityInfo|mixed $componentContext
	 */
	public function addUsage($componentId, $componentContext = null) {
		$this->usedByComponents[$componentId] = true;
		if ( $componentContext instanceof ameRexComponentCapabilityInfo ) {
			$this->componentContext[$componentId] = $componentContext;
		}
	}

	/**
	 * @param ameRexComponentCapabilityInfo[] $components
	 */
	public function addManyUsages($components) {
		foreach ($components as $componentId => $info) {
			$this->usedByComponents[$componentId] = true;
			if ( $info instanceof ameRexComponentCapabilityInfo ) {
				$this->componentContext[$componentId] = $info;
			}
		}
	}

	/**
	 * Whether a offset exists
	 *
	 * @link https://php.net/manual/en/arrayaccess.offsetexists.php
	 * @param mixed $offset <p>
	 * An offset to check for.
	 * </p>
	 * @return boolean true on success or false on failure.
	 * </p>
	 * <p>
	 * The return value will be casted to boolean if non-boolean was returned.
	 * @since 5.0.0
	 */
	#[\ReturnTypeWillChange]
	public function offsetExists($offset) {
		return property_exists($this, $offset);
	}

	/**
	 * Offset to retrieve
	 *
	 * @link https://php.net/manual/en/arrayaccess.offsetget.php
	 * @param mixed $offset <p>
	 * The offset to retrieve.
	 * </p>
	 * @return mixed Can return all value types.
	 * @since 5.0.0
	 */
	#[\ReturnTypeWillChange]
	public function offsetGet($offset) {
		return $this->$offset;
	}

	/**
	 * Offset to set
	 *
	 * @link https://php.net/manual/en/arrayaccess.offsetset.php
	 * @param mixed $offset <p>
	 * The offset to assign the value to.
	 * </p>
	 * @param mixed $value <p>
	 * The value to set.
	 * </p>
	 * @return void
	 * @since 5.0.0
	 */
	#[\ReturnTypeWillChange]
	public function offsetSet($offset, $value) {
		$this->$offset = $value;
	}

	/**
	 * Offset to unset
	 *
	 * @link https://php.net/manual/en/arrayaccess.offsetunset.php
	 * @param mixed $offset <p>
	 * The offset to unset.
	 * </p>
	 * @return void
	 * @since 5.0.0
	 */
	#[\ReturnTypeWillChange]
	public function offsetUnset($offset) {
		$this->$offset = null;
	}
}