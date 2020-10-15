<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var array $arParams
 * @var array $arResult
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @var string $templateName
 * @var string $componentPath
*/

$svg = "<svg width=\"23\" height=\"28\" viewBox=\"0 0 23 28\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">
<path d=\"M9.72498 22.76L9.65784 9.18075L21.391 16.017C22.1761 16.4745 21.9935 17.6573 21.107 17.8567L17.4571 18.6775L20.3971 23.7639C20.6734 24.2421 20.5099 24.8538 20.0317 25.1301L18.3001 26.131C17.822 26.4074 17.2103 26.2438 16.9339 25.7656L13.9939 20.6792L11.4609 23.4322C10.8456 24.1009 9.72947 23.6687 9.72498 22.76Z\" fill=\"black\"/>
<path d=\"M5.65439 2.25455L7.65609 5.71766M1.27789 7.67176L5.62672 9.20071M5.64665 13.2318L1 14.185M12.9659 0.916016L12.1201 5.44752M15.6031 7.4769L18.7485 3.92631M9.65784 9.18075L9.72498 22.76C9.72947 23.6687 10.8456 24.1009 11.4609 23.4322L13.9939 20.6792L16.9339 25.7656C17.2103 26.2438 17.822 26.4074 18.3001 26.131L20.0317 25.1301C20.5099 24.8538 20.6734 24.2421 20.3971 23.7639L17.4571 18.6775L21.107 17.8567C21.9935 17.6573 22.1761 16.4745 21.391 16.017L9.65784 9.18075Z\" stroke=\"white\" stroke-width=\"2\"/>
</svg>
"

?>
<div class="product-cart one-click">
    <a class="buy_one_click element" data-action="buyOneClick" href="javascript:void(0)"><span class="one_click_img"><?=$svg?></span><span class="one_click_text">Забронировать в 1 клик</span></a>
    <span class="one_click_data" data-product="<?=$arResult['ITEM']['ID']?>" data-product-a2005="<?=$arResult['ITEM']['A2005']?>"  data-product-tp="<?=$arResult['ITEM']['TP']?>"></span>
</div>

