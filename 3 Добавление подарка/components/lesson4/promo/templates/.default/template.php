<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>

<?php

use Bitrix\Main\Context;
use Bitrix\Main\Loader;
use Bitrix\Sale\Fuser;
use CBitrixComponent;
use Bitrix\Sale\Basket;
use Bitrix\Main\Localization\Loc;

?>

<?php

$gift_value = 500;
$items_counter = 0;
$gift_product_id = 323;
$quantity = 1;
$required_count = 3;

$basket = Basket::loadItemsForFUser(Fuser::getId(),Context::getCurrent()->getSite());

$basketItems = $basket->getBasketItems();

foreach ($basketItems as $basketItem ) {

    $price = $basketItem->getField('PRICE');

    if ($price >= $gift_value) {
        $items_counter += 1;
    }

    if ($items_counter >= ($required_count)){

        $fields = [
            'PRODUCT_ID' => $gift_product_id ,
            'QUANTITY' => 1,
        ];

        $r = Bitrix\Catalog\Product\Basket::addProduct($fields);

        break;
    }

}

if (isset($_GET['count']) && ($_GET['count']>0)){

    $gifts_count = htmlspecialchars($_GET['count']);

    $fields = [
        'PRODUCT_ID' => $gift_product_id ,
        'QUANTITY' => $gifts_count,
    ];

$s = Bitrix\Catalog\Product\Basket::addProduct($fields);

}


?>


<div class="promo">
    <div class="promo__message">
       <?php if ($items_counter >= $required_count ) { ?>
            <p> Условие акции выполенено. Подарок добавлен в корзину </p>
        <?php } ?>

        <?php if ($items_counter < $required_count ) { ?>
            <p> Условия акции не выполнены </p>
        <?php } ?>
    </div>

    <div class="promo__form" style="margin-top: 40px;">
    <form action="" method="get">
        <p>Xочу столько: <input type="number" name="count" placeholder="Количество подарков" style="min-width: 280px;"/></p>
        <p><input type="submit" /></p>
    </form>
    </div>


</div>
