<?php

//This file was automatically generated
//Do not edit this file directly.
///*{WS_PCGN_GENERATED_FILE}*/
abstract class AmeEhAbstractPreference
{
    /**
     * @var string|null
     */
    protected $storageKey = null;
    protected $triedLoading = false;
    protected $hasUnsavedChanges = false;
    protected $delayUpdates = false;
    protected $ajaxEnabled = false;
    /**
     * @var string|null
     */
    protected $ajaxAction = null;
    protected $permissionCallback = null;
    /**
     * @var string Name used in some error messages.
     */
    protected $name = '[ UnnamedPreference ]';
    //region Storage
    protected function maybeSaveChanges()
    {
        if (!$this->delayUpdates) {
            $this->saveChanges();
        }
    }
    public function saveChanges()
    {
        //AKA flush
        $this->delayUpdates = false;
        if (!$this->hasUnsavedChanges || !$this->isPersistable()) {
            return false;
        }
        //Since update_user_meta() does not provide a way to determine if an update failed
        //because of an error or because the new value matches the old value, we just assume
        //that changes are always saved successfully.
        $this->hasUnsavedChanges = false;
        return $this->writeToDb();
    }
    protected abstract function writeToDb();
    protected abstract function loadFromDb();
    /**
     * @return bool
     */
    protected function isPersistable()
    {
        return is_string($this->storageKey) && $this->storageKey !== '';
    }
    public function delete()
    {
        if ($this->isPersistable()) {
            delete_user_meta(get_current_user_id(), $this->storageKey);
        }
    }
    public function bufferChanges()
    {
        $this->delayUpdates = true;
    }
    //endregion
    //region AJAX updates
    public function installAjaxCallback($permissionCallback)
    {
        if (!$this->ajaxEnabled || empty($this->ajaxAction)) {
            throw new LogicException('AJAX is not enabled for this item');
        }
        $this->permissionCallback = $permissionCallback;
        $hook = 'wp_ajax_' . $this->ajaxAction;
        add_action($hook, array($this, 'handleAjaxUpdate'));
    }
    public function handleAjaxUpdate()
    {
        if (!$this->ajaxEnabled) {
            $this->outputAjaxError(new WP_Error('AJAX updates are not enabled for this item', 'ajax_disabled', 500));
            exit;
        }
        $authStatus = $this->checkAjaxAuthorization();
        if ($authStatus !== true) {
            if (is_wp_error($authStatus)) {
                $this->outputAjaxError($authStatus);
            } else {
                $this->outputAjaxError(new WP_Error('unknown_authorization_error', 'Access denied', 403));
            }
            exit;
        }
        $params = $_POST;
        //Remove magic quotes.
        if (did_action('sanitize_comment_cookies') && function_exists('wp_magic_quotes')) {
            $params = wp_unslash($params);
        }
        if (!array_key_exists('data', $params)) {
            $this->outputAjaxError(new WP_Error('The required "data" field is missing', 'no_value'));
            return;
        }
        $newData = json_decode($params['data'], true);
        if ($newData === null && function_exists('json_last_error') && defined('JSON_ERROR_NONE') && json_last_error() !== JSON_ERROR_NONE) {
            $this->outputAjaxError(new WP_Error('The "data" field does not contain valid JSON', 'json_decode_error'));
            return;
        }
        list($validationErrors, $isSuccess, $changeCount) = $this->updateFromAjax($newData);
        $errorMessages = array();
        foreach ($validationErrors as $error) {
            $errorMessages = array_merge($errorMessages, $error->get_error_messages());
        }
        if ($isSuccess) {
            $this->outputJson(array(
                'success' => true,
                //There can still be some errors if this was a partial update.
                'validationErrors' => $errorMessages,
                'changes' => $changeCount,
            ));
        } else {
            status_header(400);
            $this->outputJson(array('error' => array('message' => 'Validation failed', 'code' => 'validation_error', 'validationErrors' => $errorMessages), 'changes' => $changeCount));
        }
        exit;
    }
    /**
     * @return bool|\WP_Error
     */
    protected function checkAjaxAuthorization()
    {
        if (!check_ajax_referer($this->ajaxAction, false, false)) {
            return new WP_Error('nonce_check_failed', 'Invalid or missing nonce.', 403);
        }
        if (isset($this->permissionCallback)) {
            $result = call_user_func($this->permissionCallback);
            if ($result === false) {
                return new WP_Error('permission_callback_failed', 'You don\'t have permission to perform this action.', 403);
            } else {
                if (is_wp_error($result)) {
                    return $result;
                }
            }
        }
        return true;
    }
    /**
     * @param WP_Error $error
     * @return void
     */
    protected function outputAjaxError($error)
    {
        $statusCode = 400;
        $customStatusCode = $error->get_error_data();
        if (isset($customStatusCode) && is_int($customStatusCode)) {
            $statusCode = $customStatusCode;
        }
        $errorResponse = array('error' => array('message' => $error->get_error_message(), 'code' => $error->get_error_code()));
        status_header($statusCode);
        $this->outputJson($errorResponse);
        exit;
    }
    protected function outputJson($response)
    {
        @header('Content-Type: application/json; charset=' . get_option('blog_charset'));
        echo json_encode($response);
    }
    /**
     * Update the preference(s) with the value(s) received in an AJAX request.
     *
     * The implementation should validate the input data and save it.
     *
     * @param scalar|array $data
     * @return array Multiple values as returned by makeUpdateResult().
     */
    protected abstract function updateFromAjax($data);
    /**
     * @param WP_Error[] $validationErrors
     * @param boolean $isSuccess
     * @param int $changeCount
     * @return array
     */
    protected static final function makeUpdateResult($validationErrors, $isSuccess, $changeCount)
    {
        return array($validationErrors, $isSuccess, $changeCount);
    }
    //endregion
    //region JavaScript integration
    protected $jsGlobalVariable = '';
    protected $jsClassName = '';
    protected $jsScriptHandle = '';
    //Could be the same for multiple preferences.
    protected $jsRelativeScriptFileName = '';
    //??? Could be bundled and/or moved.
    protected $jsScriptVersion = '20220325';
    protected $isRegistrationDone = false;
    protected $isRegistrationHookSet = false;
    /**
     * @return string|null
     */
    public function getScriptHandle()
    {
        //Register the script lazily. There could be multiple preferences that use
        //the same JS script, but we only need to register it once.
        if (!$this->isRegistrationDone && !$this->isRegistrationHookSet) {
            if (did_action('wp_loaded')) {
                $this->registerScript();
            } else {
                add_action('wp_loaded', array($this, 'registerScript'));
                $this->isRegistrationHookSet = true;
            }
        }
        return $this->jsScriptHandle;
    }
    public function registerScript()
    {
        if ($this->isRegistrationDone) {
            return;
        }
        //Multiple preferences could use the same bundled JS script.
        //We only need to register it once.
        if (!wp_script_is($this->jsScriptHandle, 'registered')) {
            wp_register_script($this->jsScriptHandle, plugins_url($this->jsRelativeScriptFileName, __FILE__), array('jquery'), $this->jsScriptVersion);
        }
        //Add the initialization code that passes data to the script
        //and sets up the global variable. Each preference has its own
        //initializer even if they share the same JS file.
        if (function_exists('wp_add_inline_script') && !empty($this->jsGlobalVariable)) {
            //WP 4.5+
            wp_add_inline_script($this->jsScriptHandle, $this->generateJsInitializer(), 'after');
        }
        $this->isRegistrationDone = true;
    }
    protected function generateJsInitializer()
    {
        if (!$this->triedLoading && $this->isPersistable()) {
            $this->loadFromDb();
        }
        $constructorData = array_merge(array('ajaxUrl' => admin_url('admin-ajax.php'), 'ajaxAction' => $this->ajaxAction, 'ajaxNonce' => wp_create_nonce($this->ajaxAction), 'name' => $this->name), $this->getJsConstructorData());
        $code = array();
        $code[] = sprintf('window.%1$s = (function(jsData) { 
				return (%2$s.pcgnIsConstructor) ? (new %2$s(jsData)) : (%2$s(jsData)); 
			})(%3$s);', $this->jsGlobalVariable, $this->jsClassName, json_encode($constructorData));
        return implode("\n", $code);
    }
    /**
     * @return array
     */
    protected abstract function getJsConstructorData();
    //endregion
    //region Validation and conversion
    /**
     * Check if the type of value is numeric (i.e. integer or float).
     *
     * @param mixed $value
     * @return bool
     */
    protected static function isNumber($value)
    {
        return is_float($value) || is_int($value);
    }
    /**
     * Convert a value to a number if it can be done without data loss.
     *
     * For example, "12.3" is converted to 12.3, but "12.3 things" is not.
     * The idea is to convert numbers stored as strings, but to reject strings
     * that just happen to have a number in them.
     *
     * @param mixed $value
     * @return float|int|null Either a number, or NULL if the value cannot be converted.
     */
    protected static function convertToNumber($value)
    {
        if (self::isNumber($value)) {
            return $value;
        } else {
            if (is_string($value)) {
                $value = trim($value);
                //is_numeric() is too permissive, so we'll use a regex to further restrict
                //the accepted number formats.
                if (is_numeric($value) && preg_match('/^[+-]?\\d{1,40}+(?:[.,]\\d{1,40}+)?$/', $value)) {
                    $value = str_replace(',', '.', $value);
                    return floatval($value);
                } else {
                    return null;
                }
            } else {
                if (is_bool($value)) {
                    return $value ? 1 : 0;
                }
            }
        }
        return null;
    }
    /**
     * Convert a scalar value to a string.
     *
     * @param mixed $value
     * @return string|null
     */
    protected static function convertToString($value)
    {
        if (is_string($value)) {
            return $value;
        } else {
            if (is_bool($value)) {
                return $value ? 'true' : 'false';
            } else {
                if (is_scalar($value)) {
                    return strval($value);
                }
            }
        }
        return null;
    }
    //endregion
}
abstract class AmeEhBasePreferenceGroup extends AmeEhAbstractPreference
{
    protected $data = array();
    protected $defaults = array();
    protected $ajaxEnabled = true;
    protected $ajaxAction = 'ws_pgn_update_group';
    protected $partialUpdatesAllowed = false;
    protected $validatorMethods = array();
    /**
     * @param string $propertyName
     * @return mixed
     */
    protected function getSimpleProperty($propertyName)
    {
        //Lazy-load preferences.
        if (!$this->triedLoading && $this->isPersistable()) {
            $this->loadFromDb();
        }
        if (array_key_exists($propertyName, $this->data)) {
            return $this->data[$propertyName];
        } else {
            if (array_key_exists($propertyName, $this->defaults)) {
                return $this->defaults[$propertyName];
            }
        }
        return null;
    }
    /**
     * @param string $propertyName
     * @param mixed $newValue
     * @return $this
     */
    protected function setSimpleProperty($propertyName, $newValue)
    {
        list($errors, $convertedValue) = call_user_func(array($this, $this->validatorMethods[$propertyName]), $newValue);
        /** @var \WP_Error[] $errors */
        if (empty($errors)) {
            //Make sure preferences are loaded before making changes.
            //If we don't do this, we could end up unintentionally deleting an existing
            //property ["A" => 123] while saving a new property ["B" => 456].
            if (!$this->triedLoading && $this->isPersistable()) {
                $this->loadFromDb();
            }
            $this->data[$propertyName] = $convertedValue;
            $this->hasUnsavedChanges = true;
            $this->maybeSaveChanges();
        } else {
            $firstError = reset($errors);
            throw new InvalidArgumentException($firstError->get_error_message());
        }
        return $this;
    }
    protected function writeToDb()
    {
        $updated = update_user_meta(get_current_user_id(), $this->storageKey, $this->data);
        return $updated !== false;
    }
    protected function loadFromDb()
    {
        $this->triedLoading = true;
        $metaValues = get_user_meta(get_current_user_id(), $this->storageKey, false);
        if (empty($metaValues) || !is_array($metaValues)) {
            return false;
        }
        $data = reset($metaValues);
        if (!is_array($data)) {
            return false;
        }
        $this->data = $data;
        return true;
    }
    protected function updateFromAjax($data)
    {
        if (!is_array($data)) {
            return array(new WP_Error('Input data must be an associative array', 'not_an_array', 400));
        }
        $validationErrors = array();
        $validData = array();
        $knownKeys = array_keys(array_merge($this->data, $this->defaults, $this->validatorMethods));
        foreach ($knownKeys as $key) {
            if (!array_key_exists($key, $data)) {
                continue;
            }
            $value = $data[$key];
            if (isset($this->validatorMethods[$key])) {
                list($errors, $convertedValue) = call_user_func(array($this, $this->validatorMethods[$key]), $value);
                if (empty($errors) || $errors === true) {
                    $validData[$key] = $convertedValue;
                } else {
                    $validationErrors = array_merge($validationErrors, $errors);
                }
            }
        }
        if (empty($validationErrors) && empty($validData)) {
            //The request did not change any supported properties. This is weird,
            //but technically not an error.
            return self::makeUpdateResult($validationErrors, true, 0);
        }
        //Save new values if:
        // a) all the input data is valid, or
        // b) there are some valid values, and partial updates are allowed.
        $isAllValid = empty($validationErrors);
        $canDoPartialUpdate = $this->partialUpdatesAllowed && !empty($validData);
        if ($isAllValid || $canDoPartialUpdate) {
            if (!$this->triedLoading && $this->isPersistable()) {
                $this->loadFromDb();
            }
            $this->data = array_merge($this->data, $validData);
            $this->hasUnsavedChanges = true;
            $this->saveChanges();
            return self::makeUpdateResult($validationErrors, true, count($validData));
        } else {
            return self::makeUpdateResult($validationErrors, false, 0);
        }
    }
    protected function getJsConstructorData()
    {
        return array('data' => $this->data, 'defaults' => $this->defaults);
    }
}
abstract class AmeEhBasePreference extends AmeEhAbstractPreference
{
    protected $value = null;
    protected $hasValue = false;
    protected $defaultValue = null;
    public function __invoke($newValue = null)
    {
        if ($newValue === null) {
            return $this->getEffectiveValue();
        } else {
            return $this->update($newValue);
        }
    }
    protected function getEffectiveValue()
    {
        if (!$this->triedLoading) {
            $this->loadFromDb();
        }
        if ($this->hasValue) {
            return $this->value;
        }
        return $this->defaultValue;
    }
    public function setToNull()
    {
        return $this->update(null);
    }
    public function update($newValue)
    {
        list($errors, $convertedValue) = $this->validate($newValue);
        if (!empty($errors)) {
            return $errors;
        }
        $newValue = $convertedValue;
        $this->hasValue = true;
        if ($newValue !== $this->value) {
            $this->value = $newValue;
            $this->hasUnsavedChanges = true;
            $this->maybeSaveChanges();
        }
        return $errors;
    }
    /**
     * @param $newValue
     * @psalm-return array{array<WP_Error>, mixed} The first element is an array of errors,
     *  the second is the coerced/converted value or NULL.
     */
    public abstract function validate($newValue);
    protected function writeToDb()
    {
        $updated = update_user_meta(get_current_user_id(), $this->storageKey, $this->value);
        return $updated !== false;
    }
    protected function loadFromDb()
    {
        $this->triedLoading = true;
        //There should only be a single value, but setting $single to false helps
        //distinguish between "no results" and "value is NULL".
        $metaValues = get_user_meta(get_current_user_id(), $this->storageKey, false);
        if (empty($metaValues) || !is_array($metaValues)) {
            return false;
        }
        $this->value = reset($metaValues);
        $this->hasValue = true;
        return true;
    }
    protected function updateFromAjax($data)
    {
        $errors = $this->update($data);
        $isSuccess = empty($errors);
        return self::makeUpdateResult($errors, $isSuccess, $isSuccess ? 1 : 0);
    }
    protected function getJsConstructorData()
    {
        return array('value' => $this->value, 'defaultValue' => $this->defaultValue, 'hasValue' => $this->hasValue);
    }
}
/**
 * Automatically generated class for preference isExplanationHidden
 */
