<?php

use yii\helpers\Url;

$this->title = 'Бронирование зала';
?>

<br><br>

<h1 class="section-title">
    Бронирование зала
</h1>

<p class="section-subtitle">
    <?= $hall->title ?>
</p>

<div class="booking-wrapper">

    <!-- ЗАЛ -->
    <div class="hall-booking-image">
        <img src="/images/halls/<?= $hall->foto ?>">
    </div>

    <!-- ИНФО -->
    <div class="hall-info-card">

        <p class="hall-description">
            <?= $hall->description ?>
        </p>

        <div class="hall-details">

            <div class="hall-detail-item">
                <span>Площадь</span>
                <strong><?= $hall->size ?> м²</strong>
            </div>

            <div class="hall-detail-item">
                <span>Стоимость</span>
                <strong><?= $hall->price ?> ₽ / час</strong>
            </div>

        </div>

    </div>

    <!-- DATA JS -->
    <script>
        let occupied = <?= json_encode($occupied) ?>;
        let pricePerHour = <?= $hall->price ?>;
    </script>

    <!-- ФОРМА -->
    <form method="post" action="<?= Url::to(['hall/save-booking']) ?>">

        <?= \yii\helpers\Html::hiddenInput(
            Yii::$app->request->csrfParam,
            Yii::$app->request->csrfToken
        ) ?>

        <input type="hidden" name="hall_id" value="<?= $hall->id_hall ?>">

        <!-- ДАТА -->
        <label>Дата</label>

        <input type="date"
               name="date"
               class="form-input"
               required
               min="<?= date('Y-m-d') ?>">

        <br><br>

        <!-- СЛОТЫ -->
        <label>Выберите время</label>

        <div class="slots-wrapper">

            <?php foreach ($allSlots as $slot): ?>

                <label class="slot-item">
                    <input type="checkbox"
                           class="slot-checkbox"
                           name="slots[]"
                           value="<?= $slot ?>">

                    <span><?= formatSlot($slot) ?></span>
                </label>

            <?php endforeach; ?>

        </div>

        <!-- ИТОГО -->
        <div class="total-price">
            <p>Итого:</p>
            <h3 id="total">0 ₽</h3>
        </div>

        <br>

       <div class="booking-action">
    
    <!-- КНОПКА -->
    <?php if (Yii::$app->user->isGuest): ?>

        <a href="<?= Url::to(['site/login']) ?>" class="lesson-btn">
            Войти, чтобы забронировать
        </a>

    <?php else: ?>

        <button class="lesson-btn">
            Забронировать зал
        </button>

    <?php endif; ?>

    <p class="booking-note">
        Оплата производится на месте
    </p>

</div>

    </form>
</div>

<!-- JS -->
<script>
const dateInput = document.querySelector('input[name="date"]');

/**
 * блокировка прошедшего времени + занятых слотов
 */
function updateSlots() {

    const selectedDateStr = dateInput.value;
    if (!selectedDateStr) return;

    const now = new Date();
    const selectedDate = new Date(selectedDateStr + "T00:00:00");

    document.querySelectorAll('.slot-checkbox').forEach(cb => {

        let [h, m] = cb.value.split(':');

        let slotDate = new Date(selectedDate);
        slotDate.setHours(h, m, 0, 0);

        let isOccupied = occupied.some(item =>
            item.date === selectedDateStr &&
            item.time_slot === cb.value
        );

        let isPast = slotDate < now;

        if (isOccupied || isPast) {
            cb.disabled = true;
            cb.parentElement.classList.add('occupied');
        } else {
            cb.disabled = false;
            cb.parentElement.classList.remove('occupied');
        }
    });

    calculateTotal();
}

/**
 *  расчет суммы
 */
function calculateTotal() {
    let checked = document.querySelectorAll('.slot-checkbox:checked').length;
    document.getElementById('total').innerText =
        (checked * pricePerHour) + ' ₽';
}

/**
 * смена даты
 */
dateInput.addEventListener('change', updateSlots);

/**
 * выбор слотов
 */
document.querySelectorAll('.slot-checkbox').forEach(cb => {
    cb.addEventListener('change', calculateTotal);
});
</script>

<?php
function formatSlot($time)
{
    $start = substr($time, 0, 5);
    $end = date('H:i', strtotime($start . ' +1 hour'));
    return $start . ' - ' . $end;
}
?>