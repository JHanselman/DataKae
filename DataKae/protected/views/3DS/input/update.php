<?php
/* @var $this TournamentController */
/* @var $model Tournament */

?>

<h1>Update <?php echo $model->tournamentName; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>