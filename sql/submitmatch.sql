START TRANSACTION

INSERT INTO "Matches" ("matchDate","rulesetId","matchType") VALUES (:matchDate,:rulesetId,:matchType);
INSERT INTO "Sets" ("matchId","stageId") VALUES (SELECT CURRVAL(pg_get_serial_sequence("Matches", "matchId")),:stageId);

COMMIT;