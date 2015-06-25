<?php
namespace pastuhov\ymlcatalog\models;

use yii\base\Model;

class BaseModel extends Model
{
    public static $tag;
    public static $tagProperties = [];

    public function getYmlAttributes()
    {
        return $this->attributes();
    }

    public function getYml()
    {
        $string = '';

        $string .= $this->getYmlStartTag();
        $string .= $this->getYmlBody();
        $string .= $this->getYmlEndTag() . PHP_EOL;

        return $string;
    }

    protected function getYmlStartTag()
    {
        $string = '';
        if (static::$tag) {
            $string = '<' . static::$tag . $this->getYmlTagProperties() . '>';
        }

        return $string;
    }

    protected function getYmlEndTag()
    {
        $string = '';
        if (static::$tag) {
            $string .= '</' . static::$tag . '>';
        }

        return $string;
    }

    protected function getYmlBody()
    {
        return $this->name;
    }

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

    protected function getAttributeValue($attribute)
    {
        return $this->$attribute;
    }


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
