<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wechat_user".
 *
 * @property int $uid
 * @property string $openid 用户openid
 * @property string $wxname 用户昵称
 * @property string $avatar 用户头像
 * @property int $sex 微信性别(0:未知，1：男，2：女)
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class WechatUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wxuser';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sex', 'createtime'], 'integer'],
            [['openid', 'wxname', 'touxiang'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'openid' => 'openid',
            'wxname' => 'wxname',
            'touxiang' => 'touxiang',
            'sex' => 'sex',
            'createtime' => 'createtime'
        ];
    }
}
