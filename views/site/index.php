<?php

/** @var yii\web\View $this */

$this->title = 'Booking Halls API';
?>
<style>
.site-index {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    padding: 40px 20px;
}

.api-container {
    max-width: 900px;
    width: 100%;
}

.api-header {
    text-align: center;
    color: #333;
    margin-bottom: 50px;
}

.api-header h1 {
    font-size: 3rem;
    font-weight: 600;
    margin-bottom: 15px;
}

.api-header p {
    font-size: 1.2rem;
    color: #666;
}

.docs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
    margin-top: 40px;
}

.doc-card {
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
}

.doc-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0,0,0,0.2);
}

.doc-card h3 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 15px;
    color: #333;
}

.doc-card p {
    color: #666;
    line-height: 1.6;
    margin: 0;
}

@media (max-width: 768px) {
    .api-header h1 {
        font-size: 2rem;
    }
    
    .api-header p {
        font-size: 1rem;
    }
    
    .docs-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="site-index">
    <div class="api-container">
        <div class="api-header">
            <h1>Booking Halls API</h1>
            <p>REST API для автоматизации процесса бронирования танцевальных залов</p>
        </div>

        <div class="docs-grid">
            <div class="doc-card">
                <h3>Посмотреть доступные танцевальные залы</h3>
            </div>

            <div class="doc-card">
                <h3>Забронировать зал для мероприятия</h3>
            </div>

            <div class="doc-card">
                <h3>Зайти в личный кабинет</h3>
            </div>
        </div>
    </div>
</div>
