<?php
/**
 * Email functions
 *
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class MailFunctionPasswordReset
{

    /**
     * Create password reset link
     *
     * @param int $id UPerson ID
     * @return string
     */
    public static function createPasswordResetLink($id)
    {
        $token = new UPersonToken();
        $token->deleteAll(array(
            'condition' => 'u_person_id = :u_person_id AND action = :action',
            'params' => array(
                ':u_person_id' => $id,
                ':action' => Unitkit::v('backend', 'u_person_token_action:resetPassword')
            )
        ));

        // generate password and normalize
        $code = UTools::sha512(uniqid(mt_rand(), true) . ':' . UTools::password(500));
        // generate uuid
        $uuid = UTools::sha256(uniqid(mt_rand(), true) . ':' . UTools::password(500));
        // expired at
        $expiredAt = date('Y-m-d H:i:s', time() + (Unitkit::v('backend', 'u_person_token_expired_at:resetPassword') * 3600));

        $token->uuid = $uuid;
        $token->u_person_id = (int) $id;
        $token->password = CPasswordHelper::hashPassword($code); // hash password
        $token->action = Unitkit::v('backend', 'u_person_token_action:resetPassword');
        $token->expired_at = $expiredAt;
        $token->save();

        $url = Yii::app()->createAbsoluteUrl('/backend/passwordReset/default/validate', array(
            'uuid' => $uuid,
            'code' => $code
        ));

        return UHtml::link($url, $url);
    }
}