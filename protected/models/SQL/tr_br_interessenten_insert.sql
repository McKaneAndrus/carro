CREATE TRIGGER tr_br_interessenten_insert
  BEFORE INSERT
  ON br_interessenten FOR EACH ROW
/*
  Trigger  :  tr_br_interessenten_insert

  Author   : sjg  
  Date     : 04/40/2014
  Purpose  : set the record data on trigger insert as MySQL lacks default in all version
*/
begin
        -- Set the creation date IF the inserted field is null
        -- allows for setting the field as well as leaving it
        -- default. int_anlage Field MUST allow NULL on insert
         
        SET NEW.int_anlage = IFNULL(NEW.int_anlage, NOW());
end
/

