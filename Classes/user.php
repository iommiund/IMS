<?php

/**
 * Created by PhpStorm.
 * User: Iommi
 * Date: 15/01/2017
 * Time: 16:28
 */
class user extends person
{

    private $userID;
    private $username;
    private $password;
    private $userType;
    private $userStatus;

    /**
     * @param mixed $userID
     */
    public function setUserID($userID)
    {
        $this->userID = $userID;
    }

    /**
     * @return mixed
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $userType
     */
    public function setUserType($userType)
    {
        $this->userType = $userType;
    }

    /**
     * @return mixed
     */
    public function getUserType()
    {
        return $this->userType;
    }

    /**
     * @param mixed $userStatus
     */
    public function setUserStatus($userStatus)
    {
        $this->userStatus = $userStatus;
    }

    /**
     * @return mixed
     */
    public function getUserStatus()
    {
        return $this->userStatus;
    }

}