class AmeEhIsExplanationHidden extends AmeEhBasePreference
{
    protected $defaultValue = 0;
    protected $ajaxEnabled = true;
    protected $ajaxAction = 'ame_eh_pcgn_isExplanationHidden';
    protected $jsGlobalVariable = 'ameEhIsExplanationHidden';
    protected $jsClassName = 'AmeEhIsExplanationHidden';
    //The handle could be the same for multiple preferences.
    protected $jsScriptHandle = 'ame-ehjs-eh-preferences';
    //The script could be bundled and/or moved.
    protected $jsRelativeScriptFileName = 'eh-preferences.js';
    protected $jsScriptVersion = '20220421-9946';
    public function validate($newValue)
    {
        $convertedValue = self::convertToNumber($newValue);
        if ($convertedValue === null) {
            return array(array(new WP_Error('Value must be a number')), $convertedValue);
        }
        if ($convertedValue != intval($convertedValue)) {
            return array(array(new WP_Error('Value must be an integer')), $convertedValue);
        }
        $convertedValue = intval($convertedValue);
        if ($convertedValue < 0) {
            return array(array(new WP_Error('Value must be at least 0')), $convertedValue);
        }
        if ($convertedValue > 1) {
            return array(array(new WP_Error('Value must be at most 1')), $convertedValue);
        }
        return array(array(), $convertedValue);
    }
    protected $name = 'isExplanationHidden';
    protected $storageKey = 'ws_ame_eh_hide_info';
}
/**
 * Automatically generated class for group UserPreferences
 */
