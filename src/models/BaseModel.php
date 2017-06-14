<?php
namespace pastuhov\ymlcatalog\models;

use pastuhov\ymlcatalog\EscapedAttributes;
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
    public static $tagProperties = [];

    /**
     * @var string[]
     */
    protected $escapedAttributes = [];

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
     * @param $valuesModel
     * @param null $onValidationError
     *
     * @return bool
     * @throws Exception
     */
    public function loadModel($valuesModel, $onValidationError = null)
    {
        if ($valuesModel instanceof EscapedAttributes) {
            $this->escapedAttributes = $valuesModel->getEscapedAttributes();
        }

        $attributes = [];
        foreach ($this->attributes() as $attribute) {
            $methodName = 'get' . ucfirst($attribute);
            $attributeValue = $valuesModel->$methodName();

            $attributes[$attribute] = $attributeValue;
        }

        $this->load($attributes, '');

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
        $properties = static::$tagProperties;

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
        if ($this->$attribute !== null) {
            $result = trim($this->$attribute);
            if (in_array($attribute, $this->escapedAttributes)) {
                $result = htmlspecialchars($result);
            }

            return $result;
        }
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

        $string = '<' . $attribute . '>' . $value . '</' . $attribute. '>' . PHP_EOL;

        return $string;
    }
}
