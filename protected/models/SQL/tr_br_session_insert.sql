CREATE TRIGGER tr_br_session_insert
  BEFORE INSERT
  ON br_session FOR EACH ROW
/*
  Trigger  :  tr_br_session_insert

  Author   : sjg  
  Date     : 04/17/2014
  Purpose  : set the record data on trigger insert as MySQL lacks default in all version
*/
begin
        -- Set the creation date IF the inserted field is null
        -- allows for setting the field as well as leaving it
        -- default. sess_datum Field MUST allow NULL on insert
         
        SET NEW.sess_datum = IFNULL(NEW.sess_datum, NOW());
end
/

