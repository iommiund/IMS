<?php

/**
 * Created by PhpStorm.
 * User: Iommi
 * Date: 15/01/2017
 * Time: 16:28
 */
class customer extends person
{

    private $customerID;
    private $dateOfBirth;
    private $nationality;
    private $customerStatus;

    /**
     * @param mixed $customerID
     */
    public function setCustomerID($customerID)
    {
        $this->customerID = $customerID;
    }

    /**
     * @return mixed
     */
    public function getCustomerID()
    {
        return $this->customerID;
    }

    /**
     * @param mixed $dateOfBirth
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    /**
     * @return mixed
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * @param mixed $nationality
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;
    }

    /**
     * @return mixed
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * @param mixed $customerStatus
     */
    public function setCustomerStatus($customerStatus)
    {
        $this->customerStatus = $customerStatus;
    }

    /**
     * @return mixed
     */
    public function getCustomerStatus()
    {
        return $this->customerStatus;
    }
}