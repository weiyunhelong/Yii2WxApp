<?php

namespace app\models;

use Yii;


class TestFate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'testfate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid','ceday','sid','money','formid'], 'required'],
            [['id','uid','sid','createtime','status'], 'integer'],
            [['ceday','birthday','formid','subject','result','openid'], 'string']
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
            'openid' => 'openid',
            'ceday' => 'ceday',
            'birthday' => 'birthday',
            'sid' => 'sid',
            'subject' => 'subject',
            'result' => 'result',
            'status' => 'status',
            'createtime' => 'createtime'
        ];
    }

   
}
