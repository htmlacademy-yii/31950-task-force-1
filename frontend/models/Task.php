<?php

namespace frontend\models;


/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $date_add
 * @property string $date_expire
 * @property int $price
 * @property string $address
 * @property float $latitude
 * @property float $longitude
 * @property float $status
 *
 * @property TaskCategory[] $taskCategories
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            [['description', 'address', 'status'], 'string'],
            [['date_add', 'date_expire'], 'safe'],
            [['price'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['name'], 'string', 'max' => 48],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'date_add' => 'Date Add',
            'date_expire' => 'Date Expire',
            'price' => 'Price',
            'address' => 'Address',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */

    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])->
        viaTable("task_category", ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Files]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(TaskFile::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Owner]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'owner_id']);
    }

    /**
     * Gets query for [[Response]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponse()
    {
        return $this->hasMany(Response::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(UserTask::className(), ['task_id' => 'id']);
    }


    /**
     * Проверка права пользователя на создание сообщения к данному заданию
     *
     * @param int $userId идентификатор пользователя
     *
     * @return bool резльутат проверки, есть право на создание, или нет
     */
    public function getAccessCheckMessageCreate(int $userId): bool
    {
        return $this->getIsSelectedExecutor($userId)
            || $this->getIsAuthor($userId);
    }

    /**
     * Проверка, является ли пользователь с указанным идентификатором
     * исполнителем этого задания
     *
     * @param int $userId идентификатор пользователя
     *
     * @return bool результат проверки, является ли пользователь исполнителем задания
     */
    public function getIsSelectedExecutor(int $userId): bool
    {
        return ($this->user->id ?? null) === $userId;
    }

    /**
     * Проверка, является ли пользователь с указанным идентификатором
     * автором этого задания
     *
     * @param int $userId идентификатор пользователя
     *
     * @return bool результат проверки, является ли пользователь автором задания
     */
    public function getIsAuthor(int $userId): bool
    {
        return $this->owner_id === $userId;
    }

}
