<?php
require_once 'RentalManagementSystem.php';

class ShowLease {
    public function showLease($renterName,$renterPhoneNumber) {

        $system = new RentalManagementSystem();
        $lease = $system->getLeaseByRenterNameOrPhoneNumber($renterName,$renterPhoneNumber);

        // Display the lease agreement
        return $lease;
    }

    public function displayForm() {
        // Display the show lease agreement form
    }
}
?>
