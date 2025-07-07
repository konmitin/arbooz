<?php

ini_set('display_errors', 0);

require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';
require '../functions.php';
require '../config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// === Обработка входных данных ===

$regionInfo = getFromJSON("./../region.json");
$brends = getFromJSON("./../brend.json");
$services = getFromJSON("./../service.json");
$promoAll = getFromJSON("./../promo.json");

$data = $_POST['data'];

$inn = $data['inn'];
$phone = $data['phone'];
$email = $data['email'];

if (!preg_match("/@/", $email)) {
    echo json_encode(['message' => "Email введен неверно!"]);

    die();
}

$region = $regionInfo[$data['region']]['title'];

$brend = $brends[$data['fuel_type']][$data['fuel_brend']]['title'];

$fuel_type = str_replace("gasoline", "Бензин", $data['fuel_type']);
$fuel_type = str_replace("gas", "Газ", $fuel_type);
$fuel_type = str_replace("dizel", "ДТ", $fuel_type);

$tariff = str_replace("economy", "Эконом", $data['tariff']);
$tariff = str_replace("favorite", "Избранный", $tariff);
$tariff = str_replace("premium", "Премиум", $tariff);

$promo = $promoAll[$data['tariff']][$data['promo']]['title'];

$calcData = calcEconomy(
    $data['fuel_type'],
    $data['prokachka'],
    $data['tariff'],
    $data['promo'],
);

$discountProzent = $calcData['economy']['month'] / $calcData['price'] * 100;

$discountProzent = number_format($discountProzent, 2, ",", " ");
$price = number_format($calcData['price'], 2, ",", " ");

$economyMonth = number_format($calcData['economy']['month'], 2, ",", " ");
$economyYear = number_format($calcData['economy']['year'], 2, ",", " ");

$otherServices = "";

foreach ($data['other_services'] as $value) {
    $otherServices .= $services[$value]['title'] . "/";
}

// ===


if (empty($data)) {

    $response = ['message' => "Пустой запрос!"];

    header('Content-type: application/json');
    echo json_encode($response);
} else {

    $title = 'Результаты расчетов';
    $body = <<<HTML
            <h2>Результаты расчетов:</h2>
            <b>Регион:</b> $region <br>
            <b>Прокачка:</b> {$data['prokachka']}<br>
            <b>Тип топлива:</b> $fuel_type<br>
            <b>Бренд:</b> $brend<br>
            <b>Дополнительные услуги:</b> $otherServices<br>
            <b>Тариф:</b> $tariff<br>
            <b>Промо-акция:</b> $promo<br>
            <b>Стоимость топлива в месяц:</b> $price<br>
            <b>Суммарная скидка %:</b> $discountProzent<br>
            <b>Экономия в месяц:</b> $economyMonth<br>
            <b>Экономия в год:</b> $economyYear<br>

            <h3>Введенные данные:</h3>
            <b>ИНН:</b> $inn<br>
            <b>Телефон:</b> $phone<br>
            <b>Email:</b> $email<br>
            HTML;

    // Настройка
    $myaddres = EMAIL_ADDRESS;

    $mail = new PHPMailer();

    $mail->CharSet      = "UTF-8";
    $mail->setLanguage('ru', 'phpmailer/language/');

    $mail->isSMTP();
    $mail->Host       = EMAIL_HOST; // SMTP сервера вашей почты
    $mail->SMTPAuth   = true;
    $mail->Username   = EMAIL_USERNAME; // Логин на почте
    $mail->Password   = EMAIL_PASSWORD; // Пароль на почте
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    // От кого письмо
    $mail->setFrom($myaddres, 'Arbooz: результаты расчетов'); // Адрес самой почты и имя отправителя
    // Получатель письма
    $mail->addAddress($email);

    // Отправка сообщения
    $mail->isHTML(true);
    $mail->Subject = $title;
    $mail->Body = $body;

    // Проверка отправленности письма
    if ($mail->send()) {
        $message = "success";
    } else {
        $message = "error";
    }

    $response = ['message' => $message];

    header('Content-type: application/json');
    echo json_encode($response);
}
