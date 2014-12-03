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
     * @param int $id BPerson ID
     * @return string
     */
    public static function createPasswordResetLink($id)
    {
        $token = new BPersonToken();
        $token->deleteAll(array(
            'condition' => 'b_person_id = :b_person_id AND action = :action',
            'params' => array(
                ':b_person_id' => $id,
                ':action' => B::v('backend', 'b_person_token_action:resetPassword')
            )
        ));

        // generate password and normalize
        $code = BTools::sha512(uniqid(mt_rand(), true) . ':' . BTools::password(500));
        // generate uuid
        $uuid = BTools::sha256(uniqid(mt_rand(), true) . ':' . BTools::password(500));
        // expired at
        $expiredAt = date('Y-m-d H:i:s', time() + (B::v('backend', 'b_person_token_expired_at:resetPassword') * 3600));

        $token->uuid = $uuid;
        $token->b_person_id = (int) $id;
        $token->password = CPasswordHelper::hashPassword($code); // hash password
        $token->action = B::v('backend', 'b_person_token_action:resetPassword');
        $token->expired_at = $expiredAt;
        $token->save();

        $url = Yii::app()->createAbsoluteUrl('/backend/passwordReset/default/validate', array(
            'uuid' => $uuid,
            'code' => $code
        ));

        return BHtml::link($url, $url);
    }
}