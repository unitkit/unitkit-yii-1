<?php

/**
 * @see CDbMessageSource
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BBaseDbMessageSource extends CDbMessageSource
{
    /**
     * Cache duration
     *
     * @var int
     */
    protected static $cacheDuration = 86400;

    /**
     *
     * @var string the ID of the cache application component that is used to cache the messages.
     */
    public $cacheID;

    /**
     * Loads the message translation for the specified language and group.
     *
     * @param string $code the message group code
     * @param string $language the target language
     * @return array the loaded messages
     */
    protected function loadMessages($code, $language)
    {
        $cache = Yii::app()->getComponent($this->cacheID);
        $key = self::getCacheKeyPrefix() . ':messages:' . $code . ':' . $language;
        if (($data = $cache->get($key)) !== false) {
            return unserialize($data);
        }

        $messages = $this->loadMessagesFromDb($code, $language);

        if (isset($cache)) {
            $cache->set($key, serialize($messages), self::$cacheDuration);
        }

        return $messages;
    }

    /**
     * Get prefix key name
     */
    protected static function getCacheKeyPrefix()
    {
        return 'b_message:dynamic_key';
    }

    /**
     * Refresh messages
     */
    public function refreshCache()
    {
        $cache = Yii::app()->getComponent($this->cacheID);
        $i18nIds = BSiteI18n::model()->getI18nIds();
        $groups = BMessageGroup::model()->findAll(array(
            'select' => 'id'
        ));

        foreach ($groups as $group) {
            foreach ($i18nIds as $i18nId) {
                $key = self::getCacheKeyPrefix().':messages:'.$group->id.':'.$i18nId;
                $cache->delete($key);
            }
        }
    }

    /**
     * Loads the messages from database.
     * You may override this method to customize the message storage in the database.
     *
     * @param string $group the message group
     * @param string $language the target language
     * @return array the messages loaded from database
     * @since 1.1.5
     */
    protected function loadMessagesFromDb($group, $language)
    {
        $sql = <<<EOD
SELECT
	t1.source AS source, t2.translation AS translation
FROM
	b_message t1, b_message_i18n t2
WHERE
	t1.id = t2.b_message_id AND
	t1.b_message_group_id = :b_message_group_id AND
	t2.i18n_id = :language
EOD;
        $command = BMessage::model()->dbConnection->createCommand($sql);
        $command->bindValue(':b_message_group_id', $group);
        $command->bindValue(':language', $language);
        $messages = array();
        foreach ($command->queryAll() as $row) {
            $messages[$row['source']] = $row['translation'];
        }

        return $messages;
    }
}