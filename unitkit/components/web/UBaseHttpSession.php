<?php

/**
 * @see CHttpSession
 * @author Kévin Walter <walkev13@gmail.com>
 * @version 1.0
 */
class UBaseHttpSession extends CHttpSession
{

    /**
     * Initializes the application component.
     * This method is required by IApplicationComponent and is invoked by application.
     */
    public function init()
    {
        parent::init();
        if ($this->autoStart) {
            $this->restoreSession();
            $this->initSessionKey();
        }
    }

    protected function initSessionKey()
    {
        if (! isset($this['sess_key'])) {
            // generate a session key (session key is used to restore a session ex: BUploader)
            $this['sess_key'] = UTools::sha512(uniqid(mt_rand(), true) . ':' . UTools::password(500));
        }
    }

    /**
     * Restore a session
     * Required by Flash plugin (upload)
     */
    public function restoreSession()
    {
        // the session ID and session key is required to restore a session
        if (isset($_POST['sess_id']) && isset($_POST['sess_key'])) {
            // close the current session
            $this->close();
            // set a new session ID
            $this->sessionID = $_POST['sess_id'];
            // open the session
            $this->open();

            // if session key is not valid the session is destroy
            if (empty($this['sess_key']) || ($this['sess_key'] !== $_POST['sess_key'])) {
                $this->close();
                $this->destroy();
                throw new CHttpException(403);
            }
        }
    }
}