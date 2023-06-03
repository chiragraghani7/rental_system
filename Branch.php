<?php
require_once 'DB.php';

class Branch {
    private $branchNumber;
    private $phone;
    private $street;
    private $city;
    private $zip;

    public function __construct($branchNumber, $phone, $street, $city, $zip) {
        $this->branchNumber = $branchNumber;
        $this->phone = $phone;
        $this->street = $street;
        $this->city = $city;
        $this->zip = $zip;
    }

    public function getBranchNumber() {
        return $this->branchNumber;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getStreet() {
        return $this->street;
    }

    public function getCity() {
        return $this->city;
    }

    public function getZip() {
        return $this->zip;
    }
}
?>
