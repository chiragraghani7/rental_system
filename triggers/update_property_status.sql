DELIMITER //
CREATE TRIGGER update_property_status
AFTER INSERT ON LeaseAgreement
FOR EACH ROW
BEGIN
    UPDATE RentalProperty
    SET status = 'leased'
    WHERE property_number = NEW.property_number;
END;
//
DELIMITER ;
