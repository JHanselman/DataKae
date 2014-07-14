BEGIN TRANSACTION;

CREATE TABLE "AuthItem"
(
  name character varying(64) NOT NULL,
  type integer NOT NULL,
  description text,
  bizrule text,
  data text,
  CONSTRAINT "AuthItem_pkey" PRIMARY KEY (name)
);

CREATE TABLE "AuthAssignment"
(
  itemname character varying(64) NOT NULL,
  userid character varying(64) NOT NULL,
  bizrule text,
  data text,
  CONSTRAINT "AuthAssignment_pkey" PRIMARY KEY (itemname, userid),
  CONSTRAINT "AuthAssignment_itemname_fkey" FOREIGN KEY (itemname)
      REFERENCES "AuthItem" (name) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "AuthItemChild"
(
  parent character varying(64) NOT NULL,
  child character varying(64) NOT NULL,
  CONSTRAINT "AuthItemChild_pkey" PRIMARY KEY (parent, child),
  CONSTRAINT "AuthItemChild_child_fkey" FOREIGN KEY (child)
      REFERENCES "AuthItem" (name) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT "AuthItemChild_parent_fkey" FOREIGN KEY (parent)
      REFERENCES "AuthItem" (name) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "Location"
(
  "locationId" serial NOT NULL,
  "locationName" character varying NOT NULL,
  "locationCode" character varying(10) NOT NULL,
  "regionName" character varying NOT NULL,
  "regionCode" character varying(4) NOT NULL,
  
  PRIMARY KEY ("locationId"),
  UNIQUE ("locationCode"),
  UNIQUE ("locationName")
);

CREATE TABLE "Players"
(
  "playerId" serial NOT NULL,
  "playerName" character varying NOT NULL,
  "playerLastName" character varying NOT NULL,
  "playerNickname" character varying NOT NULL,
  "locationId" serial NOT NULL,
  
  PRIMARY KEY ("playerId"),
  FOREIGN KEY ("locationId") REFERENCES "Location",
  UNIQUE ("playerNickname")
);

CREATE TABLE "Users"
(
  "userId" serial NOT NULL,
  "playerId" integer,
  "userName" character varying NOT NULL,
  "emailAddress" character varying NOT NULL,
  "passwordHash" character varying(100) NOT NULL,
  
  PRIMARY KEY ("userId"),
  FOREIGN KEY ("playerId") REFERENCES "Players",
  UNIQUE ("emailAddress"),
  UNIQUE ("userName")
);

CREATE TABLE "Characters"
(
  "characterId" serial NOT NULL,
  "characterName" character varying NOT NULL,
  
  PRIMARY KEY ("characterId"),
  UNIQUE ("characterName")
);

CREATE TABLE "Items"
(
  "itemId" serial NOT NULL,
  "itemName" character varying NOT NULL,
  
  PRIMARY KEY ("itemId"),
  UNIQUE ("itemName")
);

CREATE TABLE "Stages"
(
  "stageId" serial NOT NULL,
  "stageName" character varying NOT NULL,
  
  PRIMARY KEY ("stageId"),
  UNIQUE ("stageName")
);

CREATE TABLE "Rulesets"
(
  "rulesetId" serial NOT NULL,
  "rulesetName" character varying NOT NULL,
  "matchType" character varying NOT NULL DEFAULT '1v1',
  "matchMode" character varying NOT NULL DEFAULT 'Stocks',
  "numberStocks" integer NOT NULL DEFAULT 4,
  "numberTimer" interval NOT NULL DEFAULT '0:08:00',
  "itemRate" character varying NOT NULL DEFAULT 'None',
  "specialRules" character varying,
  
  PRIMARY KEY ("rulesetId"),
  UNIQUE ("rulesetName")
);

CREATE TABLE "Finances"
(
  "financesId" serial NOT NULL,
  "entryFee" float NOT NULL,
  "grossMoney" float,
  "houseCut" float,
  "distributionModel" character varying,
  "averageExpenses" float,
  "firstPlaceWinnings" float,
  "secondPlaceWinnings" float,
  "thirdPlaceWinnings" float,
  "fourthPlaceWinnings" float,
  "fifthPlaceWinnings" float,
  "sixthPlaceWinnings" float,
  "seventhPlaceWinnings" float,
  "eigthPlaceWinnings" float,
  "netGain" float,

  PRIMARY KEY ("financesId")
);

CREATE TABLE "Tournaments"
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
  
  PRIMARY KEY ("tournamentId"),
  FOREIGN KEY ("locationId") REFERENCES "Location",
  FOREIGN KEY ("rulesetId") REFERENCES "Rulesets",
  FOREIGN KEY ("financesId") REFERENCES "Finances"
);

CREATE TABLE "Organization"
(
  "organizationId" serial NOT NULL,
  "tournamentId" integer NOT NULL,
  "organizationNumber" integer,
  "roundStyle" character varying DEFAULT 'Double-Elimination',
  "numberEntrants" integer,
  "numberStations" integer,
  "duration" interval,

  PRIMARY KEY ("organizationId"),
  FOREIGN KEY ("tournamentId") REFERENCES "Tournaments"
);

CREATE TABLE "Rounds"
(
  "roundId" serial NOT NULL,
  "organizationId" integer NOT NULL,
  "roundNumber" integer NOT NULL,
  "numberEntrants" integer NOT NULL,
  "duration" interval,
  

  PRIMARY KEY ("organizationId"),
  FOREIGN KEY ("organizationId") REFERENCES "Organization"
);

CREATE TABLE "Tournament_Players"
(
  "tournamentId" integer NOT NULL,
  "playerId" integer NOT NULL,
  "placing" character varying,
  
  PRIMARY KEY ("tournamentId", "playerId"),
  FOREIGN KEY ("tournamentId") REFERENCES "Tournaments" ON DELETE CASCADE, 
  FOREIGN KEY ("playerId") REFERENCES "Players" ON DELETE CASCADE
);

CREATE TABLE "Tournament_Organizers"
(
  "tournamentId" integer NOT NULL,
  "userId" integer NOT NULL,
  "job" character varying,
  
  PRIMARY KEY ("tournamentId", "userId"),
  FOREIGN KEY ("tournamentId") REFERENCES "Tournaments" ON DELETE CASCADE,
  FOREIGN KEY ("userId") REFERENCES "Users" ON DELETE CASCADE
);

CREATE TABLE "Tournament_Stages"
(
  "tournamentId" integer NOT NULL,
  "stageId" integer NOT NULL,
  "stageStatus" integer NOT NULL DEFAULT 2,
  
  PRIMARY KEY ("tournamentId", "stageId"),
  FOREIGN KEY ("tournamentId") REFERENCES "Tournaments" ON DELETE CASCADE,
  FOREIGN KEY ("stageId") REFERENCES "Stages" ON DELETE CASCADE
);

CREATE TABLE "Tournament_Characters"
(
  "tournamentId" integer NOT NULL,
  "characterId" integer NOT NULL,
  "characterStatus" integer NOT NULL DEFAULT 2,
  
  PRIMARY KEY ("tournamentId", "characterId"),
  FOREIGN KEY ("tournamentId") REFERENCES "Tournaments" ON DELETE CASCADE,
  FOREIGN KEY ("characterId") REFERENCES "Characters" ON DELETE CASCADE
);

CREATE TABLE "Tournament_Items"
(
  "tournamentId" integer NOT NULL,
  "itemId" integer NOT NULL,
  "itemStatus" integer NOT NULL DEFAULT 0,
  
  PRIMARY KEY ("tournamentId", "itemId"),
  FOREIGN KEY ("tournamentId") REFERENCES "Tournaments" ON DELETE CASCADE,
  FOREIGN KEY ("itemId") REFERENCES "Items" ON DELETE CASCADE
);

CREATE TABLE "Matches"
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
  FOREIGN KEY ("tournamentId") REFERENCES "Tournaments",
  FOREIGN KEY ("roundId") REFERENCES "Rounds",
  FOREIGN KEY ("previousMatch") REFERENCES "Matches" ("matchId"),
  FOREIGN KEY ("nextMatch") REFERENCES "Matches" ("matchId"),
  FOREIGN KEY ("player1") REFERENCES "Players" ("playerId"),
  FOREIGN KEY ("player2") REFERENCES "Players" ("playerId"),
  FOREIGN KEY ("player3") REFERENCES "Players" ("playerId"),
  FOREIGN KEY ("player4") REFERENCES "Players" ("playerId"),
  FOREIGN KEY ("winner1") REFERENCES "Players" ("playerId"),
  FOREIGN KEY ("winner2") REFERENCES "Players" ("playerId")
);

