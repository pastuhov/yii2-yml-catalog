<?php
namespace pastuhov\ymlcatalog\models;
use pastuhov\ymlcatalog\DeliveryOptionInterface;

/**
 * Class DeliveryOption
 *
 * Модель опции условий доставки - тега option в секции delivery-option
 * @package pastuhov\ymlcatalog\models
 */
class DeliveryOption extends BaseModel implements DeliveryOptionInterface
{
    /**
     * @inheritdoc
     */
    public static $tag = 'option';

    /** @var int Стоимость доставки в рублях. */
    public $cost;

    /** @var string Срок доставки в рабочих днях. */
    public $days;

    /**
     * Укажите местное время (в часовом поясе магазина)
     *
     * @var int
     */
    public $orderBefore;

    /**
     * @inheritdoc
     */
    public static function getTagProperties()
    {
        return [
            'cost',
            'days',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['cost', 'days'],
                'required',
            ],
            [
                ['cost'],
                'number',
                'integerOnly' => true,
                'min' => 0,
                'max' => SimpleOffer::NUMBER_LIMIT,
            ],
            [
                ['days'],
                function ($attribute, $params) {
                    $value = $this->$attribute;
                    $isBigValue = false;
                    if (!preg_match('/^[\d]+(-[\d]+)?$/', $value)) {
                        $this->addError($attribute, 'Wrong ' . $attribute . ' value');
                        return;
                    }

                    if (strpos($value, '-') !== false) {
                        $parts = explode('-', $value);
                        if (count($parts) != 2) {
                            $this->addError($attribute, 'Wrong parts count in ' . $attribute);
                            return;
                        }

                        if ((int) $parts[0] >= $parts[1]) {
                            $this->addError($attribute, 'Wrong ' . $attribute . ' value');
                            return;
                        }

                        if ($parts[0] > 31 || $parts[1] > 31) {
                            $isBigValue = true;
                        }
                    } else {
                        if ($value > 31) {
                            $isBigValue = true;
                        }
                    }

                    if ($isBigValue) {
                        $this->addError($attribute, 'Value ' . $attribute . ' is greater than 31');
                    }
                },
            ],
            [
                ['orderBefore'],
                'number',
                'integerOnly' => true,
                'min' => 0,
                'max' => 24,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    protected function getYmlBody()
    {
        return null;
    }

    /**
     * @return string
     */
    protected function getYmlStartTag()
    {
        return str_replace('>', ' />', parent::getYmlStartTag());
    }

    /**
     * @return string
     */
    protected function getYmlEndTag()
    {
        return '';
    }

    public function getCost() {
        return $this->cost;
    }

    /**
     * Срок доставки в рабочих днях.
     *
     * Можно указать как конкретное количество дней, так и период «от — до». Например, срок доставки от 2 до 4 дней описывается следующим образом: days="2-4".
     * @return string
     */
    public function getDays() {
        return $this->days;
    }

    /**
     * Срок доставки в рабочих днях.
     *
     * Можно указать как конкретное количество дней, так и период «от — до». Например, срок доставки от 2 до 4 дней описывается следующим образом: days="2-4".
     * @return string
     */
    public function getOrderBefore() {
        return $this->days;
    }
}
