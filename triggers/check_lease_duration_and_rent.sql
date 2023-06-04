DELIMITER //
CREATE TRIGGER check_lease_duration_and_rent
BEFORE INSERT ON LeaseAgreement
FOR EACH ROW
BEGIN
    DECLARE lease_duration INT;
    DECLARE regular_rent DECIMAL(10, 2);
    
    -- Calculate the duration of the lease in months
    SET lease_duration = PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM NEW.end_date), EXTRACT(YEAR_MONTH FROM NEW.start_date));
    
    -- Retrieve the regular rent for the property
    SELECT monthly_rent INTO regular_rent
    FROM RentalProperty
    WHERE property_number = NEW.property_number;
    
    IF lease_duration < 6 OR lease_duration > 12 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'A lease agreement should be for a minimum of six months and a maximum of one year.';
    ELSEIF lease_duration = 6 THEN
        -- Set the monthly rent to 10% more than the regular rent for a six-month lease
        SET NEW.monthly_rent = regular_rent * 1.1;
    END IF;
END;
//
DELIMITER ;
