<?php

namespace app\models;

use Yii;


class Master extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'master';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','infoimg','status'], 'required'],
            [['id','status', 'createtime'], 'integer'],
            [['name','infoimg'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'infoimg' => 'infoimg',
            'status' => 'status',
            'createtime' => 'createtime'
        ];
    }

   
}
