<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var CBitrixComponentTemplate $this
 * @var array $arParams
 * @var array $arResult
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @var string $templateName
 * @var string $componentPath
 */
?>
<link rel="stylesheet" type="text/css"
      href="/local/components/imaginweb/catalog.popup.buy_one_click/templates/ozerki/style.css">

<div class="remodal-overlay2 remodal-is-opened one-click-popup" style="display: block;"></div>
<div class="remodal-wrapper remodal-is-opened one-click-popup" style="display: block">
    <div class="remodal modal proposals-modal   remodal-is-initialized remodal-is-opened" data-remodal-id="writeToUs">

        <!-- Контент модалки -->
        <div class="modal__content proposals-modal__content">

            <!-- Заголовок -->
            <div class="proposals-modal__header">
                <div class="proposals-modal__close" data-remodal-action="close">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 13L13 1M13 13L1 1" stroke="#171717" stroke-width="2"/>
                    </svg>
                </div>
                <p id="headerTextOneClick">Забронировать в 1 клик</p>
            </div>

            <!-- Главный контент -->
            <div class="proposals-modal__main" id="bodyTextOneClick">
                <!-- Предупреждение -->
                <div class="proposals-modal_form-warning">
                        <span class="proposals-modal_form-warning-text">
                            Внимание! Цена товара действительна только при оформлении заказа на сайте!
                        </span>
                </div>
                <!-- Форма - основная -->
                <form action="" class="proposals-modal__form js-validate js-feedback-form" id="buyOneClickForm">

                    <!-- Общая часть формы -->
                    <div class="proposals-modal__form-item">

                        <div class="proposals-item-wrap">
                            <div class="proposals-item-list">

                                <div class="proposals-item-img">
                                    <img src="<?= $arResult['ITEM']['IMG'] ?>"
                                         data-src="<?= $arResult['ITEM']['IMG'] ?>"
                                         alt="<?= $arResult['ITEM']['NAME'] ?>"
                                         itemprop="image" class="">
                                </div>

                                <div class="proposals-item-title">
                                    <div class="proposals-item-brand">
                                        <span><?= $arResult['ITEM']['BRAND']['NAME'] ?></span>
                                    </div>
                                    <div class="proposals-item-name">
                                        <span><?= $arResult['ITEM']['NAME'] ?></span>
                                    </div>
                                    <div class="proposals-item-available">
                                        <span>Доступно <span id="availableCount"> <?= $arResult['ITEM']['COUNT'] ?> шт.</span></span>
                                    </div>
                                </div>
                                <div class="proposals-item-info">
                                    <div class="proposals-item-count">
                                        <div class="item-count-minus item-count-num"><span>-</span></div>
                                        <div class="item-count-input"><span><input type="text" name="COUNT"
                                                                                   value="0"></span></div>
                                        <div class="item-count-plus item-count-num"><span>+</span></div>
                                    </div>
                                    <div class="proposals-item-price">
                                        <span class="item-price-rub"><?= $arResult['ITEM']['FORMAT_PRICE'][0] ?></span>
                                        <span class="item-price-kop"><?= $arResult['ITEM']['FORMAT_PRICE'][1] ?></span>
                                        <span class="item-price-cur">₽</span>
                                    </div>
                                </div>
                            </div>
                            <div class="proposals-item-line"></div>
                            <div class="proposals-item-total-wrap" style="margin-bottom: 0">
                                <div class="proposals-item-errors" id="buyOneClickErrors">

                                </div>
                                <div class="proposals-item-total">

                                    <div class="proposals-item-total-count">
                                        <span>0</span>
                                    </div>
                                    <div class="proposals-item-total-text">
                                        <span><span id="sklonenieTovara">товаров</span> стоимостью</span>
                                    </div>
                                    <div class="proposals-item-total-price">
                                        <span class="item-price-rub">0</span>
                                        <span class="item-price-kop">00</span>
                                        <span class="item-price-cur">₽</span>
                                    </div>
                                </div>
                            </div>
                            <div class="proposals-item-line"></div>
                            <div class="proposals-item-pharmacy-wrap">
                                <div class="proposals-item-pharmacy-text" id="">

                                    <? if (!empty($arResult['ITEM']['STORE']) && !empty($arResult['ITEM']['STORE_INFO'])): ?>
                                        <div class="pharmacy_zagalovok">Аптека</div>
                                        <div class="metro_info_one_click">
                                            <div class="metro_logo_one_click">
                                                <svg width="12" height="7" viewBox="0 0 12 7" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     style="position: absolute;margin-left: 5.2px;margin-top: 7px;">
                                                    <path d="M5.70577 7L7.55938 4.19287L8.32845 6.094H7.70774V6.93019H11.4098V6.094H10.7039L8.04367 0L5.70577 3.75175L3.36617 0L0.705974 6.094H0V6.93019H3.7021V6.094H3.08139L3.85046 4.19287L5.70577 7Z"
                                                          fill="white"/>
                                                </svg>
                                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="11" cy="11" r="11" fill="#FFDB1C"/>
                                                </svg>


                                            </div>
                                            <div class="metro_name_one_click">
                                                <?= str_replace('м. ', '',
                                                    $arResult['ITEM']['STORE_INFO']['METRO_INFO']['NAME']) ?>
                                            </div>
                                        </div>
                                        <div class="pharmacy_address_one_click">
                                            <?= $arResult['ITEM']['STORE_INFO']['PROPERTY']['ADDRESS'] ?>
                                        </div>
                                        <div class="one_click_datetime"><?= $arResult['ITEM']['STORE_INFO']['PROPERTY']['MODE_WORK'] ?></div>
                                </div>
                                <div class="proposals-item-pharmacy">
                                    <div class="proposals-item-pharmacy-btn">
                                        <button class="proposals-modal__verify-button g-button g-button-green" id="selectedPharmacy"
                                                type="button">Изменить
                                        </button>
                                    </div>
                                </div>
                                    <? else: ?>
                                        <span>Для бронирования необходимо выбрать аптеку:</span>
                                </div>
                                <div class="proposals-item-pharmacy">
                                    <div class="proposals-item-pharmacy-btn">
                                        <button class="proposals-modal__verify-button g-button" id="selectedPharmacy"
                                                type="button">Выбрать аптеку
                                        </button>
                                    </div>
                                </div>
                                    <? endif; ?>

                            </div>
                        </div>

                    </div>
                    <input type="hidden" name="PRODUCT" value="<?= $arResult['ITEM']['ID'] ?>">
                    <input type="hidden" name="PRICE" value="<?= $arResult['ITEM']['PRICE'] ?>">
                    <input type="hidden" name="PRICE" value="<?= $arResult['ITEM']['PRICE'] ?>">
                    <input type="hidden" name="PRICE_STOCK" value="<?= $arResult['ITEM']['PRICE_STOCK'] ?>">
                    <input type="hidden" name="STORE" value="<?= $arResult['ITEM']['STORE'] ?>">
                    <input type="hidden" name="STOCK_STORE" value="<?= $arResult['ITEM']['STOCK_STORE'] ?>">
                    <input type="hidden" name="USE_STOCK" id="useStock" value="0">
                </form>
            </div>

            <!-- Блок подтверждения личности -->
            <div class="proposals-modal__verify" id="footerOneClick">

                <!-- На какой номер отправляем -->
                <div class="proposals-modal__verify-information proposals-modal__col">
                    <span>Контактный телефон</span>
                    <svg width="8" height="7" viewBox="0 0 8 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.374 3.46L6.174 5.782L5.436 6.322L4.05 4.108L2.664 6.304L1.908 5.764L3.708 3.46L3.582 0.561999H4.518L4.374 3.46ZM3.402 3.01V3.406L3.204 3.658L0.972 3.064L1.278 2.182L3.402 3.01ZM7.146 3.082L4.896 3.658L4.68 3.406V3.01L6.84 2.182L7.146 3.082Z"
                              fill="#ED1C24"></path>
                    </svg>
                </div>

                <!-- Форма ввода кода и отправки -->
                <form class="proposals-modal__verify-form proposals-modal__col">
                    <div class="proposals-modal__verify-wrapper">

                        <!-- Поле для ввода кода -->
                        <div class="proposals-modal__verify-input">
                            <div class="form__field input">
                                <div class="input__box">
                                    <input class="input__control g-input" type="text" id="numberPhoneOneClick"
                                           name="PHONE" required=""
                                           aria-required="true">
                                </div>
                                <span class="form__error"></span>
                                <label class="checkbox checkbox_big">
                                    <span class="checkbox__box">
                                        <input class="checkbox__control" type="checkbox" id="agreeRules" checked name="agree">
                                        <span class="checkbox__indicator"></span>
                                    </span>
                                    <span class="checkbox__content">Я согласен с правилами сайта</span>
                                </label>
                            </div>
                        </div>


                        <!-- Подтверждение -->
                        <button class="proposals-modal__verify-button g-button" disabled id="oneClickSubmit"
                                type="submit">
                            Забронировать
                        </button>
                    </div>
                </form>
            </div>
            <!--            <div class="popup_choose-map-oneClick"></div>-->

        </div>
    </div>

