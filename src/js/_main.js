"use strict"

function fetchOnInputEnd() {
    let num = 0;
    return function (callback) {
        num++;

        setTimeout(() => {
            num--;

            if (num == 0) {
                callback();
            }
        }, 1000);

        return;
    };
}

let onInputEnd = fetchOnInputEnd();

$(document).ready(() => {

    $(".region-selector__select").on('select', (event) => {

        onInputEnd(() => {

            $.post(
                '/controllers/region.php',
                {
                    region: event.target.value
                },
                (response) => {

                    response = JSON.parse(response);

                    updateMaxOil(response['max_oil']);

                    updateEconomy();

                });
        });



    });

    $(".slider-range__progress").css('--value', $(".slider-range__input").val());
    $(".slider-range__progress").css('--max', $(".slider-range__input").attr('max'));

    $(".slider-range__value").text($(".slider-range__input").val() + " тонн");

    createCustomSelect();

    updateEconomy();

    setEvent();

    $(".calculator-form").off('submit').on('submit', (event) => {

        event.preventDefault();

        $(".result-popup").addClass('active');

    });



    $(".result-popup__input").on("input", (event) => {
        $(event.target).removeClass('error');
        $(event.target).removeClass('error');

        $(event.target).siblings().removeClass("show");
        $(event.target).siblings().text("");
    });

    $(".result-popup__close").on("click", (event) => {

        $(".result-popup").removeClass('active');

    });

    $(".result-popup__form").on('submit', (event) => {

        event.preventDefault();

        let form = $(event.target);
        let error = 0;


        let inputINN = form.find("input[name='inn']");
        let inputPhone = form.find("input[name='phone']");

        if (inputINN.val().length != 12) {
            inputINN.addClass('error');
            inputINN.siblings().addClass("show");
            inputINN.siblings().text("Ошибка: должно быть 12 цифр, а у вас " + inputINN.val().length);
            error++;
        }

        if (inputPhone.val().length != 11) {
            inputPhone.addClass('error');
            inputPhone.siblings().addClass("show");
            inputPhone.siblings().text("Ошибка: должно быть 11 цифр, а у вас " + inputPhone.val().length);
            error++
        }


        if (error <= 0) {

            form.find("button").prop("disabled", true);
            form.find(".result-popup__success").removeClass("show");

            let formString = $(".calculator-form").serialize();

            let data = {};

            let formArr = formString.split("&");

            formArr.forEach((elem) => {

                let inputValueArr = elem.split("=");

                if (!(data[inputValueArr[0]] instanceof Object)) {
                    data[inputValueArr[0]] = [];
                }

                data[inputValueArr[0]].push(inputValueArr[1]);


            });

            tariff = $("[data-tariff]").val();
            promo = $("#promo-options").find("input:checked").val();


            onInputEnd(() => {
                $.post(
                    '/controllers/sendmail.php',
                    {
                        data: {
                            region: data['region'][0],
                            prokachka: data['prokachka'][0],
                            fuel_type: data['fuel'][0],
                            fuel_brend: data['brend'][0],
                            other_services: data['service'],
                            tariff: data['tariff'][0],
                            promo: data['promo'][0],
                            inn: form.find("[name='inn']").val(),
                            phone: form.find("[name='phone']").val(),
                            email: form.find("[name='email']").val()
                        }
                    },
                    (response) => {

                        form.find("button").prop("disabled", false);
                        form.find(".result-popup__success").addClass("show");


                    });

                
            });
        }

        console.log(inputINN);

    });



});

async function getEconomy(data) {

    let response = await $.post(
        '/controllers/calc.php',
        {
            data: data
        });

    return JSON.parse(response);
}

async function updateEconomy() {

    let oilValue = $(".slider-range").find("input").val();
    let fuelType = $(".fuel-options").find("input:checked").val();
    let promo = $("#promo-options").find("input:checked").val();
    let tariff = $("[data-tariff]").val();

    let data = {
        'oil_value': oilValue,
        'fuel_type': fuelType,
        'tariff': tariff,
        'promo': promo,
    }

    let response = await getEconomy(data);

    let formatter = new Intl.NumberFormat("ru", {
        useGrouping: true
    });

    let year = formatter.format(Math.floor(response['economy']['year'] / 1000000));

    let month = formatter.format(response['economy']['month']);



    $("[data-economy-text='year']").text(`от ${year} млн ₽`);
    $("[data-economy-text='month']").text(`от ${month} ₽`);

}

