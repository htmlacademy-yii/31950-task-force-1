<?php

namespace frontend\models;

use \yii\db\ActiveRecord;

/**
 * This is the model class for table "profile".
 *
 * @property int $id
 * @property string|null $address
 * @property string|null $about
 * @property string $date_birthday
 * @property string|null $phone
 * @property string|null $skype
 * @property string|null $telegram
 * @property int|null $popular
 *
 * @property Message[] $messages
 * @property Opinion[] $opinions
 */
class Profile extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile';
    }

    public function scenarios()
    {
        return [
            'default' => ['popular', 'date_birthday', 'telegram', 'phone', 'skype', 'about']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['address', 'about', 'telegram'], 'string'],
            [['date_birthday'], 'required'],
            [['date_birthday'], 'safe'],
            [['phone'], 'string', 'max' => 11],
            [['skype', 'telegram'], 'string', 'max' => 48],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'address' => 'Address',
            'about' => 'About',
            'date_birthday' => 'Date Birthday',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'telegram' => 'Telegram',
            'popular' => 'Popular',
        ];
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::class, ['worker_id' => 'id']);
    }

    /**
     * Gets query for [[Opinions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOpinions()
    {
        return $this->hasMany(Opinion::class, ['worker_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id']);
    }
}
