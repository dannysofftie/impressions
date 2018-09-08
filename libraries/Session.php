<?php

namespace Libraries;

/**
 * Utility library for managin sessions at company level
 *
 * User specific information will be stored in sessions to manage data filtering
 */
class Session
{
    /**
     * Unique identifier for every login
     *
     * @var [string]
     */
    public $sessionId;
    /**
     * Company identifier
     *
     * @var [int]
     */
    public $companyId;

    /**
     * Company email adress
     *
     * @var [type]
     */
    public $companyEmailAddress;

    /**
     * Current logged in employee full names
     *
     * @var [string]
     */
    public $employeeFullNames;

    /**
     * Current logged in employee email address
     *
     * @var [string]
     */
    public $employeeEmailAddress;

    /**
     * Current logged in employee type
     *
     * @var [string]
     */
    public $employeeType;

    /**
     * Current logged in employee identifier
     *
     * @var [string]
     */
    public $employeeId;

    /**
     * Current logged in employee authentication level
     *
     * @var [string]
     */
    public $employeeAuthLevel;

    /**
     * Current logged in employee allocated region
     *
     * @var [string]
     */
    public $allocatedRegion;

    public function __construct(array $session)
    {
        $this->companyId = $session['companyId'];
        $this->allocatedRegion = $session['allocatedRegion'];
        $this->companyEmailAddress = $session['companyEmailAddress'];
        $this->employeeAuthLevel = $session['employeeAuthLevel'];
        $this->employeeEmailAddress = $session['employeeEmailAddress'];
        $this->employeeFullNames = $session['employeeFullNames'];
        $this->employeeId = $session['employeeId'];
        $this->employeeType = $session['employeeType'];
        $this->sessionId = $this->generateSessionId();
        $this->startSession();
    }

    /**
     * Start session and set session variables
     *
     * @return void
     */
    private function startSession()
    {
        session_id($this->sessionId);
        session_unset();
        ob_start();
        session_start();

        $_SESSION['currentSession'] = $this->sessionId;
        $_SESSION['companyId'] = $this->companyId;
        $_SESSION['allocatedRegion'] = $this->allocatedRegion;
        $_SESSION['companyEmailAddress'] = $this->companyEmailAddress;
        $_SESSION['employeeAuthLevel'] = $this->employeeAuthLevel;
        $_SESSION['employeeEmailAddress'] = $this->employeeEmailAddress;
        $_SESSION['employeeFullNames'] = $this->employeeFullNames;
        $_SESSION['employeeId'] = $this->employeeId;
        $_SESSION['employeeType'] = $this->employeeType;

        ob_end_flush();
        return;
    }

    /**
     * Generate a session id, or return existing id if a session exists
     *
     * @return string
     */
    private function generateSessionId()
    {
        return !$_SESSION ? strtolower(bin2hex(openssl_random_pseudo_bytes(18, $cstrong))) : session_id();
    }

    /**
     * Retrieve current session id
     *
     * @return string
     */
    public static function retrieveSessionId()
    {
        return session_id();
    }

    /**
     * Terminate existing session
     *
     * @return void
     */
    public static function terminateCurrentSession()
    {
        session_start();
        session_destroy();
        session_unset();
        header('/company-trial', true, 301);
    }

    /**
     * Find a session by its value and return value
     *
     * @param string $value
     * @return string
     */
    public static function getSession(string $value = '')
    {
       @session_start(); // suppress session has already been started warnings
        if (!isset($value)) {
            return $_SESSION;
        }
        
        return $_SESSION[$value];
    }
}
