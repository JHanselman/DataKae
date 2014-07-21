CREATE VIEW "CharacterVsWins" AS
SELECT "character1","character2",coalesce("leftwins"+"rightwins","leftwins","rightwins") AS "wins"
FROM
(SELECT "characterPlayer1" AS "character1","characterPlayer2" AS "character2", count(DISTINCT "gameId") as "leftwins" 
    FROM "Games"
    WHERE ("winner1"=1)
    GROUP BY "characterPlayer1","characterPlayer2") AS "leftSide"
FULL OUTER JOIN 
(SELECT "characterPlayer1" AS "character2","characterPlayer2" AS "character1", count(DISTINCT "gameId") as "rightwins"
    FROM "Games"
    WHERE ("winner1"=2)
    GROUP BY "character1","character2") AS "rightSide"
USING ("character1","character2");

CREATE VIEW "CharacterWinsLossesOnStage" AS
SELECT "character","stageId",coalesce("leftwins"+"rightwins","leftwins","rightwins") AS "wins",coalesce("leftlosses"+"rightlosses","leftlosses","rightlosses") AS "losses"
FROM
((SELECT "characterPlayer1" AS "character","stageId" , count(DISTINCT "gameId") as "leftwins" 
    FROM "Games"
    WHERE ("winner1"=1)
    GROUP BY "character","stageId") AS "leftSideW"
FULL OUTER JOIN 
(SELECT "characterPlayer2" AS "character","stageId", count(DISTINCT "gameId") as "rightwins"
    FROM "Games"
    WHERE ("winner1"=2)
    GROUP BY "character","stageId") AS "rightSideW"
USING ("character","stageId"))
FULL OUTER JOIN (
(SELECT "characterPlayer1" AS "character","stageId" , count(DISTINCT "gameId") as "leftlosses" 
    FROM "Games"
    WHERE ("winner1"=2)
    GROUP BY "character","stageId") AS "leftSideL"
FULL OUTER JOIN 
(SELECT "characterPlayer2" AS "character","stageId", count(DISTINCT "gameId") as "rightlosses"
    FROM "Games"
    WHERE ("winner1"=1)
    GROUP BY "character","stageId") AS "rightSideL"
USING ("character","stageId"))
USING ("character","stageId");

CREATE VIEW "CharacterUsage" AS
SELECT "player","characterName","games"
FROM
((SELECT "player","character",coalesce("leftgames"+"rightgames","leftgames","rightgames") AS "games"
FROM
(SELECT "Matches"."player1" AS "player","characterPlayer1" AS "character", count(DISTINCT "gameId") as "leftgames" 
    FROM ("Games" INNER JOIN "Matches" ON "Games"."matchId"="Matches"."matchId" )
    GROUP BY "player","character") AS "leftSide"
FULL OUTER JOIN 
(SELECT "Matches"."player2" AS "player","characterPlayer2" AS "character", count(DISTINCT "gameId") as "rightgames" 
    FROM ("Games" INNER JOIN "Matches" ON "Games"."matchId"="Matches"."matchId" )
    GROUP BY "player","character") AS "rightSide"
USING ("player","character")) AS "usage"
INNER JOIN (
SELECT "characterId","characterName"
FROM "Characters") AS "Char"
ON "usage"."character"="Char"."characterId");


CREATE VIEW "StageUsage" AS
SELECT "player","stageName","games"
FROM
((SELECT "player","stageId",coalesce("leftgames"+"rightgames","leftgames","rightgames") AS "games"
FROM
(SELECT "Matches"."player1" AS "player","stageId", count(DISTINCT "gameId") as "leftgames" 
	FROM ("Games" INNER JOIN "Matches" ON "Games"."matchId"="Matches"."matchId" )
	GROUP BY "player","stageId") AS "leftSide"
FULL OUTER JOIN 
(SELECT "Matches"."player2" AS "player","stageId", count(DISTINCT "gameId") as "rightgames" 
	FROM ("Games" INNER JOIN "Matches" ON "Games"."matchId"="Matches"."matchId" )
	GROUP BY "player","stageId") AS "rightSide"
USING ("player","stageId")) AS "usage"
INNER JOIN (
SELECT "stageId","stageName"
FROM "Stages") AS "Stag"
ON "usage"."stageId"="Stag"."stageId");

CREATE VIEW "PlayerVsCharacterLosses" AS
SELECT "player","characterName","losses"
FROM
((SELECT "player","character",coalesce("leftlosses"+"rightlosses","leftlosses","rightlosses") AS "losses"
FROM
(SELECT "Matches"."player1" AS "player","Games"."characterPlayer2" AS "character", count(DISTINCT "gameId") as "leftlosses" 
    FROM ("Games" INNER JOIN "Matches" ON "Games"."matchId"="Matches"."matchId" )
    WHERE ("Games"."winner1"=2)
    GROUP BY "player","character") AS "leftSide"
FULL OUTER JOIN 
(SELECT "Matches"."player2" AS "player","Games"."characterPlayer1" AS "character", count(DISTINCT "gameId") as "rightlosses"
    FROM ("Games" INNER JOIN "Matches" ON "Games"."matchId"="Matches"."matchId" )
    WHERE ("Games"."winner1"=1)
    GROUP BY "player","character") AS "rightSide"
USING ("player","character")) AS "usage"
INNER JOIN (
SELECT "characterId","characterName"
FROM "Characters") AS "Char"
ON "usage"."character"="Char"."characterId");