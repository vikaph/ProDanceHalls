<?php

use yii\helpers\Url;

$this->title = 'Личный кабинет';

?>

<br><br>

<h1 class="section-title">
    Личный кабинет
</h1>

<p class="section-subtitle">
    Добро пожаловать, <?= $user->fio ?> 💃
</p>

<div class="cabinet-wrapper">

    <!-- ИНФОРМАЦИЯ -->
    <div class="cabinet-card">

        <h3>Мои данные</h3>

        <div class="cabinet-info">
            <p><strong>Имя:</strong> <?= $user->fio ?></p>
            <p><strong>Телефон:</strong> <?= $user->phone ?></p>
            <p><strong>Логин:</strong> <?= $user->login ?></p>
        </div>

    </div>

    <!-- МОИ ЗАНЯТИЯ -->
    <div class="cabinet-card">

        <h3>Мои занятия</h3>

        <?php if ($lessonBookings): ?>

            <?php foreach ($lessonBookings as $booking): ?>

                <?php
                    $schedule = \app\models\Schedule::findOne($booking->schedule_id);
                ?>

                <?php if ($schedule): ?>

                    <div class="cabinet-item">

                        <strong>
                            <?= $schedule->danceDirection->name ?>
                        </strong>

                        <p>
                            <?= $schedule->lesson_date ?>
                            |
                            <?= substr($schedule->lesson_time, 0, 5) ?>
                            -
                            <?= date('H:i', strtotime($schedule->lesson_time . ' +1 hour')) ?>
                        </p>

                        <p>
                            <?= $schedule->coach->fio ?>
                        </p>

                        <p>
                            Зал: <?= $schedule->hall->title ?>
                        </p>

                        <a href="<?= Url::to([
                            'site/delete-lesson-booking',
                            'id' => $booking->id_booking_lesson
                        ]) ?>"
                        class="cancel-btn">

                            Отменить запись

                        </a>

                    </div>

                <?php endif; ?>

            <?php endforeach; ?>

        <?php else: ?>

            <p>У вас пока нет записей на занятия</p>

        <?php endif; ?>

    </div>

    <!-- МОИ БРОНИ ЗАЛОВ -->
    <div class="cabinet-card">

        <h3>Мои бронирования залов</h3>

        <?php if ($hallBookings): ?>

            <?php foreach ($hallBookings as $booking): ?>

                 <?php
        $hall = \app\models\Hall::findOne($booking->hall_id);

        // фильтр прошедших бронирований
        $bookingDateTime = strtotime($booking->date . ' ' . $booking->time_slot);

        if ($bookingDateTime < time()) {
            continue;
        }
    ?>

                <?php if ($hall): ?>

                    <div class="cabinet-item">

                        <strong>
                            <?= $hall->title ?>
                        </strong>

                        <p>
                            <?= $booking->date ?>
                        </p>

                        <p>
                            <?= $booking->time_slot ?>
                            -
                            <?= date('H:i', strtotime($booking->time_slot . ' +1 hour')) ?>
                        </p>

                        <a href="<?= Url::to([
                            'site/delete-hall-booking',
                            'id' => $booking->id_booking
                        ]) ?>"
                        class="cancel-btn">

                            Отменить бронь

                        </a>

                    </div>

                <?php endif; ?>

            <?php endforeach; ?>

        <?php else: ?>

            <p>У вас пока нет бронирований</p>

        <?php endif; ?>

    </div>

    <!-- ИСТОРИЯ -->
    <div class="cabinet-card">

        <h3>История посещений</h3>

        <?php if ($historyLessons): ?>

            <?php foreach ($historyLessons as $booking): ?>

                <?php
                    $schedule = $booking->schedule;
                ?>

                <div class="cabinet-item">

                    <strong>
                        <?= $schedule->danceDirection->name ?>
                    </strong>

                    <p>
                        <?= $schedule->lesson_date ?>
                    </p>

                    <p>
                        <?= $schedule->coach->fio ?>
                    </p>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <p>История посещений пока пуста</p>

        <?php endif; ?>

    </div>

</div>