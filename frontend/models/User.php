<?php

namespace frontend\models;

use Yii;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password_hash
 * @property string|null $date_last
 * @property string|null $avatar
 * @property number|null $city_id
 * @property string $role
 * @property boolean $notification_to_new_message
 * @property boolean $notification_to_new_action
 * @property boolean $notification_to_new_review
 * @property boolean $show_my_contacts
 * @property boolean $show_my_account
 *
 * @property Message[] $messages
 * @property Opinion[] $opinions
 * @property UserCategory[] $userCategories
 * @property UserProfile[] $userProfiles
 * @property UserTask[] $userTasks
 */
class User extends ActiveRecord
{
    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::class, ['owner_id' => 'id']);
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
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])->
        viaTable("user_category", ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Profile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['id' => 'profile_id'])->
        viaTable("user_profile", ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['id' => 'task_id'])->
        viaTable('user_task', ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserTasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserTasks()
    {
        return $this->hasMany(Task::class, ['owner_id' => 'id']);
    }

    /**
     * Gets query for [[Rate]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRate()
    {
        $rate = 0;
        $opinions = $this->opinions;
        foreach ($opinions as $opinion) {
            $rate += $opinion['rate'];
        }

        $opinionsCount = count($opinions);

        if ($opinionsCount) {
            $rate = round($rate / $opinionsCount, 1);
        }

        return $rate;
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Files]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(UserFile::class, ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password_hash', 'city_id'], 'required'],
            [['date_last'], 'safe'],
            [['username'], 'string', 'max' => 48],
            [['email'], 'string', 'max' => 128],
            [['password_hash'], 'string', 'max' => 64],
            [['city_id'], 'integer'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Name',
            'email' => 'Email',
            'password_hash' => 'Password',
            'avatar' => 'Avatar',
            'date_last' => 'Date Last',
            'city_id' => 'City ID',
            'notification_to_new_message' => 'Notification To New Message',
            'notification_to_new_action' => 'Notification To New Action',
            'notification_to_new_review' => 'Notification To New Review',
            'show_my_contacts' => 'Show My Contacts',
            'show_my_account' => 'Show My Account',
        ];
    }
}
