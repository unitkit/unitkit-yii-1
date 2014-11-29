<?php

/**
 * @see CHttpRequest
 * @author Kevin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class BBaseHttpRequest extends CHttpRequest
{

    /**
     *
     * @var string the name of the token used to prevent CSRF. Defaults to 'YII_CSRF_TOKEN'.
     *      This property is effectively only when {@link enableCsrfValidation} is true.
     */
    public $csrfTokenName = 'b_csrf_token';

    /**
     * Array of routes without csrf validation
     *
     * @var mixed
     */
    public $noCsrfValidationRoutes = array();

    /**
     * Token
     *
     * @var string
     */
    private $_csrfToken;

    /**
     * @see CHttpRequest::getCsrfToken()
     */
    public function getCsrfToken()
    {
        if ($this->_csrfToken === null) {
            $session = Yii::app()->session;
            $csrfToken = $session->itemAt($this->csrfTokenName);
            if ($csrfToken === null) {
                $csrfToken = BTools::sha512(uniqid(mt_rand(), true) . ':' . BTools::password(500));
                $session->add($this->csrfTokenName, $csrfToken);
            }
            $this->_csrfToken = $csrfToken;
        }
        return $this->_csrfToken;
    }

    /**
     * @see CHttpRequest::normalizeRequest()
     */
    protected function normalizeRequest()
    {
        // attach event handlers for CSRF in the parent
        parent::normalizeRequest();

        // remove the event handler CSRF if this is a route we want skipped
        if ($this->enableCsrfValidation) {
            $route = Yii::app()->getUrlManager()->parseUrl($this);
            if ($this->enableCsrfValidation && false !== array_search($route, $this->noCsrfValidationRoutes)) {
                Yii::app()->detachEventHandler('onBeginRequest', array(
                    $this,
                    'validateCsrfToken'
                ));
            }
        }
    }

    /**
     * @see CHttpRequest::validateCsrfToken()
     */
    public function validateCsrfToken($event)
    {
        // only validate POST requests
        if ($this->getIsPostRequest() || $this->getIsDeleteRequest() || $this->getIsPutRequest() ||
            $this->getIsPutViaPostRequest()) {
            $valid = false;
            $session = Yii::app()->session;
            if ($session->contains($this->csrfTokenName) && isset($_REQUEST[$this->csrfTokenName])) {
                $tokenFromSession = $session->itemAt($this->csrfTokenName);
                $tokenFromPost = $_REQUEST[$this->csrfTokenName];
                $valid = ($tokenFromSession === $tokenFromPost);
            }

            if (! $valid) {;
                throw new CHttpException(403);
            }
        }
    }
}