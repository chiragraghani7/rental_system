<?php
class LeaseAgreement implements JsonSerializable{
    // private $leaseId;
    private $propertyNumber;
    private $renterName;
    private $homePhone;
    private $workPhone;
    private $startDate;
    private $endDate;
    private $depositAmount;
    private $monthlyRent;

    public function __construct( $propertyNumber, $renterName, $homePhone, $workPhone, $startDate, $endDate, $depositAmount, $monthlyRent) {
        // $this->leaseId = $leaseId;
        $this->propertyNumber = $propertyNumber;
        $this->renterName = $renterName;
        $this->homePhone = $homePhone;
        $this->workPhone = $workPhone;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->depositAmount = $depositAmount;
        $this->monthlyRent = $monthlyRent;
    }


    public function getPropertyNumber() {
        return $this->propertyNumber;
    }

    public function getRenterName() {
        return $this->renterName;
    }

    public function getHomePhone() {
        return $this->homePhone;
    }

    public function getWorkPhone() {
        return $this->workPhone;
    }

    public function getStartDate() {
        return $this->startDate;
    }

    public function getEndDate() {
        return $this->endDate;
    }

    public function getDepositAmount() {
        return $this->depositAmount;
    }

    public function getMonthlyRent() {
        return $this->monthlyRent;
    }

    public function toString() {
        return "Property Number: " . $this->propertyNumber . "\n" .
            "Renter Name: " . $this->renterName . "\n" .
            "Home Phone: " . $this->homePhone . "\n" .
            "Work Phone: " . $this->workPhone . "\n" .
            "Start Date: " . $this->startDate . "\n" .
            "End Date: " . $this->endDate . "\n" .
            "Deposit Amount: " . $this->depositAmount . "\n" .
            "Monthly Rent: " . $this->monthlyRent;
    }

    public function jsonSerialize() {
        return (object) get_object_vars($this);
    }
}

?>
