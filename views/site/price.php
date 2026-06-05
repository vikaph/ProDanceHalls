<?php

use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'Абонементы';
?>

<div class="prices-page container py-5">

    <!-- Заголовок -->
    <h1 class="section-title">Абонементы</h1>

    <!-- Таблица -->
    <div class="table-responsive mb-5">

        <table class="table prices-table align-middle text-center">

            <thead>
            <tr>
                <th>Название</th>
                <th>Срок</th>
                <th>Цена</th>
                <th>Стоимость 1 занятия</th>
            </tr>
            </thead>

            <tbody>

            <tr>
                <td>Стандарт 4</td>
                <td>1 мес. (4 занятия)</td>
                <td>3 900 ₽</td>
                <td>975 ₽</td>
            </tr>

            <tr>
                <td>Стандарт 8</td>
                <td>1 мес. (8 занятий)</td>
                <td>5 900 ₽</td>
                <td>737 ₽</td>
            </tr>

            <tr>
                <td>Стандарт 16</td>
                <td>2 мес. (16 занятий)</td>
                <td>10 400 ₽</td>
                <td>650 ₽</td>
            </tr>

            <tr>
                <td>Стандарт 24</td>
                <td>3 мес. (24 занятия)</td>
                <td>14 100 ₽</td>
                <td>587 ₽</td>
            </tr>

            <tr>
                <td>Стандарт 48</td>
                <td>6 мес. (48 занятий)</td>
                <td>25 400 ₽</td>
                <td>529 ₽</td>
            </tr>

            <tr class="beginner-row">
                <td>Неделя новичка</td>
                <td>7 дней / 7 любых занятий</td>
                <td>1 900 ₽</td>
                <td>271 ₽</td>
            </tr>

            </tbody>

        </table>

    </div>

    <!-- Разовое -->
    <div class="single-visit text-center mb-5">
        Разовое посещение — <span>1200 ₽</span>
    </div>

    <!-- Кнопка -->
    <div class="text-center mb-5">

        <a href="<?= Url::to(['/site/first-class']) ?>"
           class="btn btn-prices rounded-pill px-5 py-3">
            Записаться на занятие
        </a>

    </div>

    <!-- Акции -->
    <div class="promo-block">

        <h2 class="section-title">Акции</h2>

        <div class="promo-card mb-4">
            <h5>🎁 Первое пробное занятие бесплатно</h5>
            <p>
                Первое пробное занятие на любое направление — бесплатно
            </p>
        </div>

        <div class="promo-card mb-4">
            <h5>👯 Приводи друзей и танцуй за пол цены</h5>

            <p>
                За каждого приведённого друга, купившего абонемент —
                ты получаешь <strong>10% cashback</strong>
            </p>

            <p class="mb-0">
                Пример: привёл 2 друзей → скидка 20% на следующий абонемент
            </p>
        </div>

        <div class="promo-card">
            <h5>🎂 Скидка в день рождения</h5>

            <p class="mb-0">
                Скидка 15% при покупке любого абонемента
                Действует 3 дня ДО и 3 дня ПОСЛЕ дня рождения
            </p>
        </div>

    </div>

</div>
