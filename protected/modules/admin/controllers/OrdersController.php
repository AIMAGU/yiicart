<?php

class OrdersController extends BackendController {

    public function actionView($id) {
        $order = Order::model()->findByPk($id);
        if(is_null($order)){
            // TODO: send an error here!
            die();
        }
        
        // TODO: add locale
        $orderStatuses = OrderStatus::model()->findAllByAttributes(array('language_id'=>1));
        $orderStatuses = CHtml::listData($orderStatuses, 'order_status_id', 'name');
        
        $this->render('view', array(
            'order'=>$order,
            'orderHistoryModel'=>new OrderHistory,
            'orderStatuses'=>$orderStatuses
        ));
    }

}