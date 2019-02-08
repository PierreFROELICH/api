
17


BEGIN
    DECLARE rlo1 DOUBLE;
    DECLARE rla1 DOUBLE;
    DECLARE rlo2 DOUBLE;
    DECLARE rla2 DOUBLE;
    DECLARE dlo DOUBLE;
    DECLARE dla DOUBLE;
    DECLARE a DOUBLE;
        SET rlo1 = RADIANS($longitude);
        SET rla1 = RADIANS($latitude);
        SET rlo2 = RADIANS(best.longitude);
        SET rla2 = RADIANS(best.latitude);
        SET dlo = (RADIANS(best.longitude) - RADIANS($longitude)) / 2;
    SET dla = (RADIANS(best.latitude) - RADIANS($latitude)) / 2;

    SET a = SIN((RADIANS(best.latitude) - RADIANS($latitude)) / 2) * SIN((RADIANS(best.latitude) - RADIANS($latitude)) / 2) + COS(RADIANS($latitude)) * COS(RADIANS(best.latitude)) * SIN((RADIANS(best.longitude) - RADIANS($longitude)) / 2) * SIN((RADIANS(best.longitude) - RADIANS($longitude)) / 2);
    RETURN (6378137 * 2 * ATAN2(SQRT( SIN((RADIANS(best.latitude) - RADIANS($latitude)) / 2) * SIN((RADIANS(best.latitude) - RADIANS($latitude)) / 2) + COS(RADIANS($latitude)) * COS(RADIANS(best.latitude)) * SIN((RADIANS(best.longitude) - RADIANS($longitude)) / 2) * SIN((RADIANS(best.longitude) - RADIANS($longitude)) / 2)), SQRT(1 -  SIN((RADIANS(best.latitude) - RADIANS($latitude)) / 2) * SIN((RADIANS(best.latitude) - RADIANS($latitude)) / 2) + COS(RADIANS($latitude)) * COS(RADIANS(best.latitude)) * SIN((RADIANS(best.longitude) - RADIANS($longitude)) / 2) * SIN((RADIANS(best.longitude) - RADIANS($longitude)) / 2))));
END

  'distance' => new Expression(" (6371 * ACOS( COS( RADIANS($latitude) ) * COS( RADIANS( latitude ) ) * COS( RADIANS( longitude ) - RADIANS($longitude) ) + SIN( RADIANS($latitude) ) * SIN( RADIANS( latitude ) ) ) )")
        ))
