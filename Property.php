<?php
require_once 'DB.php';

class Property implements JsonSerializable{
    private $propertyNumber;
    private $ownerId;
    private $supervisorId;
    private $street;
    private $city;
    private $zip;
    private $numRooms;
    private $monthlyRent;
    private $status;
    private $startDate;
    private $name;

    public function __construct($propertyNumber, $ownerId, $supervisorId, $street, $city, $zip, $numRooms, $monthlyRent, $status, $startDate) {
        $this->propertyNumber = $propertyNumber;
        $this->ownerId = $ownerId;
        $this->supervisorId = $supervisorId;
        $this->street = $street;
        $this->city = $city;
        $this->zip = $zip;
        $this->numRooms = $numRooms;
        $this->monthlyRent = $monthlyRent;
        $this->status = $status;
        $this->startDate = $startDate;
    }

    public function getPropertyNumber() {
        return $this->propertyNumber;
    }

    public function getOwnerId() {
        return $this->ownerId;
    }

    public function getSupervisorId() {
        return $this->supervisorId;
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

    public function getNumRooms() {
        return $this->numRooms;
    }

    public function getMonthlyRent() {
        return $this->monthlyRent;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getStartDate() {
        return $this->startDate;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function getName(){
        return $this->name;
    }

    public function __toString() {
        return $this->toString();
    }

    public function toString() {
        return "Property Number: " . $this->getPropertyNumber() . "\n" .
               "Owner ID: " . $this->getOwnerId() . "\n" .
               "Supervisor ID: " . $this->getSupervisorId() . "\n" .
               "Street: " . $this->getStreet() . "\n" .
               "City: " . $this->getCity() . "\n" .
               "Zip: " . $this->getZip() . "\n" .
               "Number of Rooms: " . $this->getNumRooms() . "\n" .
               "Monthly Rent: " . $this->getMonthlyRent() . "\n" .
               "Status: " . $this->getStatus() . "\n" .
               "Start Date: " . $this->getStartDate() . "\n";
    }

    public function jsonSerialize() {
        return (object) get_object_vars($this);
    }
}
?>
