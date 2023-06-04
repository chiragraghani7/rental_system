DELIMITER //

CREATE TRIGGER check_supervisor_properties
BEFORE INSERT ON RentalProperty
FOR EACH ROW
BEGIN
    DECLARE property_count INT;
    
    SELECT COUNT(*) INTO property_count
    FROM RentalProperty
    WHERE supervisor_id = NEW.supervisor_id;
    
    IF property_count > 3 THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'A supervisor cannot supervise more than three rental properties at a time.';
    END IF;
END //

DELIMITER ;

