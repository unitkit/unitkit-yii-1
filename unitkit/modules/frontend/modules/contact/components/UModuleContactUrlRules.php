<?php
/**
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UModuleContactUrlRules extends UBaseModuleUrlRules
{
    /**
     * @see UBaseModuleUrlRules::getRules()
     */
    public function getRules() {
        return $this->buildModuleCmsPageRules(Unitkit::v('frontend', 'u_cms_page_id:contact'), 'contact', 'contact');
    }
}