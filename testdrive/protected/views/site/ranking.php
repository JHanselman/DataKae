<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
//$ranking=GlickoData::model()->search();
$ranking=new CActiveDataProvider('GlickoData', array(
  'sort'=>array(
    'defaultOrder'=>'rating DESC')
));
?>

<h1>Current Results</h1>
<?php $this->widget('zii.widgets.grid.CGridView', 
    array(
        'dataProvider'=>$ranking,
        'pager'=>array('maxButtonCount'=>'7'),
        'columns'=>
            array(
                'columns' => array(
                        'header'=>'No.',
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)'
                    ),
            array(
                'name'=>'Name',
                'value'=>'$data->user->userName'
                ),
                array(
                'name'=>'Ranking',
                'value'=>'$data->rating'
                )
            )
        )); 
?>



