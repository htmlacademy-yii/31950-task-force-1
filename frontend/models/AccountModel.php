<?php


namespace frontend\models;

use app\models\UserFile;
use DateTime;
use Yii;
use yii\base\Model;


class AccountModel extends Model
{

    public $avatar = null;
    public $username = null;
    public $email = null;
    public $date_birthday = null;
    public $about = null;
    public $city = null;
    public $category = [];
    public $password = null;
    public $repeat_password = null;
    public $phone = null;
    public $skype = null;
    public $telegram = null;
    public $file = null;
    public $notification_to_new_message = null;
    public $notification_to_new_action = null;
    public $notification_to_new_review = null;
    public $show_my_contacts = null;
    public $show_my_account = null;

    public function scenarios()
    {
        return [
            'default' => ['username', 'avatar', 'date_birthday', 'about', 'city', 'category', 'password', 'repeat_password', 'phone', 'skype', 'telegram', 'email', 'file', 'notification_to_new_message', 'notification_to_new_action', 'notification_to_new_review', 'show_my_contacts', 'show_my_account']
        ];
    }

    public function rules()
    {
        return [
            ['password', 'compare', 'compareAttribute' => 'repeat_password', 'message' => "Пароли не совпадают"]
        ];
    }

    public function loadDefaultValues()
    {
        $currentUser = \Yii::$app->user->identity;
        $user = User::findOne($currentUser->id);
        $this->username = $user->username;
        $this->notification_to_new_message = $user->notification_to_new_message;
        $this->notification_to_new_action = $user->notification_to_new_action;
        $this->notification_to_new_review = $user->notification_to_new_review;
        $this->show_my_account = $user->show_my_account;
        $this->show_my_contacts = $user->show_my_contacts;
        $this->date_birthday = $user->profile ? Yii::$app->formatter->asDate($user->profile[0]['date_birthday'], 'yyyy-MM-dd') : "";
        $this->about = $user->profile ? $user->profile[0]['about'] : "";
        $this->phone = $user->profile ? $user->profile[0]['phone'] : "";
        $this->skype = $user->profile ? $user->profile[0]['skype'] : "";
        $this->telegram = $user->profile ? $user->profile[0]['telegram'] : "";
        $this->email = $user->email;
        $userCategory = UserCategory::find()->where(['user_id' => $user->id])->all();
        $category = [];
        foreach ($userCategory as $one) {
            $category[] = $one->category_id;
        }
        $this->category = $category;
    }

    public function saveForm()
    {
        $currentUser = \Yii::$app->user->identity;
        $user = User::findOne($currentUser->id);
        $profileId = UserProfile::find()->where(['user_id' => $user->id])->one()->profile_id;
        $profile = Profile::findOne($profileId);
        $user->email = $this->email;
        $user->city_id = $this->city;
        $user->role = "owner";
        $user->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        $user->notification_to_new_message = $this->notification_to_new_message;
        $user->notification_to_new_action = $this->notification_to_new_action;
        $user->notification_to_new_review = $this->notification_to_new_review;
        $user->show_my_contacts = $this->show_my_contacts;
        $user->show_my_account = $this->show_my_account;

        if ($this->avatar) {
            $user->avatar = $this->avatar->name;
        }

        foreach ($this->file as $file) {
            $userFile = new UserFile();
            $userFile->saveUserFile($user, $file);
        }

        $dateTime = new DateTime($this->date_birthday);
        $dateTime = $dateTime->format('U');
        $profile->date_birthday = (int)$dateTime;
        $profile->about = $this->about;
        $profile->phone = $this->phone;
        $profile->skype = $this->skype;
        $profile->telegram = $this->telegram;

        Yii::$app->db->createCommand("DELETE FROM user_category WHERE user_id = '$user->id'")->execute();

        if (!empty($this->category)) {
            $userCategory = new UserCategory();
            foreach ($this->category as $id) {
                $userCategory->saveUserCategory($user, $id);
            }
            $user->role = "worker";
        }
        $user->save();
        $profile->save();

    }

    public function uploadAvatar(string $path): bool
    {
        if ($this->avatar) {
            $filename = uniqid() . "-" . time();
            $this->avatar->name = $filename . "." . $this->avatar->extension;
            $this->avatar->saveAs($path . '/' . $filename . '.' . $this->avatar->extension);
            return true;
        }
        return false;
    }

    public function uploadFile(string $path): bool
    {
        foreach ($this->file as $file) {
            $filename = uniqid() . "-" . time();
            $file->name = $filename . "." . $file->extension;
            $file->saveAs($path . '/' . $filename . '.' . $file->extension);
        }
        return true;
    }


}
