<?php
namespace pastuhov\ymlcatalog\models;

use yii\base\Model;
use yii\base\Exception;

/**
 * Base model.
 *
 * @package pastuhov\ymlcatalog\models
 */
class BaseModel extends Model
{
    /**
     * @var string
     */
    public static $tag;

    /**
     * @var string[]
     */
    public static function getTagProperties() {
        return [];
    }

    /**
     * @return string[]
     */
    public function getYmlAttributes()
    {
        return $this->attributes();
    }

    /**
     * @return string
     */
    public function getYml()
    {
        $string = '';

        $string .= $this->getYmlStartTag();
        $string .= $this->getYmlBody();
        $string .= $this->getYmlEndTag() . PHP_EOL;

        return $string;
    }

    /**
     * @param array $params
     */
    public function setParams(array $params)
    {

    }

    /**
     * @param array $pictures
     */
    public function setPictures(array $pictures)
    {

    }

    /**
     * @param array $options
     */
    public function setDeliveryOptions(array $options)
    {

    }

    /**
     * @param $data
     * @param null $onValidationError
     *
     * @return bool
     * @throws Exception
     */
    public function loadAndValidate($data, $onValidationError = null)
    {
        $this->load($data, '');

        if (!$this->validate()) {
            if (is_callable($onValidationError)) {
                $onValidationError($this);
                return false;
            } else {
                throw new Exception('Model values is invalid ' . serialize($this->getErrors()));
            }
        }

        return true;
    }

    /**
     * @param $valuesModel
     * @param null $onValidationError
     *
     * @return bool
     * @throws Exception
     */
    public function loadModel($valuesModel, $onValidationError = null)
    {
        if (is_array($valuesModel)) {
            $valuesModel = \yii::createObject($valuesModel);
        }

        $attributes = [];
        foreach ($this->attributes() as $attribute) {
            $methodName = 'get' . ucfirst($attribute);
            $attributeValue = $valuesModel->$methodName();

            $attributes[$attribute] = $attributeValue;
        }

        $this->load($attributes, '');

        if (!$this->validate()) {
            $e = new Exception('Model ' . get_class($this) . ' values is invalid ' . var_export($this->getErrors(), true) . ' values: ' . var_export($attributes, true));
            if (is_callable($onValidationError)) {
                $onValidationError($this, $e);
                return false;
            } else {
                throw $e;
            }
        }

        return true;
    }

    /**
     * @return string
     */
    protected function getYmlStartTag()
    {
        $string = '';
        if (static::$tag) {
            $string = '<' . static::$tag . $this->getYmlTagProperties() . '>';
        }

        return $string;
    }

    /**
     * @return string
     */
    protected function getYmlEndTag()
    {
        $string = '';
        if (static::$tag) {
            $string .= '</' . static::$tag . '>';
        }

        return $string;
    }

    /**
     * @return string
     */
    protected function getYmlBody()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    protected function getYmlTagProperties()
    {
        $string = '';
        $properties = static::getTagProperties();

        foreach ($properties as $property) {
            $value = $this->getAttributeValue($property);
            if ($value !== null) {
                $string .= ' ' . $property . '="' . $value . '"';
            }
        }

        return $string;
    }

    /**
     * @param string $attribute
     * @return string
     */
    protected function getAttributeValue($attribute)
    {
        return $this->$attribute;
    }

    /**
     * @param string $attribute
     * @return string
     */
    protected function getYmlAttribute($attribute)
    {
        $value = $this->getAttributeValue($attribute);
        if ($value === null) {
            return '';
        }


        if (($key = array_search($attribute, $this->getYmlAttributes())) !== false && is_string($key)) {
            $attribute = $key;
        }

        $string = '<' . $attribute . '>' . $value . '</' . $attribute. '>' . PHP_EOL;

        return $string;
    }
}
