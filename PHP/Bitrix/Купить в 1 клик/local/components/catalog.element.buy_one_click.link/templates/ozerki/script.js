'use strict';
document.addEventListener("DOMContentLoaded", function () {
    const oneClickBtn = document.querySelectorAll('.buy_one_click.element');
    if (oneClickBtn.length > 0) {
        for (let i = 0; i < oneClickBtn.length; i++) {
            const elem = oneClickBtn[i];
            elem.addEventListener('click', openModalOneClick)
            console.log(elem)
        }
    }

    if (window.oneClickHash.isUse()){
        const hash = window.oneClickHash.getHash(true);
        if (hash[1]){
            const useId = hash[1];
            const el = document.querySelector('.one_click_data[data-product="' + useId + '"]')
            if (el){
                const btn = el.closest('.product-cart.one-click').querySelector('.buy_one_click.element')
                if(btn){
                    btn.click();
                }
            }
        }
    }
});


var OneClickHash = (function () {
    function OneClickHash() {
        this._hash = 'oneclick';
    }
    OneClickHash.prototype.add = function (id) {
        if (id.length > 0){
            window.location.hash = this._hash + '__' + String(id);
        }
    };
    OneClickHash.prototype.remove = function () {
        if (this.isUse()) {
            window.location.hash = '';

        }
    };
    OneClickHash.prototype.isUse = function () {
        const hash = this.getHash();
        console.log(hash)
        if (hash === String('#' + this._hash)) {
            return true;
        }
        return false;
    };

    OneClickHash.prototype.getHash = function (id = false) {
        const hash = window.location.hash.split('__');
        if (hash) {
            if (id){
                return hash;
            }
            return hash[0];
        }
        return false;
    };
    return OneClickHash;
})();

window.oneClickHash = new OneClickHash();

function openModalOneClick(e) {

    const elem = e.currentTarget;
    const data = elem.closest('div.one-click').querySelector('span.one_click_data');
    const params = {
        ID: data.getAttribute('data-product'),
        A2005: data.getAttribute('data-product-a2005'),
        TP: data.getAttribute('data-product-tp')
    };

    const xhr = new XMLHttpRequest();
    xhr.responseType = 'json';
    const url = '/local/components/imaginweb/catalog.element.buy_one_click.link/templates/ozerki/getPopup.php';
    const json = JSON.stringify(params);

    xhr.open("POST", url, true);
    xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');

    // xhr.onreadystatechange = function () {
    //
    // };

    xhr.send(json);
    xhr.onload = function () {
        if (window.popupOneClickEnable) return false;
        const response = xhr.response;
        const popupElem = document.createElement('div')
        popupElem.setAttribute('id', 'popupElementOneClick');
        popupElem.innerHTML = response.HTML;
        const scripts = popupElem.querySelectorAll('script')
        window.popupOneClickEnable = true;
        window.oneClickHash.add(params['ID']);
        document.body.appendChild(popupElem)

        if (scripts.length > 0) {
            for (let i = 0; i < scripts.length; i++) {
                const script = scripts[i];
                eval(script.innerHTML)
                script.remove()
            }
        }




    };
}

function closeModalOneClick(e) {
    if (!window.popupOneClickEnable) return false;
    const popups = document.querySelectorAll('#popupElementOneClick');
    window.popupOneClickEnable = false;
    window.oneClickHash.remove();
    for (let i = 0; i < popups.length; i++) {
        const popup = popups[i];
        popup.remove()
    }


}