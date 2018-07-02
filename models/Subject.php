<?php

namespace app\models;

use Yii;


class Subject extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subject';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price', 'name','bonus','status'], 'required'],
            [['id','status', 'createtime'], 'integer'],
            [['price','bonus'], 'double'],
            [['name'], 'string', 'max' => 255],
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
            'price' => 'price',
            'bonus' => 'bonus',
            'status' => 'status',
            'createtime' => 'createtime'
        ];
    }

   
}
