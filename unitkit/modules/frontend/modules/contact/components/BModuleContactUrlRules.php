<?php
/**
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BModuleContactUrlRules extends BBaseModuleUrlRules
{
    /**
     * @see BBaseModuleUrlRules::getRules()
     */
    public function getRules() {
        return $this->buildModuleCmsPageRules(B::v('frontend', 'b_cms_page_id:contact'), 'contact', 'contact');
    }
}