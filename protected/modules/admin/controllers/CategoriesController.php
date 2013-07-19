<?php

class CategoriesController extends BackendController {

    public function actionIndex() {
        $criteria = new CDbCriteria;
        $criteria->condition = 'parent_id=0';
        $criteria->order = 'sort_order, category_id ASC';
        $categories = Category::model()->findAll($criteria);
        
        $this->render('index', array(
            'categories'=>$categories            
        ));
    }
    
    public function actionCreate(){
        $model = new CategoryForm;
        if (isset($_POST['CategoryForm'])) {
            $model->attributes = $_POST['CategoryForm'];
            if ($model->validate()) {
                $model->save();
                $this->redirect(array('index'));
            }
        }
        
        $statuses = array(
            0=>Yii::t('common', 'Disabled'),
            1=>Yii::t('common', 'Enabled')
        );
        
        $this->render('create', array(
            'model'=>$model,
            'statuses'=>$statuses
        ));
    }
    
    public function actionUpdate($id){
        $model = new CategoryForm;
        if (isset($_POST['CategoryForm'])) {
            $model->attributes = $_POST['CategoryForm'];
            if ($model->validate()) {
                $model->save();
                $this->redirect(array('index'));
            }
        }
        else
            $model->loadDataFromCategory($id);
        
        $statuses = array(
            0=>Yii::t('common', 'Disabled'),
            1=>Yii::t('common', 'Enabled')
        );
        
        $this->render('update', array(
            'model'=>$model,
            'statuses'=>$statuses
        ));        
    }
    
    public function actionDelete($ids){
        $ids = explode(',', $ids);
        if(count($ids) > 0){
            foreach($ids as $id){
                // TODO: delete should handle all dependencies
                $category = Category::model()->findByPk($id);
                $category->delete();
            }
        }
        
        $this->redirect(array('index'));
    }

}