BEGIN TRANSACTION;

DELETE FROM "AuthItemChild" VALUES ('authenticated', 'updateOwnTourney');

DELETE FROM "AuthItem" VALUES ('deleteOwnTourney', 1, 'delete own tourney', 'return TournamentOrganizers::ownTourney($params["Tournament"]->tournamentId,Yii::app()->user->id);', 'N;');

INSERT INTO "AuthItem" VALUES ('TO', 2, 'tournamentOrganizer', NULL, 'N;');

INSERT INTO "AuthItem" VALUES ('editOwnTourney', 1, 'edit own tourney', 'return TournamentOrganizers::ownTourney($params["Tournament"]->tournamentId,Yii::app()->user->id);', 'N;');

INSERT INTO "AuthItemChild" VALUES ('TO', 'editOwnTourney');

ALTER TABLE "Matches" ADD COLUMN "gamesNr" integer NOT NULL;

ALTER TABLE "Games" DROP CONSTRAINT "Games_matchId_fkey";

ALTER TABLE "Games" ADD CONSTRAINT "Games_matchId_fkey" FOREIGN KEY ("matchId")
REFERENCES "Matches" ("matchId") ON DELETE CASCADE;

ALTER TABLE "Matches" ADD COLUMN "createdOn" timestamp; 
ALTER TABLE "Matches" ADD COLUMN "createdBy" varchar(30);
ALTER TABLE "Matches" ADD COLUMN "changedOn" timestamp;
ALTER TABLE "Matches" ADD COLUMN "changedBy" varchar(30);

ALTER TABLE "Tournaments" ADD COLUMN "createdOn" timestamp; 
ALTER TABLE "Tournaments" ADD COLUMN "changedOn" timestamp;

ALTER TABLE "Users" ALTER COLUMN "userName" TYPE varchar(30);
ALTER TABLE "Users" ALTER COLUMN "emailAddress" TYPE varchar(255);

ALTER TABLE "Players" ALTER COLUMN "playerName" TYPE varchar(50);
ALTER TABLE "Players" ALTER COLUMN "playerLastName" TYPE varchar(50);
ALTER TABLE "Players" ALTER COLUMN "playerNickname" TYPE varchar(50) NOT NULL;

ALTER TABLE "Matches" DROP CONSTRAINT "Matches_winner1_fkey";

COMMIT;