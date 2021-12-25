<?php

use yii\helpers\Url;

?>
<?= $user->name ?>
У вас новое уведомление:
<?= $subject ?>
<a href="<?= Url::to(['tasks/view/', 'id' => $task['id']]) ?>">
    <?= $task->name ?>
</a>