CREATE TABLE "Games"
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
  FOREIGN KEY ("matchId") REFERENCES "Matches",
  FOREIGN KEY ("characterPlayer1") REFERENCES "Characters" ("characterId"),
  FOREIGN KEY ("characterPlayer2") REFERENCES "Characters" ("characterId"),
  FOREIGN KEY ("characterPlayer3") REFERENCES "Characters" ("characterId"),
  FOREIGN KEY ("characterPlayer4") REFERENCES "Characters" ("characterId"),
  FOREIGN KEY ("stagePicker1") REFERENCES "Characters" ("characterId"),
  FOREIGN KEY ("stagePicker2") REFERENCES "Characters" ("characterId"),
  FOREIGN KEY ("winner1") REFERENCES "Characters" ("characterId"),
  FOREIGN KEY ("winner2") REFERENCES "Characters" ("characterId")
);

CREATE TABLE "Striked_Stages"
(
  "gameId" integer NOT NULL,
  "stageId" integer NOT NULL,
  "playerId" integer NOT NULL,
  
  PRIMARY KEY ("gameId", "stageId"),
  FOREIGN KEY ("gameId") REFERENCES "Games",
  FOREIGN KEY ("stageId") REFERENCES "Stages",
  FOREIGN KEY ("playerId") REFERENCES "Players"
);

