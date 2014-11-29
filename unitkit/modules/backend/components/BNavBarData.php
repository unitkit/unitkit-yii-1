<?php

/**
 * @see BBaseNavBarData
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BNavBarData extends BBaseNavBarData
{
    /**
     * Instance of BPerson
     *
     * @var BPerson
     */
    protected $person;

    public function __construct()
    {
        parent::__construct();
        $this->person = Yii::app()->user->getPerson();
    }

    /**
     * Build html of language selector
     *
     * @return string
     */
    public static function buildLanguageSelector()
    {
        $i18ns = BSiteI18n::model()->getI18nIds();
        $i18nsDDL = array();
        foreach ($i18ns as $id)
            $i18nsDDL[$id] = BI18n::labelI18n($id);

        $html = '<form method="post" class="current-language form-inline csrf" action="' . Yii::app()->request->url . '">
					 <span class="control-label">' . B::t('unitkit', 'navbar_current_language') . '</span>
				' . BHtml::dropDownList('language', Yii::app()->language, $i18nsDDL, array(
            'class' => 'input-medium language-selector',
            'id' => 'language-selector'
        ));

        foreach ($i18ns as $id)
            $html .= BHtml::hiddenField($id, Yii::app()->controller->createUrl('', array_merge($_GET, array(
                'language' => $id
            ))));

        $html .= '</form>';

        return preg_replace("/\r|\n/", "", $html);
    }

    /**
     * Return configuration of menu
     *
     * @return array
     */
    public function config()
    {
        return array(
            'brand' => array(
                'label' => array(
                    'value' => 'UNITKIT CMS',
                    'url' => $this->_controller->createUrl(! Yii::app()->user->isGuest ? '/dashboard/default' : '/auth/auth/login'),
                    'type' => 'brand'
                )
            ),
            'items' => array(
                array(
                    'items' => array(
                        array(
                            'label' => array(
                                'value' => B::t('backend', 'navbar_media'),
                                'url' => '#'
                            ),
                            'items' => array(
                                array(
                                    'label' => array(
                                        'value' => B::t('backend', 'navbar_message'),
                                        'url' => $this->_controller->createUrl('/message/message'),
                                        'hasRight' => Yii::app()->user->checkMultiAccess(Yii::app()->rights->getDefaultRoles('message', 'message', 'consult')),
                                    ),
                                    'items' => array(
                                        array(
                                            'label' => array(
                                                'value' => B::t('backend', 'navbar_message_group'),
                                                'url' => $this->_controller->createUrl('/message/messageGroup'),
                                                'hasRight' => Yii::app()->user->checkMultiAccess(
                                                    Yii::app()->rights->getDefaultRoles('messageGroup', 'message', 'consult')
                                                )
                                            )
                                        )
                                    )
                                ),
                                array(
                                    'label' => array(
                                        'value' => B::t('backend', 'navbar_mail'),
                                        'url' => '#',
                                        'htmlOptions' => array(
                                            'class' => 'disabled'
                                        )
                                    ),
                                    'items' => array(
                                        array(
                                            'label' => array(
                                                'value' => B::t('backend', 'navbar_mail_template'),
                                                'url' => $this->_controller->createUrl('/mail/mailTemplate'),
                                                'hasRight' => Yii::app()->user->checkMultiAccess(
                                                    Yii::app()->rights->getDefaultRoles('mailTemplate', 'mail', 'consult')
                                                )
                                            )
                                        ),
                                        array(
                                            'label' => array(
                                                'value' => B::t('backend', 'navbar_mail_template_group'),
                                                'url' => $this->_controller->createUrl('/mail/mailTemplateGroup'),
                                                'hasRight' => Yii::app()->user->checkMultiAccess(
                                                    Yii::app()->rights->getDefaultRoles('mailTemplateGroup', 'mail', 'consult')
                                                )
                                            )
                                        )
                                    )
                                )
                            )
                        ),
                        array(
                            'label' => array(
                                'value' => B::t('backend', 'navbar_cms'),
                                'url' => '#'
                            ),
                            'items' => array(
                                array(
                                    'label' => array(
                                        'value' => B::t('backend', 'navbar_cms_page'),
                                        'url' => $this->_controller->createUrl('/cms/pageContainer'),
                                        'hasRight' => Yii::app()->user->checkMultiAccess(
                                            Yii::app()->rights->getDefaultRoles('pageContainer', 'cms', 'consult')
                                        )
                                    )
                                ),
                                array(
                                    'label' => array(
                                        'value' => B::t('backend', 'navbar_cms_menu'),
                                        'url' => $this->_controller->createUrl('/cms/menu'),
                                        'hasRight' => Yii::app()->user->checkMultiAccess(
                                            Yii::app()->rights->getDefaultRoles('menu', 'cms', 'consult')
                                        )
                                    ),
                                    'items' => array(
                                        array(
                                            'label' => array(
                                                'value' => B::t('backend', 'navbar_cms_menu_group'),
                                                'url' => $this->_controller->createUrl('/cms/menuGroup'),
                                                'hasRight' => Yii::app()->user->checkMultiAccess(
                                                    Yii::app()->rights->getDefaultRoles('menuGroup', 'cms', 'consult')
                                                )
                                            )
                                        )
                                    )
                                ),
                                array(
                                    'label' => array(
                                        'value' => B::t('backend', 'navbar_cms_layout'),
                                        'url' => $this->_controller->createUrl('/cms/layout'),
                                        'hasRight' => Yii::app()->user->checkMultiAccess(
                                            Yii::app()->rights->getDefaultRoles('layout', 'cms', 'consult')
                                        )
                                    )
                                ),
                                array(
                                    'label' => array(
                                        'value' => B::t('backend', 'navbar_cms_widget'),
                                        'url' => $this->_controller->createUrl('/cms/widget'),
                                        'hasRight' => Yii::app()->user->checkMultiAccess(
                                            Yii::app()->rights->getDefaultRoles('widget', 'cms', 'consult')
                                        )
                                    )
                                ),
                                array(
                                    'label' => array(
                                        'value' => B::t('backend', 'navbar_cms_image'),
                                        'url' => $this->_controller->createUrl('/cms/image'),
                                        'hasRight' => Yii::app()->user->checkMultiAccess(
                                            Yii::app()->rights->getDefaultRoles('image', 'cms', 'consult')
                                        )
                                    )
                                ),
                                array(
                                    'label' => array(
                                        'value' => B::t('backend', 'navbar_cms_album'),
                                        'url' => $this->_controller->createUrl('/cms/album'),
                                        'hasRight' => Yii::app()->user->checkMultiAccess(
                                            Yii::app()->rights->getDefaultRoles('album', 'cms', 'consult')
                                        )
                                    )
                                ),
                                array(
                                    'label' => array(
                                        'value' => B::t('backend', 'navbar_cms_news'),
                                        'url' => $this->_controller->createUrl('/cms/news'),
                                        'hasRight' => Yii::app()->user->checkMultiAccess(
                                            Yii::app()->rights->getDefaultRoles('news', 'cms', 'consult')
                                        )
                                    ),
                                    'items' => array(
                                        array(
                                            'label' => array(
                                                'value' => B::t('backend', 'navbar_cms_news_group'),
                                                'url' => $this->_controller->createUrl('/cms/newsGroup'),
                                                'hasRight' => Yii::app()->user->checkMultiAccess(
                                                    Yii::app()->rights->getDefaultRoles('newsGroup', 'cms', 'consult')
                                                )
                                            )
                                        )
                                    )
                                ),
                                array(
                                    'label' => array(
                                        'value' => B::t('backend', 'navbar_cms_social'),
                                        'url' => $this->_controller->createUrl('/cms/social'),
                                        'hasRight' => Yii::app()->user->checkMultiAccess(
                                            Yii::app()->rights->getDefaultRoles('social', 'cms', 'consult')
                                        )
                                    )
                                ),
                            )
                        ),
                        array(
                            'label' => array(
                                'value' => B::t('backend', 'navbar_parameter'),
                                'url' => '#'
                            ),
                            'items' => array(
                                array(
                                    'label' => array(
                                        'value' => B::t('backend', 'navbar_right'),
                                        'url' => '#',
                                        'htmlOptions' => array(
                                            'class' => 'disabled'
                                        )
                                    ),
                                    'items' => array(
                                        array(
                                            'label' => array(
                                                'value' => B::t('backend', 'navbar_person'),
                                                'url' => $this->_controller->createUrl('/right/person'),
                                                'hasRight' => Yii::app()->user->checkMultiAccess(
                                                    Yii::app()->rights->getDefaultRoles('person', 'right', 'consult')
                                                ),
                                                'htmlOptions' => array(
                                                    'class' => 'disabled'
                                                )
                                            )
                                        ),
                                        array(
                                            'label' => array(
                                                'value' => B::t('backend', 'navbar_person_group'),
                                                'url' => $this->_controller->createUrl('/right/group'),
                                                'hasRight' => Yii::app()->user->checkMultiAccess(
                                                    Yii::app()->rights->getDefaultRoles('group', 'right', 'consult')
                                                )
                                            )
                                        ),
                                        array(
                                            'label' => array(
                                                'value' => B::t('backend', 'navbar_role'),
                                                'url' => $this->_controller->createUrl('/right/role'),
                                                'hasRight' => Yii::app()->user->checkMultiAccess(
                                                    Yii::app()->rights->getDefaultRoles('role', 'right', 'consult')
                                                )
                                            )
                                        ),
                                        array(
                                            'label' => array(
                                                'value' => B::t('backend', 'navbar_group_role'),
                                                'url' => $this->_controller->createUrl('/right/groupRole'),
                                                'hasRight' => Yii::app()->user->checkMultiAccess(
                                                    Yii::app()->rights->getDefaultRoles('groupRole', 'right', 'consult')
                                                )
                                            )
                                        )
                                    )
                                ),
                                array(
                                    'label' => array(
                                        'value' => B::t('backend', 'navbar_auto_login'),
                                        'url' => $this->_controller->createUrl('/autoLogin/autoLogin'),
                                        'hasRight' => Yii::app()->user->checkMultiAccess(
                                            Yii::app()->rights->getDefaultRoles('autoLogin', 'autoLogin', 'consult')
                                        )
                                    )
                                ),
                                array(
                                    'label' => array(
                                        'value' => B::t('backend', 'navbar_language'),
                                        'url' => '#',
                                        'htmlOptions' => array(
                                            'class' => 'disabled'
                                        )
                                    ),
                                    'items' => array(
                                        array(
                                            'label' => array(
                                                'value' => B::t('backend', 'navbar_site_i18n'),
                                                'url' => $this->_controller->createUrl('/i18n/siteI18n'),
                                                'hasRight' => Yii::app()->user->checkMultiAccess(Yii::app()->rights->getDefaultRoles('siteI18n', 'i18n', 'consult'))
                                            )
                                        ),
                                        array(
                                            'label' => array(
                                                'value' => B::t('backend', 'navbar_i18n'),
                                                'url' => $this->_controller->createUrl('/i18n/i18n'),
                                                'hasRight' => Yii::app()->user->checkMultiAccess(Yii::app()->rights->getDefaultRoles('i18n', 'i18n', 'consult'))
                                            )
                                        )
                                    )
                                ),
                                array(
                                    'label' => array(
                                        'value' => B::t('backend', 'navbar_variable'),
                                        'url' => $this->_controller->createUrl('/variable/variable'),
                                        'hasRight' => Yii::app()->user->checkMultiAccess(
                                            Yii::app()->rights->getDefaultRoles('variable', 'variable', 'consult')
                                        ),
                                        'htmlOptions' => array(
                                            'class' => 'disabled'
                                        )
                                    ),
                                    'items' => array(
                                        array(
                                            'label' => array(
                                                'value' => B::t('backend', 'navbar_variable_group'),
                                                'url' => $this->_controller->createUrl('/variable/variableGroup'),
                                                'hasRight' => Yii::app()->user->checkMultiAccess(
                                                    Yii::app()->rights->getDefaultRoles('variableGroup', 'variable', 'consult')
                                                )
                                            )
                                        )
                                    )
                                ),
                                array(
                                    'label' => array(
                                        'value' => B::t('backend', 'navbar_cache'),
                                        'url' => '#',
                                        'htmlOptions' => array(
                                            'class' => 'disabled'
                                        )
                                    ),
                                    'items' => array(
                                        array(
                                            'label' => array(
                                                'value' => B::t('backend', 'navbar_db_schema_flush'),
                                                'url' => $this->_controller->createUrl('/cache/dbSchema/flush'),
                                                'hasRight' => Yii::app()->user->checkMultiAccess(Yii::app()->rights->getDefaultRoles('dbSchema', 'cache', 'consult'))
                                            )
                                        ),
                                        array(
                                            'label' => array(
                                                'value' => B::t('backend', 'url_manager_schema_flush'),
                                                'url' => $this->_controller->createUrl('/cache/urlManager/flush'),
                                                'hasRight' => Yii::app()->user->checkMultiAccess(Yii::app()->rights->getDefaultRoles('urlManager', 'cache', 'consult'))
                                            )
                                        )
                                    )
                                ),
                            )
                        )
                    )
                ),
                array(
                    'items' => array(
                        array(
                            'label' => array(
                                'value' => ($this->person !== null) ? $this->person->fullName : '',
                                'url' => '#',
                                'active' => ! Yii::app()->user->isGuest
                            ),
                            'items' => array(
                                array(
                                    'label' => array(
                                        'value' => B::t('backend', 'navbar_profile'),
                                        'url' => $this->_controller->createUrl('/profile/profile'),
                                        'hasRight' => Yii::app()->user->checkMultiAccess(Yii::app()->rights->getDefaultRoles('profile', 'profile', 'update'))
                                    )
                                ),
                                array(
                                    'label' => array(
                                        'value' => B::t('unitkit', 'navbar_logout'),
                                        'url' => $this->_controller->createUrl('/auth/auth/logout'),
                                        'active' => ! Yii::app()->user->isGuest,
                                        'htmlOptions' => array(
                                            'class' => 'static'
                                        )
                                    )
                                )
                            )
                        ),
                        array(
                            'label' => array(
                                'value' => self::buildLanguageSelector()
                            ),
                            'htmlOptions' => array(
                                'class' => 'language-selector'
                            )
                        )
                    ),
                    'htmlOptions' => array(
                        'class' => 'navbar-right'
                    )
                )
            )
        );
    }
}