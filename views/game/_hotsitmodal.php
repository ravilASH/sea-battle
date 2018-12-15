<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \app\models\User */

\yii\bootstrap\Modal::begin([

    'clientOptions' => ['show' => true],
    'size' => 'modal-lg',

]);

echo "Ход игрока " . $user->firstName;

?>
<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
<?php

echo "Делайте ход";

\yii\bootstrap\Modal::end();

?>

