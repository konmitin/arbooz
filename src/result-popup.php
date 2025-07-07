<div class="result-popup">
    <div class="result-popup__container">
        <h6 class="result-popup__title">Заказать тариф «<span data-tariff-title>Избранный</span>» </h6>

        <span class="result-popup__close"></span>
        <form class="result-popup__form">
            <label class="result-popup__label">
                <span class="result-popup__error"></span>
                <input class="result-popup__input" type="number" name="inn" placeholder="Номер ИНН" required value="">
            </label>

            <label class="result-popup__label">
                <span class="result-popup__error"></span>
                <input class="result-popup__input" type="number" name="phone" placeholder="Телефон для связи" required value="">
            </label>

            <label class="result-popup__label">
                <span class="result-popup__error"></span>
                <input class="result-popup__input" type="email" name="email" placeholder="E-mail для связи" required value="">
            </label>

            <div class="result-popup__checkbox">
                <input class="result-popup__checkbox-input" type="checkbox" id="agreement" name="agreement" required checked>
                <label class="result-popup__checkbox-label" for="agreement">
                    Согласен с обработкой персональных данных
                </label>
            </div>
            <button class="result-popup__button submit-button button button__link" type="submit">Заказать тариф «Избранный»</button>
            <span class="result-popup__success">
                Спасибо! Успешно отправлено.
            </span>
        </form>
    </div>

</div>