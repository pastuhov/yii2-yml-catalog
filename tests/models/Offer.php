<?php
namespace pastuhov\ymlcatalog\Test\models;

use pastuhov\ymlcatalog\SimpleOfferInterface;
use yii\db\ActiveRecord;

/**
 * @inheritdoc
 */
class Offer extends ActiveRecord implements SimpleOfferInterface
{

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
        // TODO: Implement getUrl() method.
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
        // TODO: Implement getPrice() method.
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
        // TODO: Implement getOldPrice() method.
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
    public function getСurrencyId()
    {
        // TODO: Implement getСurrencyId() method.
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
    public function getСategoryId()
    {
        // TODO: Implement getСategoryId() method.
    }

    /**
     * Категория товара, в которой он должен быть размещен на Яндекс.Маркете. Допустимо указывать названия категорий
     * только из товарного дерева категорий Яндекс.Маркета.
     * Необязательный элемент.
     * @link http://download.cdn.yandex.net/support/ru/partnermarket/files/market_categories.xls
     *
     * @return string
     */
    public function getMarketCategory()
    {
        // TODO: Implement getMarketCategory() method.
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
        // TODO: Implement getPicture() method.
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
        // TODO: Implement getStore() method.
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
        // TODO: Implement getPickup() method.
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
        // TODO: Implement getDelivery() method.
    }

    /**
     * Стоимость доставки данного товара в своем регионе.
     *
     * Необязательный элемент.
     *
     * @return string|null
     */
    public function getLocalDeliveryCost()
    {
        // TODO: Implement getLocalDeliveryCost() method.
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
        // TODO: Implement getName() method.
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
        // TODO: Implement getVendor() method.
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
        // TODO: Implement getVendorCode() method.
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
        // TODO: Implement getDescription() method.
    }

    /**
     * Элемент используется для отражения информации о:
     *    - минимальной сумме заказа, минимальной партии товара, необходимости предоплаты
     *     (указание элемента обязательно);
     *    - вариантах оплаты, описания акций и распродаж (указание элемента необязательно).
     * Допустимая длина текста в элементе — 50 символов.
     *
     * @return string
     */
    public function getSalesNotes()
    {
        // TODO: Implement getSalesNotes() method.
    }

    /**
     * Элемент предназначен для отметки товаров, имеющих официальную гарантию производителя.
     *    Необязательный элемент.
     *    Возможные значения:
     *    - false — товар не имеет официальной гарантии;
     *    - true — товар имеет официальную гарантию.
     *
     * @return string
     */
    public function getManufacturerWarranty()
    {
        // TODO: Implement getManufacturerWarranty() method.
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
    public function getCountryOfOrigin()
    {
        // TODO: Implement getCountryOfOrigin() method.
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
        // TODO: Implement getAdult() method.
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
        // TODO: Implement getAge() method.
    }

    /**
     * Штрихкод товара, указанный производителем.
     * Необязательный элемент. Элемент <offer> может содержать несколько элементов <barcode>.
     *
     * @return string|null
     */
    public function getBarcode()
    {
        // TODO: Implement getBarcode() method.
    }

    /**
     * Элемент предназначен для управления участием товарных предложений в программе «Заказ на Маркете».
     * Необязательный элемент.
     *
     * @return string|null
     */
    public function getCpa()
    {
        // TODO: Implement getCpa() method.
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
        // TODO: Implement getParam() method.
    }
}