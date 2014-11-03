<?php

/**
 * @see Yii
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BBase extends Yii
{

    /**
     * Get value of translation
     *
     * @param string $category category ID
     * @param string $message message name
     * @param array $params parameters to be applied to the message using <code>strtr</code>.
     *        The first parameter can be a number without key.
     *        And in this case, the method will call {@link CChoiceFormat::format} to choose
     *        an appropriate message translation.
     *        Starting from version 1.1.6 you can pass parameter for {@link CChoiceFormat::format}
     *        or plural forms format without wrapping it with array.
     *        This parameter is then available as <code>{n}</code> in the message translation string.
     * @param string $source which message source application component to use.
     *        Defaults to null, meaning using 'coreMessages' for messages belonging to
     *        the 'yii' category and using 'messages' for the rest messages.
     * @param string $language the target language. If null (default), the {@link CApplication::getLanguage application language} will be used.
     * @return string the translated message
     */
    public static function t($category, $message, $params = array(), $source = null, $language = null)
    {
        $temp = parent::t(self::v('unitkit', 'b_message_group_id:' . $category), $message, $params, $source, $language);

        // find an alias
        if ($temp !== '' && $temp[0] === '{' && substr($temp, 0, 3) === '{@=') {
            // get alias
            $translation = explode('{@=', $temp);
            $translation = substr($translation[1], 0, - 1);
            // get category and message
            $args = explode(',', $translation);
            if (count($args) == 2) {
                return self::t(trim($args[0]), trim($args[1]), $params, $source, $language);
            } else
                return self::t($category, trim($args[0]), $params, $source, $language);
        }
        return $temp;
    }

    /**
     * Get value of variable
     *
     * @param string $group group ID
     * @param string $variable variable name
     * @param bool $refresh refresh cache
     */
    public static function v($group, $variable, $refresh = false)
    {
        return Yii::app()->variables->getVariable($group, $variable, $refresh);
    }
}