<?php
require_once 'DB.php';

class Owner {
    private $ownerId;
    private $name;
    private $permanentAddress;
    private $phone;

    public function __construct($ownerId, $name, $permanentAddress, $phone) {
        $this->ownerId = $ownerId;
        $this->name = $name;
        $this->permanentAddress = $permanentAddress;
        $this->phone = $phone;
    }

    public function getOwnerId() {
        return $this->ownerId;
    }

    public function getName() {
        return $this->name;
    }

    public function getPermanentAddress() {
        return $this->permanentAddress;
    }

    public function getPhone() {
        return $this->phone;
    }
}
?>
