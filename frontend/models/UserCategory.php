<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user_category".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $category_id
 *
 * @property Category $category
 * @property User $user
 */
class UserCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_category';
    }

    public function scenarios()
    {
        return [
            'default' => ['user_id', 'category_id']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'category_id'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'category_id' => 'Category ID',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id']);
    }

    public function saveUserCategory($user, $category_id)
    {
        $user_category = new UserCategory();
        $user_category->user_id = $user->id;
        $user_category->category_id = $category_id;
        $user_category->save();
    }
}
