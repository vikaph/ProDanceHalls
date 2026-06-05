<?php

use yii\helpers\Url;

$this->title = 'Расписание';
?>
<br>
<br>
<h1 class="section-title">
    Расписание занятий
</h1>

<?php

$directions = \app\models\DanceDirection::find()->all();
$coaches = \app\models\Coach::find()->all();

?>

<form method="get" class="schedule-filters">
<input type="hidden" name="week" value="<?= $weekOffset ?>">
    <!-- НАПРАВЛЕНИЕ -->
    <select name="direction">

        <option value="">Все направления</option>

        <?php foreach ($directions as $direction): ?>

            <option value="<?= $direction->id_dance_direction ?>"
                <?= $directionFilter == $direction->id_dance_direction ? 'selected' : '' ?>>

                <?= $direction->name ?>

            </option>

        <?php endforeach; ?>

    </select>

    <!-- ТРЕНЕР -->
    <select name="coach">

        <option value="">Все тренеры</option>

        <?php foreach ($coaches as $coach): ?>

            <option value="<?= $coach->id_coach ?>"
                <?= $coachFilter == $coach->id_coach ? 'selected' : '' ?>>

                <?= $coach->fio ?>

            </option>

        <?php endforeach; ?>

    </select>

    <!-- ГРУППА -->
    <select name="group">

        <option value="">Все группы</option>

        <option value="kids"
            <?= $groupFilter == 'kids' ? 'selected' : '' ?>>

            Детская

        </option>

        <option value="adults"
            <?= $groupFilter == 'adults' ? 'selected' : '' ?>>

            Взрослая

        </option>

    </select>

    <button class="lesson-filtr-btn filter-btn">
        Применить
    </button>

    <a href="<?= Url::to(['schedule/index']) ?>" class="lesson-filtr-btn reset-btn">
    Сбросить фильтры
</a>

</form>

<!-- НАВИГАЦИЯ НЕДЕЛЬ -->
<div class="schedule-nav">
    <a href="<?= Url::to(['schedule/index', 'week' => $weekOffset - 1]) ?>">←</a>

    <span>Неделя</span>

    <a href="<?= Url::to(['schedule/index', 'week' => $weekOffset + 1]) ?>">→</a>
</div>

<div class="schedule-wrapper">

    <!-- ШАПКА -->
    <div class="schedule-header">

        <div class="time-column"></div>

        <?php foreach ($days as $day): ?>
            <div class="day-column">
                <div class="day-date">
                    <?= $day['label'] ?>
                </div>
                <div class="day-week">
                    <?= $day['weekday'] ?>
                </div>
            </div>
        <?php endforeach; ?>

    </div>

    <!-- ТАБЛИЦА -->
    <?php foreach ($times as $time): ?>

        <div class="schedule-row">

            <!-- ВРЕМЯ -->
            <div class="time-cell">
                <?= substr($time, 0, 5) ?>
            </div>

            <!-- ДНИ -->
            <?php foreach ($days as $day): ?>

                <div class="schedule-cell">

                    <?php foreach ($schedules as $schedule): ?>
                         <?php
   
                        $isBooked = false;

                if (!Yii::$app->user->isGuest) {
                 $isBooked = (new \yii\db\Query())
            ->from('booking_lesson')
            ->where([
                'user_id' => Yii::$app->user->id,
                'schedule_id' => $schedule->id_schedule,
            ])
            ->exists();
                }
                ?>
                        <?php
                        // дата занятия из БД
                        $scheduleDate = $schedule->lesson_date;

                        // сравнение: дата + время
                        if (
                            $scheduleDate == $day['date'] &&
                            $schedule->lesson_time == $time
                        ):
                        ?>

                            <a href="<?= Url::to([
                                'schedule/view',
                                'id_schedule' => $schedule->id_schedule
                            ]) ?>">

                                <div class="lesson-card">

                                    <div class="lesson-direction">
                                        <?= $schedule->danceDirection->name ?>
                                    </div>

                                    <div class="lesson-coach">
                                        <?= $schedule->coach->fio ?>
                                    </div>

                                    <div class="lesson-group">
                                        <?= $schedule->group_type == 'kids'
                                            ? 'Детская группа'
                                            : 'Взрослая группа'
                                        ?>
                                    </div>

                                </div>

                            </a>

                        <?php endif; ?>

                    <?php endforeach; ?>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endforeach; ?>

</div>