<?php

use yii\widgets\LinkPager;
use yii\helpers\Html;

$this->title = 'Панель администратора';

$activeTab = Yii::$app->request->get('tab', 'lessons');
?>

<br><br>

<h1 class="section-title">Панель администратора</h1>

<!-- ВКЛАДКИ -->
<div class="admin-tabs">

    <button type="button" onclick="setTab('lessons')">Занятия</button>
    <button type="button" onclick="setTab('halls')">Залы</button>
    <button type="button" onclick="setTab('first')">Пробные заявки</button>

    <button type="button" onclick="setTab('schedule_manage')">Расписание</button>
    <button type="button" onclick="setTab('coach_manage')">Тренеры</button>
    <button type="button" onclick="setTab('hall_manage')">Залы студии</button>
    <button type="button" onclick="setTab('direction_manage')">Направления</button>
    <button type="button" onclick="setTab('users_manage')">Пользователи</button>

</div>


<!-- ===================== ЗАНЯТИЯ ===================== -->
<div id="lessons" class="admin-tab">

<form method="get" class="admin-filters">

    <input type="hidden" name="tab" value="lessons">

    <input type="text" name="name" placeholder="Имя">
    <input type="text" name="phone" placeholder="Телефон">
    <input type="date" name="date">

    <select name="direction">
        <option value="">Все направления</option>
        <?php foreach ($directions as $d): ?>
            <option value="<?= $d['name'] ?>">
                <?= $d['name'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <select name="group">
        <option value="">Все группы</option>
        <option value="kids">Детская</option>
        <option value="adults">Взрослая</option>
    </select>


<div class="filter-actions">

    <button type="submit" class="admin-filter-btn">
        Найти
    </button>

    <a href="<?= \yii\helpers\Url::to(['admin/index', 'tab' => 'lessons']) ?>"
       class="admin-reset-btn">
        Сбросить
    </a>

</div>
</form>

<h2>Запись на занятия</h2>

<?php foreach ($lessonBookings as $b): ?>

    <div class="admin-card">

        <p><b>ID:</b> <?= $b['user_id'] ?></p>
        <p><b>Имя:</b> <?= $b['user_name'] ?></p>
        <p><b>Телефон:</b> <?= $b['user_phone'] ?></p>

        <p><b>Направление:</b> <?= $b['direction_name'] ?></p>

        <p><b>Дата:</b> <?= $b['lesson_date'] ?></p>

        <p><b>Время:</b>
            <?= substr($b['lesson_time'], 0, 5) ?> -
            <?= date('H:i', strtotime($b['lesson_time'] . ' +1 hour')) ?>
        </p>

        <p><b>Группа:</b>
            <?= $b['group_type'] == 'kids' ? 'Детская' : 'Взрослая' ?>
        </p>

       <a href="/admin/delete-lesson?id=<?= $b['id_booking_lesson'] ?>"
   class="btn btn-danger btn-sm"
   onclick="return confirm('Удалить запись?')">
    🗑 Удалить
</a>

    </div>

<?php endforeach; ?>

<?= LinkPager::widget([
    'pagination' => $lessonPages,
    'options' => ['class' => 'pagination'],
]) ?>

</div>


<!-- ===================== ЗАЛЫ ===================== -->
<div id="halls" class="admin-tab">

<form method="get" class="admin-filters">

    <input type="hidden" name="tab" value="halls">

    <input type="text" name="name" placeholder="Имя">
    <input type="text" name="phone" placeholder="Телефон">
    <input type="date" name="date">

    <select name="hall">
        <option value="">Все залы</option>
        <?php foreach ($halls as $h): ?>
            <option value="<?= $h['id_hall'] ?>">
                <?= $h['title'] ?>
            </option>
        <?php endforeach; ?>
    </select>

   <select name="time">
    <option value="">Все время</option>

    <?php for ($h = 10; $h <= 21; $h++): ?>
        <option value="<?= sprintf('%02d:00', $h) ?>">
            <?= sprintf('%02d:00', $h) ?>
        </option>
    <?php endfor; ?>

</select>

    <div class="filter-actions">

    <button type="submit" class="admin-filter-btn">
        Найти
    </button>

    <a href="<?= \yii\helpers\Url::to(['admin/index', 'tab' => 'halls']) ?>"
       class="admin-reset-btn">
        Сбросить
    </a>

</div>

</form>

<h2>Бронирование залов</h2>

<?php foreach ($hallBookings as $b): ?>

    <div class="admin-card">

        <p><b>ID:</b> <?= $b['user_id'] ?></p>
        <p><b>Имя:</b> <?= $b['user_name'] ?></p>
        <p><b>Телефон:</b> <?= $b['user_phone'] ?></p>

        <p><b>Зал:</b> <?= $b['hall_name'] ?></p>

        <p><b>Дата:</b> <?= $b['date'] ?></p>

        <p><b>Время:</b>
            <?= substr($b['time_slot'], 0, 5) ?> -
            <?= date('H:i', strtotime($b['time_slot'] . ' +1 hour')) ?>
        </p>

       <a href="/admin/delete-hall?id=<?= $b['id_booking'] ?>"
   class="btn btn-danger btn-sm"
   onclick="return confirm('Удалить бронирование?')">
    🗑 Удалить
</a>

    </div>

<?php endforeach; ?>

<?= LinkPager::widget([
    'pagination' => $hallPages,
    'options' => ['class' => 'pagination'],
]) ?>

</div>


<!-- ===================== ПРОБНЫЕ ===================== -->
<div id="first" class="admin-tab">
<form method="get" class="admin-filters">
 <input type="hidden" name="tab" value="first">
    <select name="status">
        <option value="">Все статусы</option>

        <option value="Новая" <?= Yii::$app->request->get('status') == 'Новая' ? 'selected' : '' ?>>
            Новая
        </option>

        <option value="Обработана" <?= Yii::$app->request->get('status') == 'Обработана' ? 'selected' : '' ?>>
            Обработана
        </option>

        <option value="Отклонена" <?= Yii::$app->request->get('status') == 'Отклонена' ? 'selected' : '' ?>>
            Отклонена
        </option>

    </select>

    <button class="admin-filter-btn">
        Найти
    </button>

    <a href="<?= \yii\helpers\Url::to(['admin/index', 'tab' => 'first']) ?>"
       class="admin-reset-btn"
       style="text-decoration:none;">
        Сброс
    </a>

</form>
<h2>Пробные заявки</h2>

<?php foreach ($firstClassRequests as $b): ?>

    <div class="admin-card">

        <p><b>Имя:</b> <?= $b['name'] ?></p>
        <p><b>Телефон:</b> <?= $b['phone'] ?></p>
        <p><b>Статус:</b> <?= $b['status'] ?></p>

        <form method="post" action="/admin/update-status">

            <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>

            <input type="hidden" name="id" value="<?= $b['id_booking_first_class'] ?>">

            <select name="status">
                <option value="Новая" <?= $b['status']=='Новая'?'selected':'' ?>>Новая</option>
                <option value="Обработана" <?= $b['status']=='Обработана'?'selected':'' ?>>Обработана</option>
                <option value="Отклонена" <?= $b['status']=='Отклонена'?'selected':'' ?>>Отклонена</option>
            </select>

            <button>Сохранить</button>

        </form>

    </div>

<?php endforeach; ?>

</div>


<!-- ===================== РАСПИСАНИЕ ===================== -->
<div id="schedule_manage" class="admin-tab">

<h2>Расписание занятий</h2>

<p>
    <a href="/schedule/create" class="admin-add-btn">
        ➕ Добавить занятие
    </a>
</p>

<form method="get" class="admin-filters">

    <input type="hidden" name="tab" value="schedule_manage">

    <select name="schedule_direction">
        <option value="">Все направления</option>
        <?php foreach ($directionsList as $d): ?>
            <option value="<?= $d->id_dance_direction ?>"
                <?= Yii::$app->request->get('schedule_direction') == $d->id_dance_direction ? 'selected' : '' ?>>
                <?= $d->name ?>
            </option>
        <?php endforeach; ?>
    </select>

    <select name="schedule_coach">
        <option value="">Все тренеры</option>
        <?php foreach ($coaches as $c): ?>
            <option value="<?= $c->id_coach ?>"
                <?= Yii::$app->request->get('schedule_coach') == $c->id_coach ? 'selected' : '' ?>>
                <?= $c->fio ?>
            </option>
        <?php endforeach; ?>
    </select>

    <select name="schedule_hall">
        <option value="">Все залы</option>
        <?php foreach ($halls as $h): ?>
            <option value="<?= $h['id_hall'] ?>"
                <?= Yii::$app->request->get('schedule_hall') == $h['id_hall'] ? 'selected' : '' ?>>
                <?= $h['title'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <input type="date" name="schedule_date"
           value="<?= Yii::$app->request->get('schedule_date') ?>">

    <button class="admin-filter-btn">Найти</button>

    <a href="/admin/index?tab=schedule_manage" class="admin-reset-btn">
        Сброс
    </a>

</form>
<table class="admin-table">

    <tr>
        <th>ID</th>
        <th>Направление</th>
        <th>Тренер</th>
        <th>Дата</th>
        <th>Время</th>
        <th>Зал</th>
        <th>Макс</th>
        <th>Группа</th>
        <th>Действия</th>
    </tr>

    <?php foreach ($schedules as $schedule): ?>

    <tr>

        <td><?= $schedule['id_schedule'] ?></td>
        <td><?= $schedule['direction_name'] ?? $schedule['dance_direction_id'] ?></td>
        <td><?= $schedule['coach_name'] ?? $schedule['coach_id'] ?></td>
        <td><?= $schedule['lesson_date'] ?></td>
        <td><?= substr($schedule['lesson_time'], 0, 5) ?></td>
        <td><?= $schedule['hall_name'] ?? $schedule['hall_id'] ?></td>
        <td><?= $schedule['max_people'] ?></td>
        <td><?= $schedule['group_type'] == 'kids' ? 'Детская' : 'Взрослая' ?></td>

        <td class="actions">
            <a href="/schedule/view?id_schedule=<?= $schedule['id_schedule'] ?>">👁</a>
            <a href="/schedule/update?id_schedule=<?= $schedule['id_schedule'] ?>">✏️</a>
              <a href="/schedule/delete?id_schedule=<?= $schedule['id_schedule'] ?>"
               onclick="return confirm('Удалить занятие?')">
                🗑
            </a>
        </td>

    </tr>

    <?php endforeach; ?>

</table>

<?= LinkPager::widget([
    'pagination' => $schedulePages,
    'options' => ['class' => 'pagination'],
]) ?>

</div>

<!-- ===================== ТРЕНЕРЫ ===================== -->
<div id="coach_manage" class="admin-tab">

<h2>Тренеры</h2>

<p>
    <a href="/coach/create" class="admin-add-btn">
        ➕ Добавить тренера
    </a>
</p>

<table class="admin-table">

    <tr>
        <th>ID</th>
        <th>ФИО</th>
        <th>Направление</th>
        <th>Описание</th>
        <th>Фото</th>
        <th>Действия</th>
    </tr>

    <?php foreach ($coaches as $coach): ?>
    <tr>

        <td><?= $coach->id_coach ?></td>

        <td><?= $coach->fio ?></td>

        <td>
            <?= $coach->dance_direction_id ?? '—' ?>
        </td>

       

        <td>
            <?= mb_strimwidth($coach->description ?? '', 0, 100, '...') ?>
        </td>

        <td><?= $coach->foto ?></td>

        <td class="actions">

            <a href="/coach/view?id_coach=<?= $coach->id_coach ?>">👁</a>

            <a href="/coach/update?id_coach=<?= $coach->id_coach ?>">✏️</a>

            <a href="/coach/delete?id_coach=<?= $coach->id_coach ?>"
               onclick="return confirm('Удалить тренера?')">
                🗑
            </a>

        </td>

    </tr>
    <?php endforeach; ?>

</table>

</div>
<!-- ===================== ЗАЛЫ ===================== -->
<div id="hall_manage" class="admin-tab">

<h2>Залы</h2>

<p>
    <a href="/hall/create" class="admin-add-btn">
        ➕ Добавить зал
    </a>
</p>

<table class="admin-table">

    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Описание</th>
        <th>Размер</th>
        <th>Цена</th>
        <th>Фото</th>
        <th>Действия</th>
    </tr>

    <?php foreach ($halls as $hall): ?>
    <tr>

        <td><?= $hall['id_hall'] ?></td>

        <td><?= $hall['title'] ?></td>

        <td>
            <?= mb_strimwidth($hall['description'] ?? '', 0, 100, '...') ?>
        </td>

       <td><?= $hall['size'] ?? '—' ?></td>

        <td><?= $hall['price'] ?? '—' ?></td>

        <td><?= $hall['foto'] ?? '—' ?></td>

        <td class="actions">

            <a href="/hall/view?id_hall=<?= $hall['id_hall'] ?>">👁</a>

            <a href="/hall/update?id_hall=<?= $hall['id_hall'] ?>">✏️</a>

            <a href="/hall/delete?id_hall=<?= $hall['id_hall'] ?>"
               onclick="return confirm('Удалить зал?')">
                🗑
            </a>

        </td>

    </tr>
    <?php endforeach; ?>

</table>

</div>
<!-- ===================== Направления ===================== -->
<div id="direction_manage" class="admin-tab">
<h2>Направления</h2>

<p>
    <a href="/dance-direction/create" class="admin-add-btn">
        ➕ Добавить направление
    </a>
</p>

<table class="admin-table">
   <tr>
    <th>ID</th>
    <th>Название</th>
    <th>Описание</th>
    <th>Файл изображения</th>
    <th>Действия</th>
</tr>

<?php foreach ($directionsList as $direction): ?>
<tr>

    <td><?= $direction->id_dance_direction ?></td>

    <td><?= $direction->name ?></td>

    <td><?= mb_strimwidth($direction->description, 0, 100, '...') ?></td>

    <td><?= $direction->image ?></td>

    <td class="actions">
        <a href="/dance-direction/view?id_dance_direction=<?= $direction->id_dance_direction ?>">👁</a>

        <a href="/dance-direction/update?id_dance_direction=<?= $direction->id_dance_direction ?>">✏️</a>

        <a href="/dance-direction/delete?id_dance_direction=<?= $direction->id_dance_direction ?>"
           onclick="return confirm('Удалить направление?')">
            🗑
        </a>
    </td>

</tr>
<?php endforeach; ?>

</table>
    </div>
<!-- ===================== Пользователи ===================== -->
<div id="users_manage" class="admin-tab">

<h2>Пользователи</h2>

<p>
    <a href="/user/create" class="admin-add-btn">
        ➕ Добавить пользователя
    </a>
</p>

<table class="admin-table">

    <tr>
        <th>ID</th>
        <th>ФИО</th>
        <th>Телефон</th>
        <th>Логин</th>
        <th>Дата регистрации</th>
        <th>Админ</th>
        <th>Действия</th>
    </tr>

    <?php foreach ($users as $user): ?>
    <tr>

        <td><?= $user['id_user'] ?></td>

        <td><?= $user['fio'] ?? '—' ?></td>

        <td><?= $user['phone'] ?? '—' ?></td>

        <td><?= $user['login'] ?? '—' ?></td>

        <td><?= $user['created_at'] ?? '—' ?></td>

        <td>
            <?= $user['is_admin'] == 1 ? 'Да' : 'Нет' ?>
        </td>

        <td class="actions">

            <a href="/user/view?id_user=<?= $user['id_user'] ?>">👁</a>

            <a href="/user/update?id_user=<?= $user['id_user'] ?>">✏️</a>

            <a href="/user/delete?id_user=<?= $user['id_user'] ?>"
               onclick="return confirm('Удалить пользователя?')">
                🗑
            </a>

        </td>

    </tr>
    <?php endforeach; ?>

</table>

</div>

<!-- ===================== JS ===================== -->
<script>

function setTab(tab){
    const url = new URL(window.location.href);
    url.searchParams.set('tab', tab);
    window.location.href = url.toString();
}

function showTab(tab){

    document.querySelectorAll('.admin-tab')
        .forEach(t => t.style.display = 'none');

    const el = document.getElementById(tab);
    if (el) el.style.display = 'block';
}

// открыть правильный таб
document.addEventListener('DOMContentLoaded', function () {

    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get('tab') || 'lessons';

    showTab(tab);
});

</script>