<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="span-19">
    <div id="content">
        <?php echo $content; ?>
    </div><!-- content -->
</div>
<div class="span-5 last">
    <div id="sidebar">
    <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title'=>'Operations',
        ));
        $this->widget('zii.widgets.CMenu', array(
        'items'=>array(
            // Important: you need to specify url as 'controller/action',
            // not just as 'controller' even if default acion is used.
            array('label'=>'Home', 'url'=>array('site/index')),
            // 'Products' menu item will be selected no matter which tag parameter value is since it's not specified.
            array('label'=>'Products', 'url'=>array('product/index'), 'items'=>array(
                array('label'=>'New Arrivals', 'url'=>array('product/new', 'tag'=>'new')),
                array('label'=>'Most Popular', 'url'=>array('product/index', 'tag'=>'popular')),
            )),
            array('label'=>'Login', 'url'=>array('site/login'), 'visible'=>Yii::app()->user->isGuest),
        ),
    ));
        $this->endWidget();
    ?>
    </div><!-- sidebar -->
</div>
<?php $this->endContent(); ?>