CREATE TABLE "Striked_Characters"
(
  "gameId" integer NOT NULL,
  "characterId" integer NOT NULL,
  "playerId" integer NOT NULL,
  
  PRIMARY KEY ("gameId", "characterId"),
  FOREIGN KEY ("gameId") REFERENCES "Games",
  FOREIGN KEY ("characterId") REFERENCES "Characters",
  FOREIGN KEY ("playerId") REFERENCES "Players"
);

CREATE TABLE "Striked_Items"
(
  "gameId" integer NOT NULL,
  "itemId" integer NOT NULL,
  "playerId" integer NOT NULL,
  
  PRIMARY KEY ("gameId", "itemId"),
  FOREIGN KEY ("gameId") REFERENCES "Games",
  FOREIGN KEY ("itemId") REFERENCES "Items",
  FOREIGN KEY ("playerId") REFERENCES "Players"
);

CREATE TABLE "GlickoData"
(
  "glickoId" serial NOT NULL ,
  "volatility" numeric NOT NULL DEFAULT 0.06,
  "RD" numeric NOT NULL DEFAULT 350,
  "rating" numeric NOT NULL DEFAULT 1500,
  "playerId" integer NOT NULL ,
  "teammateId" integer,
  
  PRIMARY KEY ("glickoId"),
  FOREIGN KEY ("playerId") REFERENCES "Players",
  FOREIGN KEY ("teammateId") REFERENCES "Players" ("playerId")
);

CREATE TABLE "CharacterGlickoData"
(
  "characterGlickoId" serial NOT NULL ,
  "volatility" numeric NOT NULL DEFAULT 0.06,
  "RD" numeric NOT NULL DEFAULT 350,
  "rating" numeric NOT NULL DEFAULT 1500,
  "characterId" integer NOT NULL ,
  "playerId" integer NOT NULL ,
  "teammateId" integer,
  "teammateCharacter" integer,
  
  PRIMARY KEY ("characterGlickoId"),
  FOREIGN KEY ("characterId") REFERENCES "Characters",
  FOREIGN KEY ("playerId") REFERENCES "Players",
  FOREIGN KEY ("teammateCharacter") REFERENCES "Characters" ("characterId"),
  FOREIGN KEY ("teammateId") REFERENCES "Players" ("playerId")
);

CREATE TABLE "StageGlickoData"
(
  "stageGlickoId" serial NOT NULL ,
  "volatility" numeric NOT NULL DEFAULT 0.06,
  "RD" numeric NOT NULL DEFAULT 350,
  "rating" numeric NOT NULL DEFAULT 1500,
  "stageId" integer NOT NULL ,
  "playerId" integer NOT NULL ,
  "teammateId" integer,
  
  PRIMARY KEY ("stageGlickoId"),
  FOREIGN KEY ("stageId") REFERENCES "Stages",
  FOREIGN KEY ("playerId") REFERENCES "Players",
  FOREIGN KEY ("teammateId") REFERENCES "Players" ("playerId")
);

CREATE TABLE "Game_Stats"
(
  "player1" integer NOT NULL,
  "player2" integer NOT NULL,
  "character1" integer NOT NULL,
  "character2" integer NOT NULL,
  "stageId" integer NOT NULL,
  "totalMatches" integer,
  "totalWins" integer,
  "winPercentage" integer,
  "averageStocks" numeric,
  "enemyStocks" numeric,
  "averagePercentage" numeric,
  "enemyPercentage" numeric,
  "averageTimer" interval,

  PRIMARY KEY ("player1", "player2", "character1", "character2", "stageId"),
  FOREIGN KEY ("player1") REFERENCES "Players" ("playerId"),
  FOREIGN KEY ("player2") REFERENCES "Players" ("playerId"),
  FOREIGN KEY ("character1") REFERENCES "Characters" ("characterId"),
  FOREIGN KEY ("character2") REFERENCES "Characters" ("characterId"),
  FOREIGN KEY ("stageId") REFERENCES "Stages"
);

CREATE TABLE "Stage_Stats"
(
  "stageId" integer NOT NULL,
  "playerId" integer NOT NULL,
  "characterId" integer NOT NULL,
  "totalMatches" integer,
  "totalOpportunities" integer,
  "opportunityPercentage" integer,
  "totalPicks" integer,
  "pickPercentage" integer,
  "totalStrikes" integer,
  "strikePercentage" integer,

  PRIMARY KEY ("playerId", "characterId", "stageId"),
  FOREIGN KEY ("playerId") REFERENCES "Players",
  FOREIGN KEY ("characterId") REFERENCES "Characters",
  FOREIGN KEY ("stageId") REFERENCES "Stages"
);

COMMIT;