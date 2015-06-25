<?php
namespace pastuhov\ymlcatalog\Test\models;

use pastuhov\ymlcatalog\SimpleOfferInterface;
use yii\db\ActiveRecord;

/**
 * @inheritdoc
 */
class SimpleOffer extends ActiveRecord implements SimpleOfferInterface
{

    /**
     * ID.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->attributes['id'];
    }

    /**
     * URL страницы товара.
     *
     * Максимальная длина URL — 512 символов.
     * Необязательный элемент для магазинов-салонов.
     *
     * @return string|null
     */
    public function getUrl()
    {
        return 'http://magazin.ru/product_page.asp?pid=' . $this->attributes['id'];
    }

    /**
     * Цена.
     *
     * Цена, по которой данный товар можно приобрести. Цена товарного предложения округляется, формат, в котором
     * она отображается, зависит от настроек пользователя.
     * Обязательный элемент.
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->attributes['price'];
    }

    /**
     * Старая цена.
     *
     * Старая цена на товар, которая обязательно должна быть выше новой цены (<price>). Параметр <oldprice> необходим
     * для автоматического расчета скидки на товар.
     * Необязательный элемент.
     *
     * @return string|null
     */
    public function getOldPrice()
    {
        return $this->attributes['old_price'];
    }

    /**
     * Идентификатор валюты.
     *
     * Идентификатор валюты товара (RUR, USD, UAH, KZT). Для корректного отображения цены в национальной валюте
     * необходимо использовать идентификатор (например, UAH) с соответствующим значением цены.
     * Обязательный элемент.
     *
     * @return string
     */
    public function getCurrencyId()
    {
        return 'RUR';
    }

    /**
     * Идентификатор категории.
     *
     * Идентификатор категории товара, присвоенный магазином (целое число не более 18 знаков). Товарное предложение
     * может принадлежать только одной категории.
     * Обязательный элемент. Элемент <offer> может содержать только один элемент <categoryId>.
     *
     * @return string
     */
    public function getCategoryId()
    {
        return $this->attributes['category_id'];
    }

    /**
     * Категория товара, в которой он должен быть размещен на Яндекс.Маркете. Допустимо указывать названия категорий
     * только из товарного дерева категорий Яндекс.Маркета.
     * Необязательный элемент.
     * @link http://download.cdn.yandex.net/support/ru/partnermarket/files/market_categories.xls
     *
     * @return string
     */
    public function getMarket_Category()
    {
        return null;
    }

    /**
     * Ссылка на картинку.
     *
     * Ссылка на картинку соответствующего товарного предложения. Недопустимо давать ссылку на «заглушку»,
     * т. е. на страницу, где написано «картинка отсутствует», или на логотип магазина.
     * Максимальная длина URL — 512 символов.
     * Необязательный элемент.
     *
     * @return string|null
     */
    public function getPicture()
    {
        return 'http://magazin.ru/img/device' . $this->attributes['id'] . '.jpg';
    }

    /**
     * Возможность купить соответствующий товар в розничном магазине.
     *
     * Возможные значения:
     *    1) false — возможность покупки в розничном магазине отсутствует;
     *    2) true — товар можно купить в розничном магазине.
     * Необязательный элемент.
     *
     * @return string|null
     */
    public function getStore()
    {
        return null;
    }

    /**
     * Возможность зарезервировать выбранный товар и забрать его самостоятельно.
     *
     * Возможные значения:
     *    1) false — возможность «самовывоза» отсутствует;
     *    2) true — товар можно забрать самостоятельно.
     * Необязательный элемент.
     *
     * @return string|null
     */
    public function getPickup()
    {
        return null;
    }

    /**
     * Возможность доставки соответствующего товара.
     *
     * Возможные значения:
     *    - false — товар не может быть доставлен;
     *    - true — товар доставляется на условиях, которые описываются в партнерском интерфейсе на странице
     *      Параметры размещения.
     * Необязательный элемент.
     * @link http://help.yandex.ru/partnermarket/settings/placement.xml#placement
     *
     * @return string|null
     */
    public function getDelivery()
    {
        return 'true';
    }

    /**
     * Стоимость доставки данного товара в своем регионе.
     *
     * Необязательный элемент.
     *
     * @return string|null
     */
    public function getLocal_Delivery_Cost()
    {
        return null;
    }

