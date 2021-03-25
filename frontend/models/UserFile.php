<?php

namespace frontend\models;

use \yii\db\ActiveRecord;

/**
 * This is the model class for table "user_file".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $file
 *
 * @property User $user
 */
class UserFile extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['file'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'file' => 'File',
        ];
    }

    public function saveUserFile($user, $file)
    {
        $user_file = new UserFile();
        $user_file->user_id = $user->id;
        $user_file->file = $file->name;
        $user_file->save();
    }
}
