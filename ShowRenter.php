<?php
require_once 'RentalManagementSystem.php';

class ShowRenter {
    public function showRenterWithMoreThanOneLease() {

        $system = new RentalManagementSystem();
        $renters = $system->getRenterWithMoreThanOneLease();
        return $renters;
    }

}
?>