    /**
     * Название товарного предложения.
     *
     * В названии упрощенного предложения рекомендуется указывать
     * наименование и код производителя.
     * Обязательный элемент.
     *
     * @return string
     */
    public function getName()
    {
        return $this->attributes['name'];
    }

    /**
     * Производитель.
     *
     * Не отображается в названии предложения.
     * Необязательный элемент.
     *
     * @return string|null
     */
    public function getVendor()
    {
        return null;
    }

    /**
     * Код товара (указывается код производителя).
     *
     * Не отображается в названии предложения.
     * Необязательный элемент.
     *
     * @return string|null
     */
    public function getVendorCode()
    {
        return null;
    }

    /**
     * Описание товарного предложения.
     *
     * Длина текста не более 175 символов (не включая знаки препинания), запрещено использовать HTML-теги
     * (информация внутри тегов публиковаться не будет).
     * Необязательный элемент.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->attributes['description'];
    }

    /**
     * Элемент используется для отражения информации о:
     *    - минимальной сумме заказа, минимальной партии товара, необходимости предоплаты
     *     (указание элемента обязательно);
     *    - вариантах оплаты, описания акций и распродаж (указание элемента необязательно).
     * Допустимая длина текста в элементе — 50 символов.
     * Необязательный элемент.
     *
     * @return string
     */
    public function getSales_Notes()
    {
        return null;
    }

    /**
     * Элемент предназначен для отметки товаров, имеющих официальную гарантию производителя.
     *    Необязательный элемент.
     *    Возможные значения:
     *    - false — товар не имеет официальной гарантии;
     *    - true — товар имеет официальную гарантию.
     * Необязательный элемент.
     *
     * @return string|null
     */
    public function getManufacturer_Warranty()
    {
        return null;
    }

    /**
     * Элемент предназначен для указания страны производства товара. Список стран, которые могут быть указаны в этом
     * элементе, доступен по адресу: http://partner.market.yandex.ru/pages/help/Countries.pdf.
     * Примечание. Если вы хотите участвовать в программе «Заказ на Маркете», то желательно указывать данный
     * элемент в YML-файле.
     * Необязательный элемент.
     *
     * @return string|null
     */
    public function getCountry_Of_Origin()
    {
        return null;
    }

    /**
     * Элемент обязателен для обозначения товара, имеющего отношение к удовлетворению сексуальных потребностей,
     * либо иным образом эксплуатирующего интерес к сексу.
     * Необязательный элемент.
     *
     * @return string|null
     */
    public function getAdult()
    {
        return null;
    }

    /**
     * Возрастная категория товара.
     *
     * Годы задаются с помощью атрибута unit со значением year, месяцы — с помощью
     * атрибута unit со значением month.
     * Допустимые значения параметра при unit="year": 0, 6, 12, 16, 18. Допустимые значения параметра при
     * unit="month": 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12.
     * Необязательный элемент.
     *
     * @return string|null
     */
    public function getAge()
    {
        return null;
    }

    /**
     * Штрихкод товара, указанный производителем.
     * Необязательный элемент. Элемент <offer> может содержать несколько элементов <barcode>.
     *
     * @return string|null
     */
    public function getBarcode()
    {
        return null;
    }

    /**
     * Элемент предназначен для управления участием товарных предложений в программе «Заказ на Маркете».
     * Необязательный элемент.
     *
     * @return string|null
     */
    public function getCpa()
    {
        return null;
    }

    /**
     * Элемент предназначен для указания характеристик товара. Для описания каждого параметра используется отдельный
     * элемент <param>.
     * Необязательный элемент. Элемент <offer> может содержать несколько элементов <param>.
     *
     * @return string|null
     */
    public function getParam()
    {
        return null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function findYml()
    {
        $query = self::find();
        $query->orderBy('id');

        return $query;
    }

    public static function tableName()
    {
        return 'item';
    }

    /**
     * Bid.
     *
     * @return integer
     */
    public function getBid()
    {
        return 13;
    }

    /**
     * Cbid.
     *
     * @return integer
     */
    public function getCbid()
    {
        return 20;
    }

    /**
     * Available.
     *
     * @return string
     */
    public function getAvailable()
    {
        if ($this->attributes['is_available']) {
            return 'true';
        }

        return 'false';
    }
}
