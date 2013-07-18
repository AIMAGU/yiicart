<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('views.manufacturers.index', 'Manufacturers');
$this->breadcrumbs = array(
    Yii::t('views.manufacturers.index', 'Manufacturers'),
    Yii::t('common', 'Update'),
);
?>

<div class="row-fluid">
    <div class="span9"><h1><?php echo Yii::t('common', 'Update'); ?></h1></div>
    <div class="span2">
        <div class="btn-group">
            <a class="btn btn-primary"><?php echo Yii::t('common', 'Save'); ?></a>
            <a href="<?php echo $this->createUrl('index'); ?>" class="btn btn-danger"><?php echo Yii::t('common', 'Cancel'); ?></a>
        </div>
    </div>
</div>

<br />

<?php $this->renderPartial('_form', array('model'=>$model)); ?>