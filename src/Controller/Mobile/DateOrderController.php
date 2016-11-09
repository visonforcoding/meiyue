<?php
namespace App\Controller\Mobile;

use Cake\ORM\TableRegistry;


/**
 * DateOrder Controller
 *
 * @property \App\Model\Table\DateOrderTable $DateOrder
 */
class DateOrderController extends AppController
{

    /**
     * 约会支付详情页--赴约流程
     * @param int $id
     */
    public function join($id = null)
    {

        $dateTable = TableRegistry::get("Date");
        $date = $dateTable->get($id, ['contain' => ['Skill', 'Tag', 'User' => function ($q) {
            return $q->select(['nick', 'birthday', 'gender', 'money']);
        }]]);
        $this->set(['date' => $date, 'user' => $this->user]);


    }


    /**
     * 约会支付接口--赴约流程
     *
     */
    public function joinPay()
    {

    }


}
