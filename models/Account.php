<?php

namespace app\models;

use Yii;


class Account extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['money', 'uid','fid','money','status'], 'required'],
            [['id','uid','fid', 'sid','status','createtime'], 'integer'],
            [['money'], 'float']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'uid' => 'uid',
            'fid' => 'fid',
            'money' => 'money',
            'sid' => 'sid',
            'status' => 'status',
            'createtime' => 'createtime'
        ];
    }

   
}
