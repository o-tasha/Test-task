<?php
/**
 * Created by PhpStorm.
 * User: nataly
 * Date: 09.10.17
 * Time: 23:46
 */
namespace app\models;

use Yii;
use yii\base\Model;

class RegistrationForm extends Model
{
    //физическое лицо
    const NATURAL_PERSON = 0;
    //индивидуальный предприниматель
    const SELF_EMPLOYED = 1;
    //юридическое лицо
    const LEGAL_PERSONALITY = 2;

    public $fio;
    public $email;
    public $inn;
    public $organizationForm;
    public $organizationName;

    public function rules()
    {
        return [
            [['fio', 'email'], 'required'],

            ['inn', 'required',
                'when' => function ($model) {
                            return in_array($model->organizationForm, [self::SELF_EMPLOYED, self::LEGAL_PERSONALITY]);
                          },
                'whenClient' => "function (attribute, value) {
                                    var orgForm = $('input[name=\"RegistrationForm[organizationForm]\"]:checked').val();
                                    var condition = (orgForm == " . self::SELF_EMPLOYED." || orgForm == " . self::LEGAL_PERSONALITY.");
                                    return condition;
                                 }"
            ],

            ['organizationForm', 'required',
                    'whenClient' => "function (attribute, value) {
                                        if (value == " . self::LEGAL_PERSONALITY . ") {
                                            $('.field-registrationform-organizationname').show();
                                        }
                                        else {
                                            $('.field-registrationform-organizationname').hide();
                                        }
                                        if (value == " . self::NATURAL_PERSON . ") {
                                            $('.field-registrationform-inn').hide();
                                        }
                                        else {
                                            $('.field-registrationform-inn').show();
                                        }
                                        return true;
                                    }"
            ],

            ['organizationName', 'required',
                'when' => function ($model) {
                              return in_array($model->organizationForm, [self::LEGAL_PERSONALITY]);
                          },
                'whenClient' => "function (attribute, value) {
                              return $('input[name=\"RegistrationForm[organizationForm]\"]:checked').val() == " . self::LEGAL_PERSONALITY . ";}"
            ],

            // email has to be a valid email address
            ['email', 'email'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'fio' => 'Фамилия, имя, отчество',
            'email' => 'E-mail',
            'inn' => 'ИНН',
            'organizationForm' => 'Форма организации',
            'organizationName' => 'Название организации',
        ];
    }

    /**
     * @return bool whether the model passes validation
     */
    public function registration()
    {
        if ($this->validate()) {
            return true;
        }
        return false;
    }

    public static function getOrganizationForms()
    {
        return [
            self::NATURAL_PERSON => 'Физическое лицо',
            self::SELF_EMPLOYED => 'Индивидуальный предприниматель',
            self::LEGAL_PERSONALITY => 'Юридическое лицо',
        ];
    }
}