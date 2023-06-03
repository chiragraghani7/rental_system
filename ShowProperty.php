<?php
require_once 'RentalManagementSystem.php';

class ShowProperty  {
    public function showPropertiesByBranch($branchName) {
        $system = new RentalManagementSystem();
        $showProperty = $system->getPropertiesByBranch($branchName);

        return $showProperty;
    }

    public function showPropertiesBySupervisor() {
        $system = new RentalManagementSystem();
        $showProperty = $system->getPropertiesBySupervisor();

        return $showProperty;
    }

    public function showPropertiesByOwner($ownerName,$ownerPhoneNumber,$branchName){
        $system = new RentalManagementSystem();
        $showProperty = $system->getPropertiesByOwner($ownerName,$ownerPhoneNumber,$branchName);
        return $showProperty;
    }

    public function showPropertiesByCriteria($city, $numRooms, $minRent, $maxRent){
        $system = new RentalManagementSystem();
        $showProperty = $system->getPropertiesByCriteria($city, $numRooms, $minRent, $maxRent);
        return $showProperty;
    }

    public function showAvailablePropertiesByBranch(){
        $system = new RentalManagementSystem();
        $showProperty = $system->getvailablePropertiesByBranch();
        return $showProperty;
    }

}
?>