</div>


<script type="text/javascript">
    const popupOverlay = document.querySelector('.one-click-popup.remodal-overlay2');
    const popupWrap = document.querySelector('.one-click-popup.remodal-wrapper');
    const close = popupWrap.querySelector('.proposals-modal__close');
    const totalCount = <?=$arResult['ITEM']['COUNT'] ?: 0 ?>;
    const totalCountInPharmacy = <?=$arResult['ITEM']['COUNT_PHARMACY'] ?: 0 ?>;
    const minPrice = <?=$arResult['ITEM']['PRICE'] ?: 0 ?>;
    $('#numberPhoneOneClick').inputmask("+7(999)999-9999");
    // console.log(popupOverlay)
    close.addEventListener('click', closeModalOneClick);

    popupWrap.addEventListener('click', function (e) {
        if (e.target.classList.contains('remodal-wrapper')) {
            closeModalOneClick();
        }
    });

    function setProductTotalPriceAndCount(e, value) {
        const sklonenieTovara = e.currentTarget.closest('.proposals-item-wrap').querySelector('#sklonenieTovara');
        const useStock = e.currentTarget.closest('form').querySelector('#useStock');
        const total = e.currentTarget.closest('.proposals-item-wrap').querySelector('.proposals-item-total-count');
        const totalPriceWrap = e.currentTarget.closest('.proposals-item-wrap').querySelector('.proposals-item-total-price');
        const totalPriceRub = totalPriceWrap.querySelector('.item-price-rub');
        const totalPriceKop = totalPriceWrap.querySelector('.item-price-kop');

        const totalPrice = String(minPrice * value);
        const splitPrice = totalPrice.split('.');
        const kopFormat = String(Math.round(Math.round(Number('0.' + (splitPrice[1] ? splitPrice[1] : '0')) * 1000) / 10));

        const tovara = [2, 3, 4];
        const endNumberCount = value % 10;

        total.innerText = String(value);

        totalPriceRub.innerText = splitPrice[0];
        totalPriceKop.innerText = (kopFormat.length == 1 ? '0' + kopFormat : kopFormat);
        if (value > totalCountInPharmacy) {
            useStock.value = '1';
        } else {
            useStock.value = '0';
        }
        let simbol = '0';
        if (value > 10) {
            const valStr = String(value)
            simbol = (valStr.slice(valStr.length - 2, valStr.length - 1))
        }
        if (tovara.indexOf(endNumberCount) != -1 && Number(simbol) != 1) {
            sklonenieTovara.innerText = 'товара';
        } else if (endNumberCount == 1 && Number(simbol) != 1) {
            sklonenieTovara.innerText = 'товар';

        } else {
            sklonenieTovara.innerText = 'товаров';
        }
    }

    function productCountChange(e, action) {
        const input = e.currentTarget.closest('.proposals-item-count').querySelector('.item-count-input input');

        let value = Number(input.value);
        if (!value || value < 0) {
            value = 0;
        }
        switch (action) {
            case 'plus':
                value++;
                break;
            case 'minus':
                value--;
                if (value < 0) {
                    value = 0;
                }
                break;
            default:
                return false;
        }
        if (value > totalCount) {
            value = totalCount
        }
        statusSendBtnOneClick(value, document.querySelector('#numberPhoneOneClick').value);
        input.value = value;
        input.setAttribute('value', String(value))
        setProductTotalPriceAndCount(e, value);


    }
    window.productCountAdd = function(count = 1) {
        const addBtn = document.querySelector('.item-count-plus.item-count-num');
        for (let i = 0; i < count; i++){
            addBtn.click()
        }
    }

    function productCountFilter(e) {
        const input = (e.currentTarget);

        let value = Number(input.value);
        if (!value || value < 0) {
            value = 0;

        }
        if (value > totalCount) {
            value = totalCount
        }
        statusSendBtnOneClick(value, document.querySelector('#numberPhoneOneClick').value);
        input.value = value;
        input.setAttribute('value', String(value))
        setProductTotalPriceAndCount(e, value);
    }

    function selectedPharmacyOneClick(e) {
        e.preventDefault()
        selectPharmacyPopupNalich(<?=$arResult['ITEM']['ID']?>)
    }

    function statusSendBtnOneClick(value = 0, phone = '') {

        const successBall = 3;
        let ball = 0;
        if (!value || value < 0) {
            value = 0;
        }
        value = Number(value);
        if (value > 0) {
            ball++;
        }
        const re = /[_\-()]/gi;
        const str = String(phone);
        const phoneClear = str.replace(re, '');
        if (phoneClear.length == 12) {
            ball++;
        }

        const agreeRules = document.querySelector('#agreeRules');
        if (agreeRules.checked == true){
            ball++;
        }
        if (ball >= successBall) {
            document.querySelector('#oneClickSubmit').disabled = false
        } else {
            document.querySelector('#oneClickSubmit').disabled = true
        }

    }

    function orderBuyOneClickSend(e) {
        e.preventDefault();

        const errorBlock = document.querySelector('#buyOneClickErrors');
        const PHONE = document.querySelector('#numberPhoneOneClick').value;
        const form = document.querySelector('#buyOneClickForm');
        $(form).addPreloader();
        const params = {
            PHONE
        };

        for (let i = 0; i < form.elements.length; i++) {
            const elem = form.elements[i];
            params[elem.name] = elem.getAttribute('value');
        }
        console.log(params)
        const xhr = new XMLHttpRequest();
        xhr.responseType = 'json';
        const url = '/local/components/imaginweb/catalog.popup.buy_one_click/send.php';
        const json = JSON.stringify(params);
        errorBlock.innerHTML = '';
        xhr.open("POST", url, true);
        xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');

        xhr.send(json);
        xhr.onload = function () {
            $(form).removePreloader();
            const response = xhr.response;
            for (let i = 0; i < response.fields.length; i++) {
                let field = response.fields[i];
                if (!field) {
                    continue;
                }
                let fieldInput = document.querySelector('.one-click-popup input[name=' + field + ']');

                if (fieldInput.classList.length > 0 && fieldInput.classList.contains('errorField')) {
                    fieldInput.classList.remove('errorField');
                }

            }
            if (response.error && response.error.length > 0) {
                for (let i = 0; i < response.error.length; i++) {
                    let error = response.error[i];
                    if (!error) continue;
                    let errorField = document.querySelector('.one-click-popup input[name=' + error.field + ']');
                    errorField.classList.add('errorField');
                    errorBlock.innerHTML += '<span>' + error.message + '</span>'

                }
            } else if (response.status) {
                document.querySelector('#headerTextOneClick').innerHTML = response.headerText
                document.querySelector('#bodyTextOneClick').innerHTML = response.html
                document.querySelector('#footerOneClick').remove()
            }
            console.log(response)

        };


    }

    document.querySelector('.item-count-plus.item-count-num').addEventListener('click', function (e) {
        productCountChange(e, 'plus');
    });

    document.querySelector('.item-count-minus.item-count-num').addEventListener('click', function (e) {
        productCountChange(e, 'minus')
    });

    document.querySelector('.item-count-input input').addEventListener('keyup', productCountFilter);
    document.querySelector('.item-count-input input').addEventListener('change', productCountFilter);
    document.querySelector('#numberPhoneOneClick').addEventListener('keyup', function (e) {
        setTimeout(function () {
            const number = document.querySelector('#numberPhoneOneClick').value;
            const value = document.querySelector('.item-count-input input').value;
            statusSendBtnOneClick(value, number);
        }, 50)


    })

    document.querySelector('#agreeRules').addEventListener('change', function () {
        const number = document.querySelector('#numberPhoneOneClick').value;
        const value = document.querySelector('.item-count-input input').value;
        statusSendBtnOneClick(value, number)
    })
    // document.querySelector('#numberPhoneOneClick').addEventListener('input', function (e) {
    //     const number = e.currentTarget.value;
    //     const value = document.querySelector('.item-count-input input').value;
    //     statusSendBtnOneClick(value, number)
    // })


    document.querySelector('#selectedPharmacy').addEventListener('click', selectedPharmacyOneClick)
    document.querySelector('#oneClickSubmit').addEventListener('click', orderBuyOneClickSend)

    productCountAdd();

</script>