function updateMaxOil(maxOil) {

    $(".slider-range__input").attr("max", maxOil);

    let center = Math.floor(maxOil / 2);

    $(".slider-range__input").val(center).trigger('input');

    $(".slider-range__step#middle").val(center);
    $(".slider-range__step#middle").text(center + " тонн");


    $(".slider-range__step#end").val(maxOil);
    $(".slider-range__step#end").text(maxOil + " тонн");

    $(".slider-range__progress").css('--max', $(".slider-range__input").attr('max'));

    console.log($(".slider-range__input"));

}

function setEvent() {

    $(".slider-range__input").off('input').on('input', (event) => {

        $(".slider-range__progress").css('--value', event.target.value);

        $(".slider-range__value").text($(".slider-range__input").val() + " тонн");

        onInputEnd(() => {

            $.post(
                '/controllers/tariff.php',
                {
                    fuel: {
                        input: event.target.value,
                        type: $(".fuel-options").find('input:checked').val()
                    }
                },
                (response) => {

                    updateTariff(JSON.parse(response));

                    updateEconomy();

                });
        });

    });


    $("[data-select-custom]").off('click').on('click', (event) => {

        $("[data-select-hidden='" + event.currentTarget.getAttribute('data-select-custom') + "']").toggleClass('show');

    });

    $('[data-select-o-custom]').off('click').on('click', (event) => {

        const parent = $(event.currentTarget).parent('[data-select-hidden]');

        parent.removeClass('show');

        const select = $("[data-select='" + parent.attr('data-select-hidden') + "']");

        select.find('option').prop('selected', false);

        const option = select.find("[data-select-option='" + event.currentTarget.getAttribute('data-select-o-custom') + "']");

        option.prop('selected', true);
        option.select();

        $('[data-select-custom]').find('span').text(option.text());

    });


    $(".fuel-option").off('click').on('click', (event) => {

        $(".fuel-option").removeClass('active');

        $(event.currentTarget).addClass('active');

        $(event.currentTarget).find('input').prop("checked", true);

        onInputEnd(() => {

            $.post(
                '/controllers/tariff.php',
                {
                    fuel: {
                        input: $(".slider-range").find('input').val(),
                        type: $(event.currentTarget).find('input:checked').val()
                    }
                },
                (response) => {

                    updateTariff(JSON.parse(response));

                    updateEconomy();

                });
        });

    });

    $(".other-option").off('input').on('input', (event) => {

        switch ($(event.currentTarget).parent().parent().attr('data-input')) {

            case "radio":
                $(event.currentTarget).parent().parent().find('.other-option').removeClass('active');
                $(event.currentTarget).addClass('active');
                break;

            case "checkbox":

                let max = $(event.currentTarget).parent().parent().attr('data-input-max');
                let length = $(event.currentTarget).parent().parent().find('.other-option.active').length;

                if (length < max || max == undefined) {

                    $(event.currentTarget).toggleClass('active');

                } else {
                    $(event.currentTarget).removeClass('active');
                    $(event.target).prop('checked', false)
                }

                break;

        }


    });

}

function updateTariff(tariffArr) {

    $("[data-tariff-title]").text(tariffArr.title);

    let select = $("[data-tariff");
    select.find('option').prop("selected", false);
    let option = `<option data-tariff-type="${tariffArr.type}" value="${tariffArr.type}" selected>${tariffArr.title}</option>`;

    select.text("");
    select.append(option);

    setEvent();

    updatePromo(tariffArr.promo);

}

function updatePromo(promoArr) {

    let promoList = $("[data-promo-list]");

    promoList.text("");

    for (promoKey in promoArr) {

        let isActive = Object.keys(promoArr)[0] == promoKey ? "active" : "";

        let promoElement = `
            <div class="other-option other-option_big ${isActive}" style="--active-other: var(--yellow);">
                <input type="radio" id="promo-${promoKey}" name="promo" value="${promoKey}" ${isActive ? "checked" : ""}>
                <label class="other-option__label" for="promo-${promoKey}">
                    <div class="other-option__span-block">
                        <span> ${promoArr[promoKey].discount}<b>%</b></span>
                    </div>

                    <span>${promoArr[promoKey].title}</span>
                </label>
            </div>`;

        promoList.append(promoElement);

    };

    setEvent();


}

function createCustomSelect() {


    const options = $('[data-select]').children();

    let customOptions;


    $.each(options, (key, option) => {

        let customOption = $("<span>");

        customOption.attr('data-select-o-custom', option.getAttribute('data-select-option'));
        customOption.text(option.text);

        $('[data-select-hidden]').append(customOption);
    });
}