class AmeEhUserPreferences extends AmeEhBasePreferenceGroup
{
    protected $defaults = array('numberOfColumns' => 1, 'csExpandedCategories' => '');
    protected $validatorMethods = array('numberOfColumns' => 'validateNumberOfColumns', 'csExpandedCategories' => 'validateCsExpandedCategories');
    protected $ajaxEnabled = true;
    protected $ajaxAction = 'ame_eh_pcgn_UserPreferences';
    /**
     * Gets the value of the numberOfColumns preference.
     *
     * @return int|null
     */
    public function getNumberOfColumns()
    {
        return $this->getSimpleProperty('numberOfColumns');
    }
    /**
     * @param int $newValue
     * @return $this
     */
    public function setNumberOfColumns($newValue)
    {
        return $this->setSimpleProperty('numberOfColumns', $newValue);
    }
    /**
     * Validate numberOfColumns
     *
     * @param int $newValue
     * @return array{array<\WP_Error>, int|mixed}
     */
    public function validateNumberOfColumns($newValue)
    {
        if ($newValue === null) {
            return array(array(), $newValue);
        }
        $convertedValue = self::convertToNumber($newValue);
        if ($convertedValue === null) {
            return array(array(new WP_Error('Value must be a number')), $convertedValue);
        }
        if ($convertedValue != intval($convertedValue)) {
            return array(array(new WP_Error('Value must be an integer')), $convertedValue);
        }
        $convertedValue = intval($convertedValue);
        if ($convertedValue < 1) {
            return array(array(new WP_Error('Value must be at least 1')), $convertedValue);
        }
        if ($convertedValue > 3) {
            return array(array(new WP_Error('Value must be at most 3')), $convertedValue);
        }
        return array(array(), $convertedValue);
    }
    /**
     * Gets the value of the csExpandedCategories preference.
     *
     * @return string
     */
    public function getCsExpandedCategories()
    {
        return $this->getSimpleProperty('csExpandedCategories');
    }
    /**
     * @param string $newValue
     * @return $this
     */
    public function setCsExpandedCategories($newValue)
    {
        return $this->setSimpleProperty('csExpandedCategories', $newValue);
    }
    /**
     * Validate csExpandedCategories
     *
     * @param string $newValue
     * @return array{array<\WP_Error>, string|mixed}
     */
    public function validateCsExpandedCategories($newValue)
    {
        $convertedValue = self::convertToString($newValue);
        if ($convertedValue === null) {
            return array(array(new WP_Error('Value must be a string')), $convertedValue);
        }
        if (strlen($convertedValue) > 1000) {
            return array(array(new WP_Error('Value must be at most 1000 characters long')), $convertedValue);
        }
        return array(array(), $convertedValue);
    }
    protected $name = 'UserPreferences';
    protected $storageKey = 'ws_ame_eh_prefs';
    protected $jsGlobalVariable = 'ameEhUserPreferences';
    protected $jsClassName = 'AmeEhUserPreferences';
    protected $jsScriptHandle = 'ame-ehjs-eh-preferences';
    protected $jsRelativeScriptFileName = 'eh-preferences.js';
    protected $jsScriptVersion = '20220421-9946';
}