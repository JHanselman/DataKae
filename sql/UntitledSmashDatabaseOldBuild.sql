BEGIN TRANSACTION;

CREATE TABLE "Regions"
(
  "regionId" serial NOT NULL,
  "regionName" character varying NOT NULL,
  "regionCode" character varying(4) NOT NULL,
  
  PRIMARY KEY ("regionId"),
  UNIQUE ("regionCode"),
  UNIQUE ("regionName")
);

CREATE TABLE "Rulesets"
(
  "rulesetId" serial NOT NULL,
  "items" boolean NOT NULL,
  "stock" smallint NOT NULL,
  "time" smallint NOT NULL,
  "rules" text NOT NULL,
  
  PRIMARY KEY ("rulesetId")
);

CREATE TABLE "Users"
(
    
  "userId" serial NOT NULL,
  "userName" character varying(30) NOT NULL,
  "friendCode" character(12) NOT NULL,
  "regionId" serial NOT NULL,
  "emailAddress" character varying(40) NOT NULL,
  "passwordHash" character varying(100) NOT NULL,
  "role" integer NOT NULL DEFAULT 0,
  "Ranked" boolean NOT NULL DEFAULT false,
  
  PRIMARY KEY ("userId"),
  FOREIGN KEY ("regionId") REFERENCES "Regions",
  UNIQUE ("friendCode"),
  UNIQUE ("emailAddress"),
  UNIQUE ("userName")
);

CREATE TABLE "Characters"
(
  "characterId" serial NOT NULL,
  "characterName" character varying(20) NOT NULL,
  
  PRIMARY KEY ("characterId"),
  UNIQUE ("characterName")
);

CREATE TABLE "Matches"
(
  "matchId" serial NOT NULL,
  "date" timestamp without time zone NOT NULL,
  "type" character varying(5)[] NOT NULL,
  "rulesetId" serial NOT NULL,
  
  PRIMARY KEY ("matchId"),
  FOREIGN KEY ("rulesetId") REFERENCES "Rulesets" 
);

CREATE TABLE "Stages"
(
  "stageId" serial NOT NULL,
  "stageName" character varying(30) NOT NULL,
  
  PRIMARY KEY ("stageId")
);

CREATE TABLE "Sets"
(
  "setId" serial NOT NULL,
  "matchId" serial NOT NULL,
  "stageId" serial NOT NULL,
  
  PRIMARY KEY ("setId"),
  FOREIGN KEY ("matchId") REFERENCES "Matches",
  FOREIGN KEY ("stageId") REFERENCES "Stages"
);

CREATE TABLE "PlayerSetParticipation"
(
  "userId" integer NOT NULL,
  "setId" integer NOT NULL,
  "characterId" integer NOT NULL,
  "placing" smallint NOT NULL,
  
  PRIMARY KEY ("userId", "setId"),
  FOREIGN KEY ("characterId") REFERENCES "Characters",
  FOREIGN KEY ("userId") REFERENCES "Users",
  FOREIGN KEY ("setId") REFERENCES "Sets"
);

CREATE TABLE "GlickoData"
(
  "glickoId" serial NOT NULL ,
  "volatility" numeric NOT NULL DEFAULT 0.06,
  "RD" numeric NOT NULL DEFAULT 350,
  "rating" numeric NOT NULL DEFAULT 1500,
  "userId" serial NOT NULL ,
  "matchType" character varying(5) NOT NULL,
  
  PRIMARY KEY ("glickoId"),
  FOREIGN KEY ("userId") REFERENCES "Users"
);

CREATE TABLE "CharacterGlickoData"
(
  "characterGlickoId" serial NOT NULL ,
  "volatility" numeric NOT NULL DEFAULT 0.06,
  "RD" numeric NOT NULL DEFAULT 350,
  "rating" numeric NOT NULL DEFAULT 1500,
  "characterId" serial NOT NULL ,
  "userId" serial NOT NULL ,
  "matchType" character varying(5) NOT NULL,
  
  PRIMARY KEY ("characterGlickoId"),
  FOREIGN KEY ("characterId") REFERENCES "Characters",
  FOREIGN KEY ("userId") REFERENCES "Users"
);


CREATE TABLE "TourneyMatch"
(
  "matchId" serial NOT NULL,
  parent serial NOT NULL,
  "leftMatch" serial NOT NULL,
  "rightMatch" serial NOT NULL,
  "loserMatch" serial NOT NULL,
  "tourneyId" serial NOT NULL,
  "TMId" serial NOT NULL,
  PRIMARY KEY ("TMId"),
  FOREIGN KEY ("leftMatch") REFERENCES "TourneyMatch" ("TMId"),
  FOREIGN KEY ("loserMatch") REFERENCES "TourneyMatch" ("TMId"),
  FOREIGN KEY ("matchId") REFERENCES "Matches" ("matchId"),
  FOREIGN KEY (parent) REFERENCES "TourneyMatch" ("TMId"),
  FOREIGN KEY ("rightMatch") REFERENCES "TourneyMatch" ("TMId")
);

CREATE TABLE "Tournament"
(
  "tourneyId" serial NOT NULL,
  "type" character varying(3),
  "root" serial NOT NULL,
  "owner" serial NOT NULL,
  
  PRIMARY KEY ("tourneyId"),
  
  FOREIGN KEY (owner) REFERENCES "Users" ("userId"),
  FOREIGN KEY (root) REFERENCES "TourneyMatch" ("TMId")
);

ALTER TABLE "TourneyMatch" ADD FOREIGN KEY ("tourneyId") REFERENCES "Tournament" ("tourneyId");


COMMIT;