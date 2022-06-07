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

    echo $basketItem->getField('NAME') . "<br>";

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


?>


<div class="promo">
    <div class="promo__message">

        <?php if ($items_counter >= $required_count ) { ?>
            <p> Подарок добавлен в корзину </p>
        <?php } ?>

        <?php if ($items_counter < $required_count ) { ?>
            <p> Условия акции не выполнены </p>
        <?php } ?>

    </div>
</div>
