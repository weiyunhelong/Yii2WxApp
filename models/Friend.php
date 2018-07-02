<?php

namespace app\models;

use Yii;


class Friend extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'friend';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid','fid'], 'required'],
            [['id','uid','fid','createtime'], 'integer']
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
            'createtime' => 'createtime'
        ];
    }

   
}
