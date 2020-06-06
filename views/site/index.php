<?php
$this->title = 'Чат';
?>
<div class="row">
    <div>
        <div id="chat">
        </div>
    </div>
    <div class="form-sender">
        <div>
            <textarea id="message" class="form-control send-message" rows="3" placeholder="Введите имя..."></textarea>
        </div>
        <div>
            <button class="btn pull-right" onclick="sendMessage()"> Отправить</button>
        </div>
    </div>
</div>