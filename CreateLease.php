<?php
require_once 'RentalManagementSystem.php';

class CreateLease {
    public function createLeaseAgreement($leaseData) {
        $tenantName = $leaseData["tenantName"];
        $propertyNumber = $leaseData["propertyNumber"];
        $homePhone = $leaseData["homePhone"];
        $workPhone = $leaseData["workPhone"];
        $startDate = $leaseData["startDate"];
        $endDate = $leaseData["endDate"];
        $depositAmount = $leaseData["depositAmount"];
        $monthlyRent = $leaseData["monthlyRent"];

        $system = new RentalManagementSystem();
        $leaseAgreement = $system->generateLeaseAgreement($tenantName,$propertyNumber,$homePhone,$workPhone,$startDate,$endDate,$depositAmount,$monthlyRent);
        return $leaseAgreement;
    }

    public function processForm() {
        // $data = $_POST; // Assuming form data is sent via POST

        // $system = new RentalManagementSystem();
        // $lease = $system->getLeaseAgreementByRenter($data);
        return null;
        // Display the lease agreement
    }
    

    public function displayForm() {
        // Display the create lease agreement form
    }
}
?>
