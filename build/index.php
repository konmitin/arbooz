<?php

require 'functions.php';

$brends = getFromJSON("brend.json");
$promoAll = getFromJSON("promo.json");
$services = getFromJSON("service.json");

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arbooz</title>

    <link rel="stylesheet" href="css/style.min.css">
</head>

<body>

    <header class="header">
        <div class="header__container container">
            <div class="header__top">
                <a href="/" class="logo">
                    <img src="/img/logo.png" alt="">
                </a>

                <div class="button header__button">
                    <a href="#" class="button__link header__button-link ">Заказать карты</a>
                </div>
            </div>

            <nav class="menu">
                <ul class="menu__list">
                    <li class="menu__item"><a class="menu__link" href="#">Все топливные карты</a></li>
                    <li class="menu__item"><a class="menu__link" href="#">Корпоративные карты</a></li>
                    <li class="menu__item"><a class="menu__link" href="#">Подбор по регионам</a></li>
                    <li class="menu__item"><a class="menu__link" href="#">Акции</a></li>
                    <li class="menu__item"><a class="menu__link" href="#">Рейтинг и сравнение</a></li>
                    <li class="menu__item"><a class="menu__link" href="#">Список сервисов</a></li>
                    <li class="menu__item"><a class="menu__link" href="#">Отзывы</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="main">
        <div class="main__container container">
            <h1 class="main__title title title_h1">Калькулятор тарифов</h1>


            <form action="#" method="POST" class="calculator-form main__content">
                <div class="main__left">
                    <div class="calculator">

                        <div class="region-selector">
                            <div class="region-selector__container">
                                <div class="region-selector__label">
                                    Укажите регион передвижения:

                                    <div class="region-selector__select-custom" data-select-custom='region'>

                                        <span>Ленинградская область</span>

                                        <svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1.20776L6 6.20776L11 1.20776" stroke="#636363" stroke-width="2" />
                                        </svg>


                                    </div>
                                </div>

                                <div class="region-selector__select-custom_hidden" data-select-hidden="region">

                                </div>

                                <select class="region-selector__select" id="region" name="region" data-select='region'>
                                    <option data-select-option='reg1' value="reg1" selected>Ленинградская область</option>
                                    <option data-select-option='reg2' value="reg2">Тульская область</option>
                                    <option data-select-option='reg3' value="reg3">Московская область</option>
                                </select>
                            </div>
                        </div>

                        <div class="slider-range">

                            <div class="slider-range__container">
                                <div class="slider-range__info">
                                    <div class="slider-range__value-block">
                                        <p class="slider-range__text">Прокачка:</p>
                                        <span class="slider-range__value">250 тонн</span>
                                    </div>


                                    <div class="slider-range__progress-block">
                                        <div class="slider-range__track"></div>
                                        <div class="slider-range__progress"></div>
                                        <input name="prokachka" list="steps" type="range" min="0" max="1200" value="600" id="input-range" class="slider-range__input">
                                    </div>
                                </div>

                                <datalist id="steps" class="slider-range__steps">
                                    <option value="0" id="start" class="slider-range__step">0 тонн</option>
                                    <option value="250" id="middle" class="slider-range__step">600 тонн</option>
                                    <option value="500" id="end" class="slider-range__step">1200 тонн</option>
                                </datalist>
                            </div>





                        </div>

                        <div class="fuel-options">
                            <div class="fuel-options__container">

                                <div class="fuel-option active" data-fuel="gasoline">
                                    <input type="radio" id="fuel-gasoline" name="fuel" value="gasoline" checked>
                                    <label for="fuel-gasoline">Бензин</label>
                                </div>
                                <div class="fuel-option" data-fuel="gas">
                                    <input type="radio" id="fuel-gas" name="fuel" value="gas">
                                    <label for="fuel-gas">Газ</label>
                                </div>
                                <div class="fuel-option" data-fuel="dizel">
                                    <input type="radio" id="fuel-dt" name="fuel" value="dizel">
                                    <label for="fuel-dt">ДТ</label>
                                </div>
                            </div>

                        </div>

                        <div data-input='radio' id="brand-options" class="other-options">
                            <h3 class="other-options__title title title_h3">Укажите любимый бренд</h3>



                            <div class="other-options__list">

                                <?php foreach ($brends['gasoline'] as $key => $brend) { 
                                    $isActive = array_key_first($brends['gasoline']) == $key ? "active" : "";
                                    ?>

                                    <div class="other-option <?= $isActive ?>" style="--active-other: <?= $brend['color'] ?>;">
                                        <input type="radio" id="brend-<?= $key ?>" name="brend" value="<?= $key ?>" <?= $isActive ? "checked" : "" ?>>
                                        <label class="other-option__label" for="brend-<?= $key ?>">
                                            <div class="other-option__img-block">
                                                <img src=<?= $brend['img']['def'] ?> alt="">
                                            </div>

                                            <span><?= $brend['title'] ?></span>
                                        </label>
                                    </div>

                                <?php } ?>
                            </div>


                        </div>

                        <div data-input='checkbox' data-input-max="4" id="service-options" class="other-options">
                            <h3 class="other-options__title title title_h3">Дополнительные услуги</h3>

                            <div class="other-options__list">

                                <?php foreach ($services as $key => $service) { ?>

                                    <div class="other-option" style="--active-other: <?= $service['color'] ?>;">
                                        <input type="checkbox" id="service-<?= $key ?>" name="service" value="<?= $key ?>">
                                        <label class="other-option__label" for="service-<?= $key ?>">
                                            <div class="other-option__img-block">
                                                <img src=<?= $service['img']['def'] ?> alt="">
                                            </div>

                                            <span><?= $service['title'] ?></span>
                                        </label>
                                    </div>

                                <?php } ?>
                            </div>


                        </div>

                    </div>
                </div>

                <div class="main__right">

                    <div class="main__right-top">
                        <div class="tariff">
                            <h6 class="tariff__title title title_h6">Подходящий тариф</h6>

                            <div class="tariff__select">
                                <img src="/img/star.svg" alt="">
                                <span data-tariff-title>Премиум</span>
                            </div>

                        </div>

                        <div class="card">
                        </div>

                        <a href="#" class="map-link">
                            <img src="/img/compas.svg" alt="">
                            <span>Сеть АЗС на карте</span>
                        </a>
                    </div>



                    <div data-input='radio' id="promo-options" class="other-options promo">
                        <h3 class="other-options__title other-options__title_center title title_h3">Выберите промо-акцию:</h3>

                        <div class="other-options__list" data-promo-list>

                            <?php foreach ($promoAll['premium'] as $key => $promo) { 
                                $isActive = array_key_first($promoAll['premium']) == $key ? "active" : "";
                                ?>

                                <div class="other-option other-option_big <?= $isActive ?>" style="--active-other: var(--yellow);">
                                    <input type="radio" id="promo-<?= $key ?>" name="promo" value="<?= $key ?>" <?= $isActive ? "checked" : "" ?>>
                                    <label class="other-option__label" for="promo-<?= $key ?>">
                                        <div class="other-option__span-block">
                                            <span> <?= $promo['discount'] ?><b>%</b></span>
                                        </div>

                                        <span><?= $promo['title']  ?></span>
                                    </label>
                                </div>

                            <?php } ?>
                        </div>

                    </div>

                    <div class="main__right-bottom">
                        <div class="economy">
                            <h5 class="economy__title">Ваша экономия:</h5>

                            <div class="economy__content">
                                <div class="economy__date" >
                                    <span class="economy__date-title">экономия в год</span>
                                    <span class="economy__date-result" data-economy-text="year">от 34 млн ₽</span>
                                </div>

                                <div class="economy__date">
                                    <span class="economy__date-title">экономия в месяц</span>
                                    <span class="economy__date-result" data-economy-text="month">от 1 700 000 ₽</span>
                                </div>
                            </div>

                        </div>

                        <button class="submit-button button button__link" type="submit">
                            <span>
                                Заказать тариф «<span class="submit-button__tariff" data-tariff-title>Избранный</span>»
                            </span>
                            <svg width="21" height="11" viewBox="0 0 21 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 5.5H20H1ZM20 5.5L15.4583 1L20 5.5ZM20 5.5L15.4583 10L20 5.5Z" fill="black" />
                                <path d="M20 5.5L15.4583 10M1 5.5H20H1ZM20 5.5L15.4583 1L20 5.5Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>

                        </button>
                    </div>



                </div>

                <select name="tariff" class="calculator-form__select" data-tariff>
                    <option data-tariff-type="premium" value="premium" selected>Премиум</option>
                </select>
            </form>


        </div>

        <?php include_once('result-popup.php') ?>

    </main>

    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/main.min.js"></script>
</body>

</html>