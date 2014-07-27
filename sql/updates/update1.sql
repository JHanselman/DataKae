BEGIN TRANSACTION;

CREATE TABLE "3DS_Items"
(
  "itemId" serial NOT NULL,
  "itemName" character varying NOT NULL,
  
  PRIMARY KEY ("itemId"),
  UNIQUE ("itemName")
);

CREATE TABLE "3DS_Stages"
(
  "stageId" serial NOT NULL,
  "stageName" character varying NOT NULL,
  
  PRIMARY KEY ("stageId"),
  UNIQUE ("stageName")
);

CREATE TABLE "3DS_Tournaments"
(
  "tournamentId" serial NOT NULL,
  "tournamentName" character varying NOT NULL,
  "locationId" integer NOT NULL,
  "startDate" date NOT NULL,
  "endDate" date,
  "rulesetId" integer,
  "financesId" integer,
  "totalEntrants" integer,
  "totalDuration" interval,
  "createdOn" timestamp without time zone,
  "changedOn" timestamp without time zone,

  PRIMARY KEY ("tournamentId"),
  FOREIGN KEY ("locationId") REFERENCES "Location",
  FOREIGN KEY ("rulesetId") REFERENCES "Rulesets",
  FOREIGN KEY ("financesId") REFERENCES "Finances"
);

CREATE TABLE "3DS_Organization"
(
  "organizationId" serial NOT NULL,
  "tournamentId" integer NOT NULL,
  "organizationNumber" integer,
  "roundStyle" character varying DEFAULT 'Double-Elimination',
  "numberEntrants" integer,
  "numberStations" integer,
  "duration" interval,

  PRIMARY KEY ("organizationId"),
  FOREIGN KEY ("tournamentId") REFERENCES "3DS_Tournaments"
);

CREATE TABLE "3DS_Rounds"
(
  "roundId" serial NOT NULL,
  "organizationId" integer NOT NULL,
  "roundNumber" integer NOT NULL,
  "numberEntrants" integer NOT NULL,
  "duration" interval,
  

  PRIMARY KEY ("organizationId"),
  FOREIGN KEY ("organizationId") REFERENCES "3DS_Organization"
);

CREATE TABLE "3DS_Tournament_Players"
(
  "tournamentId" integer NOT NULL,
  "playerId" integer NOT NULL,
  "placing" character varying,
  
  PRIMARY KEY ("tournamentId", "playerId"),
  FOREIGN KEY ("tournamentId") REFERENCES "3DS_Tournaments" ON DELETE CASCADE, 
  FOREIGN KEY ("playerId") REFERENCES "Players" ON DELETE CASCADE
);


CREATE TABLE "3DS_Tournament_Organizers"
(
  "tournamentId" integer NOT NULL,
  "userId" integer NOT NULL,
  "job" character varying,
  
  PRIMARY KEY ("tournamentId", "userId"),
  FOREIGN KEY ("tournamentId") REFERENCES "3DS_Tournaments" ON DELETE CASCADE,
  FOREIGN KEY ("userId") REFERENCES "Users" ON DELETE CASCADE
);

CREATE TABLE "3DS_Tournament_Stages"
(
  "tournamentId" integer NOT NULL,
  "stageId" integer NOT NULL,
  "stageStatus" integer NOT NULL DEFAULT 2,
  
  PRIMARY KEY ("tournamentId", "stageId"),
  FOREIGN KEY ("tournamentId") REFERENCES "3DS_Tournaments" ON DELETE CASCADE,
  FOREIGN KEY ("stageId") REFERENCES "3DS_Stages" ON DELETE CASCADE
);

CREATE TABLE "3DS_Tournament_Characters"
(
  "tournamentId" integer NOT NULL,
  "characterId" integer NOT NULL,
  "characterStatus" integer NOT NULL DEFAULT 2,
  
  PRIMARY KEY ("tournamentId", "characterId"),
  FOREIGN KEY ("tournamentId") REFERENCES "3DS_Tournaments" ON DELETE CASCADE,
  FOREIGN KEY ("characterId") REFERENCES "Characters" ON DELETE CASCADE
);

CREATE TABLE "3DS_Tournament_Items"
(
  "tournamentId" integer NOT NULL,
  "itemId" integer NOT NULL,
  "itemStatus" integer NOT NULL DEFAULT 0,
  
  PRIMARY KEY ("tournamentId", "itemId"),
  FOREIGN KEY ("tournamentId") REFERENCES "3DS_Tournaments" ON DELETE CASCADE,
  FOREIGN KEY ("itemId") REFERENCES "3DS_Items" ON DELETE CASCADE
);

CREATE TABLE "3DS_Matches"
(
  "matchId" serial NOT NULL,
  "tournamentId" integer NOT NULL,
  "roundId" integer,
  "previousMatch" integer,
  "nextMatch" integer,
  "player1" integer NOT NULL,
  "player2" integer NOT NULL,
  "player3" integer,
  "player4" integer,
  "winner1" integer NOT NULL,
  "winner2" integer,
  "comments" character varying,
  
  PRIMARY KEY ("matchId"),
  FOREIGN KEY ("tournamentId") REFERENCES "3DS_Tournaments",
  FOREIGN KEY ("roundId") REFERENCES "3DS_Rounds",
  FOREIGN KEY ("previousMatch") REFERENCES "3DS_Matches" ("matchId"),
  FOREIGN KEY ("nextMatch") REFERENCES "3DS_Matches" ("matchId"),
  FOREIGN KEY ("player1") REFERENCES "Players" ("playerId"),
  FOREIGN KEY ("player2") REFERENCES "Players" ("playerId"),
  FOREIGN KEY ("player3") REFERENCES "Players" ("playerId"),
  FOREIGN KEY ("player4") REFERENCES "Players" ("playerId"),
  FOREIGN KEY ("winner1") REFERENCES "Players" ("playerId"),
  FOREIGN KEY ("winner2") REFERENCES "Players" ("playerId")
);

CREATE TABLE "3DS_Games"
(
  "gameId" serial NOT NULL,
  "matchId" integer NOT NULL,
  "gameNumber" integer NOT NULL,
  "characterPlayer1" integer NOT NULL,
  "characterPlayer2" integer NOT NULL,
  "characterPlayer3" integer,
  "characterPlayer4" integer,
  "stage" character varying NOT NULL,
  "stagePicker1" integer,
  "stagePicker2" integer,
  "player1StocksLeft" integer DEFAULT 0,
  "player2StocksLeft" integer DEFAULT 0,
  "player3StocksLeft" integer DEFAULT 0,
  "player4StocksLeft" integer DEFAULT 0,
  "player1Percentage" integer,
  "player2Percentage" integer,
  "player3Percentage" integer,
  "player4Percentage" integer,
  "timeLeft" interval,
  "winner1" integer NOT NULL,
  "winner2" integer,
  "link" character varying,
  "comments" character varying,
  
  PRIMARY KEY ("gameId"),
  FOREIGN KEY ("matchId") REFERENCES "3DS_Matches",
  FOREIGN KEY ("characterPlayer1") REFERENCES "Characters" ("characterId"),
  FOREIGN KEY ("characterPlayer2") REFERENCES "Characters" ("characterId"),
  FOREIGN KEY ("characterPlayer3") REFERENCES "Characters" ("characterId"),
  FOREIGN KEY ("characterPlayer4") REFERENCES "Characters" ("characterId")
);

COMMIT;