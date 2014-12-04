<?php

/**
 * Model of new password form
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class NewPasswordForm extends CFormModel
{
    public $password;
    public $repeat_password;

    /**
     * @see CModel::rules()
     */
    public function rules()
    {
        return array(
            array('password, repeat_password', 'required'),
            array('password, repeat_password', 'length', 'min' => 6, 'max' => 200),
            array('password, repeat_password', 'type', 'type' => 'string'),
            array('password', 'comparePassword')
        );
    }

    /**
     * @see CModel::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'password' => Unitkit::t('backend', 'person_profile:password'),
            'repeat_password' => Unitkit::t('backend', 'person_profile:repeat_password')
        );
    }

    /**
     * Compare passwords fields to update
     *
     * @param mixed $attribute
     * @param mixed $params
     */
    public function comparePassword($attribute, $params)
    {
        if ($this->repeat_password != '' || $this->password != '') {
            if ($this->repeat_password === '' || $this->password === '') {
                $this->addError('repeat_password', null);
                $this->addError('password', null);
                $this->addError('', Unitkit::t('backend', 'profil_password_is_required'));
            }

            $compare = new CCompareValidator();
            $compare->attributes[] = 'repeat_password';
            $compare->compareAttribute = 'password';
            $compare->validate($this);
        }
    }
}