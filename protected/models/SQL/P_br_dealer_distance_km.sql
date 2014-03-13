CREATE PROCEDURE P_br_dealer_distance_km(postal_code_id NVarChar(20), dist_km Integer(11), max_limit Integer(11))
  NO SQL
BEGIN
--
-- P_br_dealer_distance_km((NVchar) postal_code_id, (integer) dist_km, (integer) max_limit) 
--
-- **************************************
-- ***** COUNTRY SPECIFIC PROCEDURE *****
-- **************************************
--
-- Uses br_haendler (dealer) table *** COUNTRY SPECIFIC TABLE
-- Uses postal_codes - used for user look up of latitude and longitude
--
--
-- nvchar postal_code - postal code of the user must be entered in this format '00000-000'
-- integer dist_km - bounding box size in km
-- integer max_limit - max number of rows to return
--
-- Returns record result set orderd by distance   
--  record_id, postal_code, city, latitued, longitude, distance as following fields from br_haendler
--    hd_id, hd_name, hd_str, hd_ort, hd_plz, hd_tel, and the derived distance from the user
-- 
-- If the dealer has not entered their latitue, longitude they will likely default
-- to (0.0, 0.0) for the pair and that is a spot in the atlantic ocean I think...
--
-- The users brazil postal code is currently represented with 5 digit accuracy, and
-- the last 3 digits are stripped off before query of the postal_code database and
-- then the postal_code is created with the '-000' suffix
--
-- COMPATIBILITY WARNING on MySQL prior to MySQL 5.5.6 you can't pass a parameter to the LIMIT. For these 
-- versions the limit is fixed at 10, unless you want to make it WORK...
--
-- Revisons:
-- 02/27/2014 sjg Begat 
-- 
declare mylon double; declare mylat double;
declare lon1 float; declare lon2 float;
declare lat1 float; declare lat2 float;

--
-- get the users lon and lat for their specified postal code (massaged a bit)
--

select longitude, latitude into mylon, mylat from br_postal_codes
where br_postal_codes.code = CONCAT(LEFT(postal_code_id, 5),'-000') COLLATE utf8_unicode_ci limit 1;

--
-- calculate lon and lat for the rectangle:
--

set lon1 = mylon - dist_km/abs(cos(radians(mylat))*111.045);
set lon2 = mylon+dist_km/abs(cos(radians(mylat))*111.045);
set lat1 = mylat-(dist_km/111.045); 
set lat2 = mylat+(dist_km/111.045);

--
-- run the query with complex haversine formla (great circle formula) see
-- web/wikipedia for more info and links to sample mysql code
--

SELECT destination.hd_id, destination.hd_name, destination.hd_str, destination.hd_ort, 
        destination.hd_plz, destination.hd_tel,
        TRUNCATE( 6372 * 2 * ASIN(SQRT( POWER(SIN((origin.latitude - destination.hd_latitude) * 
        pi()/180 / 2), 2) + COS(origin.latitude * pi()/180) * 
        COS(destination.hd_latitude * pi()/180) * 
        POWER(SIN((origin.longitude -destination.hd_longitude) * 
        pi()/180 / 2), 2) )), 1 ) as distance 
FROM br_haendler destination, br_postal_codes origin
WHERE origin.code=CONCAT(LEFT(postal_code_id, 5) ,'-000') COLLATE utf8_unicode_ci
    and destination.hd_longitude between lon1 and lon2
    and destination.hd_latitude between lat1 and lat2
    and destination.hd_status=0
HAVING distance < dist_km ORDER BY Distance limit 10;
    
END
/
