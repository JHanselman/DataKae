BEGIN TRANSACTION;


-- Adds all regions.
INSERT INTO "Stages" ("stageName") VALUES ('Arena Ferox');
INSERT INTO "Stages" ("stageName") VALUES ('Battlefield');
INSERT INTO "Stages" ("stageName") VALUES ('Nintendogs Stage');

COMMIT;