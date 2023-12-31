<?php
require_once AME_ROOT_DIR . '/includes/reflection-callable.php';

/**
 * A wrapper for standard dashboard widgets, like those added by WordPress or other plugins.
 */
class ameStandardWidgetWrapper extends ameDashboardWidget {
	/**
	 * @var array The original widget that has been wrapped.
	 */
	private $wrappedWidget;

	/**
	 * @var bool
	 */
	private $wasPresent = true;
	private $callbackFileName = null;

	protected $widgetType = 'wrapper';

	public function __construct(array $widgetToWrap) {
		$properties = array_merge(
			$widgetToWrap,
			array(
				'title'    => '',
				'location' => '',
				'priority' => '',
			)
		);
		parent::__construct($properties);

		$this->wrappedWidget = $widgetToWrap;
		$this->wasPresent = $this->hasValidCallback();

		if ( $this->hasValidCallback() ) {
			$this->updateCallbackFileName();
		}
	}

	/**
	 * @param array $properties
	 * @return boolean True if any properties were changed, false otherwise.
	 */
	public function updateWrappedWidget(array $properties) {
		if ( $properties['id'] !== $this->id ) {
			throw new LogicException(sprintf(
				'Widget ID mismatch. Expected: "%s", got: "%s".',
				$this->id,
				$properties['id']
			));
		}

		$oldProperties = $this->wrappedWidget;
		$this->wrappedWidget = $properties;
		if ( isset($properties['callback']) ) {
			$this->callback = $properties['callback'];
		}
		if ( isset($properties['callbackArgs']) ) {
			$this->callbackArgs = $properties['callbackArgs'];
		}

		$changesDetected = false;

		//Update callback file name.
		if ( $this->hasValidCallback() ) {
			$changesDetected = $this->updateCallbackFileName() || $changesDetected;
		}

		foreach(array('title', 'location', 'priority') as $key) {
			if ( $oldProperties[$key] !== $properties[$key] ) {
				$changesDetected = true;
				break;
			}
		}

		$changesDetected = $this->setPresence($this->hasValidCallback()) || $changesDetected;

		return $changesDetected;
	}

	/**
	 * Copy the wrapped widget and related properties from another wrapper to this wrapper.
	 *
	 * Only copies defaults. Doesn't change custom titles and so on.
	 *
	 * @param ameStandardWidgetWrapper $otherWidget
	 */
	public function copyWrappedWidgetFrom($otherWidget) {
		$this->wrappedWidget = $otherWidget->wrappedWidget;
		$this->wasPresent = $otherWidget->wasPresent;
		$this->callbackFileName = $otherWidget->callbackFileName;
	}
	
	private function updateCallbackFileName() {
		try {
			$reflection = new AmeReflectionCallable($this->callback);
		} catch (ReflectionException $e) {
			return false;
		}

		$fileName = $reflection->getFileName();
		if ($fileName === false) {
			$fileName = null;
		}

		if ( $fileName !== $this->callbackFileName ) {
			$this->callbackFileName = $fileName;
			return true; //File name has changed.
		}
		return false; //No changes.
	}

	public function getCallbackFileName() {
		return $this->callbackFileName;
	}

	public function getTitle() {
		return $this->getProperty('title');
	}

	public function getLocation() {
		return $this->getProperty('location');
	}

	public function getOriginalLocation() {
		if ( isset($this->wrappedWidget['location']) ) {
			return $this->wrappedWidget['location'];
		}
		return $this->getLocation();
	}

	public function getPriority() {
		return $this->getProperty('priority');
	}

	private function getProperty($name) {
		if ( $this->$name !== '' ) {
			return $this->$name;
		}
		return $this->wrappedWidget[$name];
	}

	public function getCallbackArgs() {
		/*
		 * Subtle detail: WordPress stores a copy of the original widget title in the callback
		 * argument array, under the key "__widget_basename". This is used as the widget name
		 * in the "Screen Options" tab and in a couple of other UI labels/tooltips. It seems
		 * that the idea is to have a "nice" name for widgets where the full title also contains
		 * things like a "Configure" link, etc.
		 *
		 * If the user has set a custom title, we need to replace the "__widget_basename"
		 * value to make the custom title appear in the "Screen Options" tab.
		 */
		$callbackArgs = $this->callbackArgs;
		if (
			//Does the widget have a basename (original title)?
			is_array($callbackArgs)
			&& isset($callbackArgs['__widget_basename'])
			//Has the user set a custom title?
			&& isset($this->wrappedWidget['title'])
			&& ($this->getTitle() !== $this->wrappedWidget['title'])
		) {
			//Also change the basename.
			$callbackArgs['__widget_basename'] = $this->getTitle();
			return $callbackArgs;
		}

		return parent::getCallbackArgs();
	}

	public function isPresent() {
		return $this->wasPresent || $this->hasValidCallback();
	}

	public function canBeRegistered() {
		return $this->hasValidCallback();
	}

	protected function hasValidCallback() {
		return isset($this->callback) && is_callable($this->callback);
	}

	public function setPresence($isPresent) {
		$changed = ($this->wasPresent !== $isPresent);
		$this->wasPresent = $isPresent;
		return $changed;
	}

	public static function fromArray($widgetProperties) {
		$widget = new self(array_merge(
			(array)($widgetProperties['wrappedWidget']),
			array('id' => $widgetProperties['id'])
		));
		$widget->setProperties($widgetProperties);
		return $widget;
	}

	protected function setProperties(array $properties) {
		parent::setProperties($properties);

		$keysToCopy = array('wasPresent', 'callbackFileName');
		foreach($keysToCopy as $name) {
			if (isset($properties[$name])) {
				$this->$name = $properties[$name];
			}
		}
	}

	public function toArray() {
		$result = parent::toArray();
		$result['wrappedWidget'] = array(
			'title' => $this->wrappedWidget['title'],
			'location' => $this->wrappedWidget['location'],
			'priority' => $this->wrappedWidget['priority'],
		);

		$result['wasPresent'] = $this->wasPresent;
		$result['callbackFileName'] = $this->callbackFileName;
		return $result;
	}
}