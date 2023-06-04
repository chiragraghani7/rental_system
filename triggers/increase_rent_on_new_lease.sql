DELIMITER //
CREATE TRIGGER increase_rent_on_new_lease
AFTER INSERT ON LeaseAgreement
FOR EACH ROW
BEGIN
    DECLARE previous_rent DECIMAL(10,2);
    DECLARE new_rent DECIMAL(10,2);
    
    -- Get the previous rent for the property
    SELECT monthly_rent INTO previous_rent
    FROM RentalProperty
    WHERE property_number = NEW.property_number;
    
    -- Calculate the new rent with a 10% increase
    SET new_rent = previous_rent * 1.1;
    
    -- Update the rent in the RentalProperty table
    UPDATE RentalProperty
    SET monthly_rent = new_rent
    WHERE property_number = NEW.property_number;
END //
DELIMITER ;
