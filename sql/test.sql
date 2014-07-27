--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

--
-- Name: upd_createtime(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION upd_createtime() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW."create_time" = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.upd_createtime() OWNER TO postgres;

--
-- Name: upd_lastvisit(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION upd_lastvisit() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW."last_visit" = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.upd_lastvisit() OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: 3DS_Games; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "3DS_Games" (
    "gameId" integer NOT NULL,
    "matchId" integer NOT NULL,
    "gameNumber" integer NOT NULL,
    "characterPlayer1" integer NOT NULL,
    "characterPlayer2" integer NOT NULL,
    "characterPlayer3" integer,
    "characterPlayer4" integer,
    "stageId" character varying NOT NULL,
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
    winner1 integer NOT NULL,
    winner2 integer,
    link character varying,
    comments character varying
);


ALTER TABLE public."3DS_Games" OWNER TO postgres;

--
-- Name: 3DS_Games_gameId_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "3DS_Games_gameId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."3DS_Games_gameId_seq" OWNER TO postgres;

--
-- Name: 3DS_Games_gameId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "3DS_Games_gameId_seq" OWNED BY "3DS_Games"."gameId";


--
-- Name: 3DS_Items; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "3DS_Items" (
    "itemId" integer NOT NULL,
    "itemName" character varying NOT NULL
);


ALTER TABLE public."3DS_Items" OWNER TO postgres;

--
-- Name: 3DS_Items_itemId_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "3DS_Items_itemId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."3DS_Items_itemId_seq" OWNER TO postgres;

--
-- Name: 3DS_Items_itemId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "3DS_Items_itemId_seq" OWNED BY "3DS_Items"."itemId";


--
-- Name: 3DS_Matches; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "3DS_Matches" (
    "matchId" integer NOT NULL,
    "tournamentId" integer NOT NULL,
    "roundId" integer,
    "previousMatch" integer,
    "nextMatch" integer,
    player1 integer NOT NULL,
    player2 integer NOT NULL,
    player3 integer,
    player4 integer,
    winner1 integer NOT NULL,
    winner2 integer,
    comments character varying,
    "gamesNr" integer,
    "createdOn" timestamp without time zone,
    "createdBy" character varying(30),
    "changedOn" timestamp without time zone,
    "changedBy" character varying(30)
);


ALTER TABLE public."3DS_Matches" OWNER TO postgres;

--
-- Name: 3DS_Matches_matchId_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "3DS_Matches_matchId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."3DS_Matches_matchId_seq" OWNER TO postgres;

--
-- Name: 3DS_Matches_matchId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "3DS_Matches_matchId_seq" OWNED BY "3DS_Matches"."matchId";


--
-- Name: 3DS_Organization; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "3DS_Organization" (
    "organizationId" integer NOT NULL,
    "tournamentId" integer NOT NULL,
    "organizationNumber" integer,
    "roundStyle" character varying DEFAULT 'Double-Elimination'::character varying,
    "numberEntrants" integer,
    "numberStations" integer,
    duration interval
);


ALTER TABLE public."3DS_Organization" OWNER TO postgres;

--
-- Name: 3DS_Organization_organizationId_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "3DS_Organization_organizationId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."3DS_Organization_organizationId_seq" OWNER TO postgres;

--
-- Name: 3DS_Organization_organizationId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "3DS_Organization_organizationId_seq" OWNED BY "3DS_Organization"."organizationId";


--
-- Name: 3DS_Rounds; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "3DS_Rounds" (
    "roundId" integer NOT NULL,
    "organizationId" integer NOT NULL,
    "roundNumber" integer NOT NULL,
    "numberEntrants" integer NOT NULL,
    duration interval
);


ALTER TABLE public."3DS_Rounds" OWNER TO postgres;

--
-- Name: 3DS_Rounds_roundId_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "3DS_Rounds_roundId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."3DS_Rounds_roundId_seq" OWNER TO postgres;

--
-- Name: 3DS_Rounds_roundId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "3DS_Rounds_roundId_seq" OWNED BY "3DS_Rounds"."roundId";


--
-- Name: 3DS_Stages; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "3DS_Stages" (
    "stageId" integer NOT NULL,
    "stageName" character varying NOT NULL
);


ALTER TABLE public."3DS_Stages" OWNER TO postgres;

--
-- Name: 3DS_Stages_stageId_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "3DS_Stages_stageId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."3DS_Stages_stageId_seq" OWNER TO postgres;

--
-- Name: 3DS_Stages_stageId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "3DS_Stages_stageId_seq" OWNED BY "3DS_Stages"."stageId";


--
-- Name: 3DS_Tournament_Characters; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "3DS_Tournament_Characters" (
    "tournamentId" integer NOT NULL,
    "characterId" integer NOT NULL,
    "characterStatus" integer DEFAULT 2 NOT NULL
);


ALTER TABLE public."3DS_Tournament_Characters" OWNER TO postgres;

--
-- Name: 3DS_Tournament_Items; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "3DS_Tournament_Items" (
    "tournamentId" integer NOT NULL,
    "itemId" integer NOT NULL,
    "itemStatus" integer DEFAULT 0 NOT NULL
);


ALTER TABLE public."3DS_Tournament_Items" OWNER TO postgres;

--
-- Name: 3DS_Tournament_Organizers; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "3DS_Tournament_Organizers" (
    "tournamentId" integer NOT NULL,
    "userId" integer NOT NULL,
    job character varying
);


ALTER TABLE public."3DS_Tournament_Organizers" OWNER TO postgres;

--
-- Name: 3DS_Tournament_Players; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "3DS_Tournament_Players" (
    "tournamentId" integer NOT NULL,
    "playerId" integer NOT NULL,
    "placing" character varying
);


ALTER TABLE public."3DS_Tournament_Players" OWNER TO postgres;

--
-- Name: 3DS_Tournament_Stages; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "3DS_Tournament_Stages" (
    "tournamentId" integer NOT NULL,
    "stageId" integer NOT NULL,
    "stageStatus" integer DEFAULT 2 NOT NULL
);


ALTER TABLE public."3DS_Tournament_Stages" OWNER TO postgres;

--
-- Name: 3DS_Tournaments; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "3DS_Tournaments" (
    "tournamentId" integer NOT NULL,
    "tournamentName" character varying NOT NULL,
    "locationId" integer NOT NULL,
    "startDate" date NOT NULL,
    "endDate" date,
    "rulesetId" integer,
    "financesId" integer,
    "totalEntrants" integer,
    "totalDuration" interval,
    "createdOn" timestamp without time zone,
    "changedOn" timestamp without time zone
);


ALTER TABLE public."3DS_Tournaments" OWNER TO postgres;

--
-- Name: 3DS_Tournaments_tournamentId_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "3DS_Tournaments_tournamentId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."3DS_Tournaments_tournamentId_seq" OWNER TO postgres;

--
-- Name: 3DS_Tournaments_tournamentId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "3DS_Tournaments_tournamentId_seq" OWNED BY "3DS_Tournaments"."tournamentId";


--
-- Name: AuthAssignment; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "AuthAssignment" (
    itemname character varying(64) NOT NULL,
    userid character varying(64) NOT NULL,
    bizrule text,
    data text
);


ALTER TABLE public."AuthAssignment" OWNER TO postgres;

--
-- Name: AuthItem; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "AuthItem" (
    name character varying(64) NOT NULL,
    type integer NOT NULL,
    description text,
    bizrule text,
    data text
);


ALTER TABLE public."AuthItem" OWNER TO postgres;

--
-- Name: AuthItemChild; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "AuthItemChild" (
    parent character varying(64) NOT NULL,
    child character varying(64) NOT NULL
);


ALTER TABLE public."AuthItemChild" OWNER TO postgres;

--
-- Name: CharacterGlickoData; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "CharacterGlickoData" (
    "characterGlickoId" integer NOT NULL,
    volatility numeric DEFAULT 0.06 NOT NULL,
    "RD" numeric DEFAULT 350 NOT NULL,
    rating numeric DEFAULT 1500 NOT NULL,
    "characterId" integer NOT NULL,
    "playerId" integer NOT NULL,
    "teammateId" integer,
    "teammateCharacter" integer
);


ALTER TABLE public."CharacterGlickoData" OWNER TO postgres;

--
-- Name: CharacterGlickoData_characterGlickoId_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "CharacterGlickoData_characterGlickoId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."CharacterGlickoData_characterGlickoId_seq" OWNER TO postgres;

--
-- Name: CharacterGlickoData_characterGlickoId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "CharacterGlickoData_characterGlickoId_seq" OWNED BY "CharacterGlickoData"."characterGlickoId";


--
-- Name: Characters; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "Characters" (
    "characterId" integer NOT NULL,
    "characterName" character varying NOT NULL
);


ALTER TABLE public."Characters" OWNER TO postgres;

--
-- Name: WiiU_Games; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "WiiU_Games" (
    "gameId" integer NOT NULL,
    "matchId" integer NOT NULL,
    "gameNumber" integer NOT NULL,
    "characterPlayer1" integer NOT NULL,
    "characterPlayer2" integer NOT NULL,
    "characterPlayer3" integer,
    "characterPlayer4" integer,
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
    winner1 integer NOT NULL,
    winner2 integer,
    link character varying,
    comments character varying,
    "stageId" integer NOT NULL
);


ALTER TABLE public."WiiU_Games" OWNER TO postgres;

--
-- Name: WiiU_Matches; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "WiiU_Matches" (
    "matchId" integer NOT NULL,
    "tournamentId" integer NOT NULL,
    "roundId" integer,
    "previousMatch" integer,
    "nextMatch" integer,
    player1 integer NOT NULL,
    player2 integer NOT NULL,
    player3 integer,
    player4 integer,
    winner1 integer NOT NULL,
    winner2 integer,
    comments character varying,
    "gamesNr" integer,
    "createdOn" timestamp without time zone,
    "createdBy" character varying(30),
    "changedOn" timestamp without time zone,
    "changedBy" character varying(30)
);


ALTER TABLE public."WiiU_Matches" OWNER TO postgres;

--
-- Name: CharacterUsage; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW "CharacterUsage" AS
    SELECT usage.player, "Char"."characterName", usage.games FROM ((SELECT player, "character", COALESCE(("leftSide".leftgames + "rightSide".rightgames), "leftSide".leftgames, "rightSide".rightgames) AS games FROM ((SELECT "Matches".player1 AS player, "Games"."characterPlayer1" AS "character", count(DISTINCT "Games"."gameId") AS leftgames FROM ("WiiU_Games" "Games" JOIN "WiiU_Matches" "Matches" ON (("Games"."matchId" = "Matches"."matchId"))) GROUP BY "Matches".player1, "Games"."characterPlayer1") "leftSide" FULL JOIN (SELECT "Matches".player2 AS player, "Games"."characterPlayer2" AS "character", count(DISTINCT "Games"."gameId") AS rightgames FROM ("WiiU_Games" "Games" JOIN "WiiU_Matches" "Matches" ON (("Games"."matchId" = "Matches"."matchId"))) GROUP BY "Matches".player2, "Games"."characterPlayer2") "rightSide" USING (player, "character"))) usage JOIN (SELECT "Characters"."characterId", "Characters"."characterName" FROM "Characters") "Char" ON ((usage."character" = "Char"."characterId")));


ALTER TABLE public."CharacterUsage" OWNER TO postgres;

--
-- Name: CharacterVsWins; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW "CharacterVsWins" AS
    SELECT character1, character2, COALESCE(("leftSide".leftwins + "rightSide".rightwins), "leftSide".leftwins, "rightSide".rightwins) AS wins FROM ((SELECT "Games"."characterPlayer1" AS character1, "Games"."characterPlayer2" AS character2, count(DISTINCT "Games"."gameId") AS leftwins FROM "WiiU_Games" "Games" WHERE ("Games".winner1 = 1) GROUP BY "Games"."characterPlayer1", "Games"."characterPlayer2") "leftSide" FULL JOIN (SELECT "Games"."characterPlayer1" AS character2, "Games"."characterPlayer2" AS character1, count(DISTINCT "Games"."gameId") AS rightwins FROM "WiiU_Games" "Games" WHERE ("Games".winner1 = 2) GROUP BY "Games"."characterPlayer2", "Games"."characterPlayer1") "rightSide" USING (character1, character2));


ALTER TABLE public."CharacterVsWins" OWNER TO postgres;

--
-- Name: CharacterWinsLossesOnStage; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW "CharacterWinsLossesOnStage" AS
    SELECT "character", "stageId", COALESCE(("leftSideW".leftwins + "rightSideW".rightwins), "leftSideW".leftwins, "rightSideW".rightwins) AS wins, COALESCE(("leftSideL".leftlosses + "rightSideL".rightlosses), "leftSideL".leftlosses, "rightSideL".rightlosses) AS losses FROM (((SELECT "Games"."characterPlayer1" AS "character", "Games"."stageId", count(DISTINCT "Games"."gameId") AS leftwins FROM "WiiU_Games" "Games" WHERE ("Games".winner1 = 1) GROUP BY "Games"."characterPlayer1", "Games"."stageId") "leftSideW" FULL JOIN (SELECT "Games"."characterPlayer2" AS "character", "Games"."stageId", count(DISTINCT "Games"."gameId") AS rightwins FROM "WiiU_Games" "Games" WHERE ("Games".winner1 = 2) GROUP BY "Games"."characterPlayer2", "Games"."stageId") "rightSideW" USING ("character", "stageId")) FULL JOIN ((SELECT "Games"."characterPlayer1" AS "character", "Games"."stageId", count(DISTINCT "Games"."gameId") AS leftlosses FROM "WiiU_Games" "Games" WHERE ("Games".winner1 = 2) GROUP BY "Games"."characterPlayer1", "Games"."stageId") "leftSideL" FULL JOIN (SELECT "Games"."characterPlayer2" AS "character", "Games"."stageId", count(DISTINCT "Games"."gameId") AS rightlosses FROM "WiiU_Games" "Games" WHERE ("Games".winner1 = 1) GROUP BY "Games"."characterPlayer2", "Games"."stageId") "rightSideL" USING ("character", "stageId")) USING ("character", "stageId"));


ALTER TABLE public."CharacterWinsLossesOnStage" OWNER TO postgres;

--
-- Name: Characters_characterId_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Characters_characterId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Characters_characterId_seq" OWNER TO postgres;

--
-- Name: Characters_characterId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Characters_characterId_seq" OWNED BY "Characters"."characterId";


--
-- Name: Finances; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "Finances" (
    "financesId" integer NOT NULL,
    "entryFee" double precision NOT NULL,
    "grossMoney" double precision,
    "houseCut" double precision,
    "distributionModel" character varying,
    "averageExpenses" double precision,
    "firstPlaceWinnings" double precision,
    "secondPlaceWinnings" double precision,
    "thirdPlaceWinnings" double precision,
    "fourthPlaceWinnings" double precision,
    "fifthPlaceWinnings" double precision,
    "sixthPlaceWinnings" double precision,
    "seventhPlaceWinnings" double precision,
    "eigthPlaceWinnings" double precision,
    "netGain" double precision
);


ALTER TABLE public."Finances" OWNER TO postgres;

--
-- Name: Finances_financesId_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Finances_financesId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Finances_financesId_seq" OWNER TO postgres;

--
-- Name: Finances_financesId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Finances_financesId_seq" OWNED BY "Finances"."financesId";


--
-- Name: Games_gameId_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Games_gameId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Games_gameId_seq" OWNER TO postgres;

--
-- Name: Games_gameId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Games_gameId_seq" OWNED BY "WiiU_Games"."gameId";


--
-- Name: GlickoData; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "GlickoData" (
    "glickoId" integer NOT NULL,
    volatility numeric DEFAULT 0.06 NOT NULL,
    "RD" numeric DEFAULT 350 NOT NULL,
    rating numeric DEFAULT 1500 NOT NULL,
    "playerId" integer NOT NULL,
    "teammateId" integer
);


ALTER TABLE public."GlickoData" OWNER TO postgres;

--
-- Name: GlickoData_glickoId_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "GlickoData_glickoId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."GlickoData_glickoId_seq" OWNER TO postgres;

--
-- Name: GlickoData_glickoId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "GlickoData_glickoId_seq" OWNED BY "GlickoData"."glickoId";


--
-- Name: WiiU_Items; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "WiiU_Items" (
    "itemId" integer NOT NULL,
    "itemName" character varying NOT NULL
);


ALTER TABLE public."WiiU_Items" OWNER TO postgres;

--
-- Name: Items_itemId_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Items_itemId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Items_itemId_seq" OWNER TO postgres;

--
-- Name: Items_itemId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Items_itemId_seq" OWNED BY "WiiU_Items"."itemId";


--
-- Name: Location; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "Location" (
    "locationId" integer NOT NULL,
    "locationName" character varying NOT NULL,
    "locationCode" character varying(10) NOT NULL,
    "regionName" character varying NOT NULL,
    "regionCode" character varying(4) NOT NULL
);


ALTER TABLE public."Location" OWNER TO postgres;

--
-- Name: Location_locationId_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Location_locationId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Location_locationId_seq" OWNER TO postgres;

--
-- Name: Location_locationId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Location_locationId_seq" OWNED BY "Location"."locationId";


--
-- Name: Matches_matchId_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Matches_matchId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Matches_matchId_seq" OWNER TO postgres;

--
-- Name: Matches_matchId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Matches_matchId_seq" OWNED BY "WiiU_Matches"."matchId";


--
-- Name: WiiU_Organization; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "WiiU_Organization" (
    "organizationId" integer NOT NULL,
    "tournamentId" integer NOT NULL,
    "organizationNumber" integer,
    "roundStyle" character varying DEFAULT 'Double-Elimination'::character varying,
    "numberEntrants" integer,
    "numberStations" integer,
    duration interval
);


ALTER TABLE public."WiiU_Organization" OWNER TO postgres;

--
-- Name: Organization_organizationId_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Organization_organizationId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Organization_organizationId_seq" OWNER TO postgres;

--
-- Name: Organization_organizationId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Organization_organizationId_seq" OWNED BY "WiiU_Organization"."organizationId";


--
-- Name: PlayerVsCharacterLosses; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW "PlayerVsCharacterLosses" AS
    SELECT usage.player, "Char"."characterName", usage.losses FROM ((SELECT player, "character", COALESCE(("leftSide".leftlosses + "rightSide".rightlosses), "leftSide".leftlosses, "rightSide".rightlosses) AS losses FROM ((SELECT "Matches".player1 AS player, "Games"."characterPlayer2" AS "character", count(DISTINCT "Games"."gameId") AS leftlosses FROM ("WiiU_Games" "Games" JOIN "WiiU_Matches" "Matches" ON (("Games"."matchId" = "Matches"."matchId"))) WHERE ("Games".winner1 = 2) GROUP BY "Matches".player1, "Games"."characterPlayer2") "leftSide" FULL JOIN (SELECT "Matches".player2 AS player, "Games"."characterPlayer1" AS "character", count(DISTINCT "Games"."gameId") AS rightlosses FROM ("WiiU_Games" "Games" JOIN "WiiU_Matches" "Matches" ON (("Games"."matchId" = "Matches"."matchId"))) WHERE ("Games".winner1 = 1) GROUP BY "Matches".player2, "Games"."characterPlayer1") "rightSide" USING (player, "character"))) usage JOIN (SELECT "Characters"."characterId", "Characters"."characterName" FROM "Characters") "Char" ON ((usage."character" = "Char"."characterId")));


ALTER TABLE public."PlayerVsCharacterLosses" OWNER TO postgres;

--
-- Name: Players; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "Players" (
    "playerId" integer NOT NULL,
    "playerName" character varying(50) NOT NULL,
    "playerLastName" character varying(50) NOT NULL,
    "playerNickname" character varying(50) NOT NULL,
    "locationId" integer NOT NULL
);


ALTER TABLE public."Players" OWNER TO postgres;

--
-- Name: Players_locationId_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Players_locationId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Players_locationId_seq" OWNER TO postgres;

--
-- Name: Players_locationId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Players_locationId_seq" OWNED BY "Players"."locationId";


--
-- Name: Players_playerId_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Players_playerId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Players_playerId_seq" OWNER TO postgres;

--
-- Name: Players_playerId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Players_playerId_seq" OWNED BY "Players"."playerId";


--
-- Name: WiiU_Rounds; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "WiiU_Rounds" (
    "roundId" integer NOT NULL,
    "organizationId" integer NOT NULL,
    "roundNumber" integer NOT NULL,
    "numberEntrants" integer NOT NULL,
    duration interval
);


ALTER TABLE public."WiiU_Rounds" OWNER TO postgres;

--
-- Name: Rounds_roundId_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Rounds_roundId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Rounds_roundId_seq" OWNER TO postgres;

--
-- Name: Rounds_roundId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Rounds_roundId_seq" OWNED BY "WiiU_Rounds"."roundId";


--
-- Name: Rulesets; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "Rulesets" (
    "rulesetId" integer NOT NULL,
    "rulesetName" character varying NOT NULL,
    "matchType" character varying DEFAULT '1v1'::character varying NOT NULL,
    "matchMode" character varying DEFAULT 'Stocks'::character varying NOT NULL,
    "numberStocks" integer DEFAULT 4 NOT NULL,
    "numberTimer" interval DEFAULT '00:08:00'::interval NOT NULL,
    "itemRate" character varying DEFAULT 'None'::character varying NOT NULL,
    "specialRules" character varying
);


ALTER TABLE public."Rulesets" OWNER TO postgres;

--
-- Name: Rulesets_rulesetId_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Rulesets_rulesetId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Rulesets_rulesetId_seq" OWNER TO postgres;

--
-- Name: Rulesets_rulesetId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Rulesets_rulesetId_seq" OWNED BY "Rulesets"."rulesetId";


--
-- Name: StageGlickoData; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "StageGlickoData" (
    "stageGlickoId" integer NOT NULL,
    volatility numeric DEFAULT 0.06 NOT NULL,
    "RD" numeric DEFAULT 350 NOT NULL,
    rating numeric DEFAULT 1500 NOT NULL,
    "stageId" integer NOT NULL,
    "playerId" integer NOT NULL,
    "teammateId" integer
);


ALTER TABLE public."StageGlickoData" OWNER TO postgres;

--
-- Name: StageGlickoData_stageGlickoId_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "StageGlickoData_stageGlickoId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."StageGlickoData_stageGlickoId_seq" OWNER TO postgres;

--
-- Name: StageGlickoData_stageGlickoId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "StageGlickoData_stageGlickoId_seq" OWNED BY "StageGlickoData"."stageGlickoId";


--
-- Name: WiiU_Stages; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "WiiU_Stages" (
    "stageId" integer NOT NULL,
    "stageName" character varying NOT NULL
);


ALTER TABLE public."WiiU_Stages" OWNER TO postgres;

--
-- Name: StageUsage; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW "StageUsage" AS
    SELECT usage.player, "Stag"."stageName", usage.games FROM ((SELECT player, "stageId", COALESCE(("leftSide".leftgames + "rightSide".rightgames), "leftSide".leftgames, "rightSide".rightgames) AS games FROM ((SELECT "Matches".player1 AS player, "Games"."stageId", count(DISTINCT "Games"."gameId") AS leftgames FROM ("WiiU_Games" "Games" JOIN "WiiU_Matches" "Matches" ON (("Games"."matchId" = "Matches"."matchId"))) GROUP BY "Matches".player1, "Games"."stageId") "leftSide" FULL JOIN (SELECT "Matches".player2 AS player, "Games"."stageId", count(DISTINCT "Games"."gameId") AS rightgames FROM ("WiiU_Games" "Games" JOIN "WiiU_Matches" "Matches" ON (("Games"."matchId" = "Matches"."matchId"))) GROUP BY "Matches".player2, "Games"."stageId") "rightSide" USING (player, "stageId"))) usage JOIN (SELECT "Stages"."stageId", "Stages"."stageName" FROM "WiiU_Stages" "Stages") "Stag" ON ((usage."stageId" = "Stag"."stageId")));


ALTER TABLE public."StageUsage" OWNER TO postgres;

--
-- Name: Stages_stageId_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Stages_stageId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Stages_stageId_seq" OWNER TO postgres;

--
-- Name: Stages_stageId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Stages_stageId_seq" OWNED BY "WiiU_Stages"."stageId";


--
-- Name: WiiU_Tournaments; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "WiiU_Tournaments" (
    "tournamentId" integer NOT NULL,
    "tournamentName" character varying NOT NULL,
    "locationId" integer NOT NULL,
    "startDate" date NOT NULL,
    "endDate" date,
    "rulesetId" integer,
    "financesId" integer,
    "totalEntrants" integer,
    "totalDuration" interval,
    "createdOn" timestamp without time zone,
    "changedOn" timestamp without time zone
);


ALTER TABLE public."WiiU_Tournaments" OWNER TO postgres;

--
-- Name: Tournaments_tournamentId_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Tournaments_tournamentId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Tournaments_tournamentId_seq" OWNER TO postgres;

--
-- Name: Tournaments_tournamentId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Tournaments_tournamentId_seq" OWNED BY "WiiU_Tournaments"."tournamentId";


--
-- Name: Users; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "Users" (
    "userId" integer NOT NULL,
    "playerId" integer,
    "userName" character varying(30) NOT NULL,
    "emailAddress" character varying(255) NOT NULL,
    "passwordHash" character varying(100) NOT NULL,
    role integer DEFAULT 0 NOT NULL
);


ALTER TABLE public."Users" OWNER TO postgres;

--
-- Name: Users_userId_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Users_userId_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Users_userId_seq" OWNER TO postgres;

--
-- Name: Users_userId_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Users_userId_seq" OWNED BY "Users"."userId";


--
-- Name: WiiU_Tournament_Characters; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "WiiU_Tournament_Characters" (
    "tournamentId" integer NOT NULL,
    "characterId" integer NOT NULL,
    "characterStatus" integer DEFAULT 2 NOT NULL
);


ALTER TABLE public."WiiU_Tournament_Characters" OWNER TO postgres;

--
-- Name: WiiU_Tournament_Items; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "WiiU_Tournament_Items" (
    "tournamentId" integer NOT NULL,
    "itemId" integer NOT NULL,
    "itemStatus" integer DEFAULT 0 NOT NULL
);


ALTER TABLE public."WiiU_Tournament_Items" OWNER TO postgres;

--
-- Name: WiiU_Tournament_Organizers; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "WiiU_Tournament_Organizers" (
    "tournamentId" integer NOT NULL,
    "userId" integer NOT NULL,
    job character varying
);


ALTER TABLE public."WiiU_Tournament_Organizers" OWNER TO postgres;

--
-- Name: WiiU_Tournament_Players; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "WiiU_Tournament_Players" (
    "tournamentId" integer NOT NULL,
    "playerId" integer NOT NULL,
    "placing" character varying
);


ALTER TABLE public."WiiU_Tournament_Players" OWNER TO postgres;

--
-- Name: WiiU_Tournament_Stages; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "WiiU_Tournament_Stages" (
    "tournamentId" integer NOT NULL,
    "stageId" integer NOT NULL,
    "stageStatus" integer DEFAULT 2 NOT NULL
);


ALTER TABLE public."WiiU_Tournament_Stages" OWNER TO postgres;

--
-- Name: bbii_choice; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE bbii_choice (
    id integer NOT NULL,
    choice character varying(200) NOT NULL,
    poll_id bigint NOT NULL,
    sort smallint DEFAULT 0::smallint NOT NULL,
    votes bigint DEFAULT 0::bigint NOT NULL
);


ALTER TABLE public.bbii_choice OWNER TO postgres;

--
-- Name: bbii_choice_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE bbii_choice_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.bbii_choice_id_seq OWNER TO postgres;

--
-- Name: bbii_choice_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE bbii_choice_id_seq OWNED BY bbii_choice.id;


--
-- Name: bbii_forum; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE bbii_forum (
    id integer NOT NULL,
    cat_id bigint,
    name character varying(255) NOT NULL,
    subtitle character varying(255) DEFAULT NULL::character varying,
    type smallint DEFAULT 0::smallint NOT NULL,
    public smallint DEFAULT 1::smallint NOT NULL,
    locked smallint DEFAULT 0::smallint NOT NULL,
    moderated smallint DEFAULT 0::smallint NOT NULL,
    sort smallint DEFAULT 0::smallint NOT NULL,
    num_posts bigint DEFAULT 0::bigint NOT NULL,
    num_topics bigint DEFAULT 0::bigint NOT NULL,
    last_post_id bigint,
    poll smallint DEFAULT 0::smallint NOT NULL,
    membergroup_id bigint DEFAULT 0::bigint
);


ALTER TABLE public.bbii_forum OWNER TO postgres;

--
-- Name: bbii_forum_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE bbii_forum_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.bbii_forum_id_seq OWNER TO postgres;

--
-- Name: bbii_forum_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE bbii_forum_id_seq OWNED BY bbii_forum.id;


--
-- Name: bbii_ipaddress; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE bbii_ipaddress (
    id integer NOT NULL,
    ip character varying(39) DEFAULT NULL::character varying,
    address character varying(255) DEFAULT NULL::character varying,
    source smallint DEFAULT 0::smallint,
    count bigint DEFAULT 0::bigint,
    create_time timestamp without time zone,
    update_time timestamp without time zone
);


ALTER TABLE public.bbii_ipaddress OWNER TO postgres;

--
-- Name: bbii_ipaddress_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE bbii_ipaddress_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.bbii_ipaddress_id_seq OWNER TO postgres;

--
-- Name: bbii_ipaddress_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE bbii_ipaddress_id_seq OWNED BY bbii_ipaddress.id;


--
-- Name: bbii_log_topic; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE bbii_log_topic (
    member_id bigint NOT NULL,
    topic_id bigint NOT NULL,
    forum_id bigint NOT NULL,
    last_post_id bigint NOT NULL
);


ALTER TABLE public.bbii_log_topic OWNER TO postgres;

--
-- Name: bbii_member; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE bbii_member (
    id bigint NOT NULL,
    member_name character varying(45) DEFAULT NULL::character varying,
    gender smallint,
    birthdate date,
    location character varying(255) DEFAULT NULL::character varying,
    personal_text character varying(255) DEFAULT NULL::character varying,
    signature text,
    avatar character varying(255) DEFAULT NULL::character varying,
    show_online smallint DEFAULT 1::smallint,
    contact_email smallint DEFAULT 0::smallint,
    contact_pm smallint DEFAULT 1::smallint,
    timezone character varying(80) DEFAULT NULL::character varying,
    first_visit timestamp without time zone,
    last_visit timestamp without time zone,
    warning smallint DEFAULT 0::smallint,
    posts bigint DEFAULT 0::bigint,
    group_id smallint DEFAULT 0::smallint,
    upvoted smallint DEFAULT 0::smallint,
    blogger character varying(255) DEFAULT NULL::character varying,
    facebook character varying(255) DEFAULT NULL::character varying,
    flickr character varying(255) DEFAULT NULL::character varying,
    google character varying(255) DEFAULT NULL::character varying,
    linkedin character varying(255) DEFAULT NULL::character varying,
    metacafe character varying(255) DEFAULT NULL::character varying,
    myspace character varying(255) DEFAULT NULL::character varying,
    orkut character varying(255) DEFAULT NULL::character varying,
    tumblr character varying(255) DEFAULT NULL::character varying,
    twitter character varying(255) DEFAULT NULL::character varying,
    website character varying(255) DEFAULT NULL::character varying,
    wordpress character varying(255) DEFAULT NULL::character varying,
    yahoo character varying(255) DEFAULT NULL::character varying,
    youtube character varying(255) DEFAULT NULL::character varying,
    moderator smallint DEFAULT 0::smallint NOT NULL
);


ALTER TABLE public.bbii_member OWNER TO postgres;

--
-- Name: bbii_membergroup; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE bbii_membergroup (
    id integer NOT NULL,
    name character varying(45) NOT NULL,
    description text,
    min_posts smallint DEFAULT (-1)::smallint NOT NULL,
    color character varying,
    image character varying(255) DEFAULT NULL::character varying
);


ALTER TABLE public.bbii_membergroup OWNER TO postgres;

--
-- Name: bbii_membergroup_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE bbii_membergroup_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.bbii_membergroup_id_seq OWNER TO postgres;

--
-- Name: bbii_membergroup_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE bbii_membergroup_id_seq OWNED BY bbii_membergroup.id;


--
-- Name: bbii_message; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE bbii_message (
    id integer NOT NULL,
    sendfrom bigint NOT NULL,
    sendto integer NOT NULL,
    subject character varying(255) NOT NULL,
    content text NOT NULL,
    create_time timestamp without time zone DEFAULT now() NOT NULL,
    read_indicator smallint DEFAULT 0::smallint NOT NULL,
    type smallint DEFAULT 0::smallint NOT NULL,
    inbox smallint DEFAULT 1::smallint NOT NULL,
    outbox smallint DEFAULT 1::smallint NOT NULL,
    ip character varying(39) NOT NULL,
    post_id bigint
);


ALTER TABLE public.bbii_message OWNER TO postgres;

--
-- Name: bbii_message_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE bbii_message_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.bbii_message_id_seq OWNER TO postgres;

--
-- Name: bbii_message_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE bbii_message_id_seq OWNED BY bbii_message.id;


--
-- Name: bbii_poll; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE bbii_poll (
    id integer NOT NULL,
    question character varying(200) NOT NULL,
    post_id bigint NOT NULL,
    user_id bigint NOT NULL,
    expire_date date,
    allow_revote smallint DEFAULT 0::smallint NOT NULL,
    allow_multiple smallint DEFAULT 0::smallint NOT NULL,
    votes bigint DEFAULT 0::bigint NOT NULL
);


ALTER TABLE public.bbii_poll OWNER TO postgres;

--
-- Name: bbii_poll_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE bbii_poll_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.bbii_poll_id_seq OWNER TO postgres;

--
-- Name: bbii_poll_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE bbii_poll_id_seq OWNED BY bbii_poll.id;


--
-- Name: bbii_post; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE bbii_post (
    id integer NOT NULL,
    subject character varying(255) NOT NULL,
    content text NOT NULL,
    user_id bigint NOT NULL,
    topic_id bigint,
    forum_id bigint,
    ip character varying(39) DEFAULT NULL::character varying,
    create_time timestamp without time zone,
    approved smallint,
    change_id bigint,
    change_time timestamp without time zone,
    change_reason character varying(255) DEFAULT NULL::character varying,
    upvoted smallint DEFAULT 0::smallint
);


ALTER TABLE public.bbii_post OWNER TO postgres;

--
-- Name: bbii_post_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE bbii_post_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.bbii_post_id_seq OWNER TO postgres;

--
-- Name: bbii_post_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE bbii_post_id_seq OWNED BY bbii_post.id;


--
-- Name: bbii_session; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE bbii_session (
    id character varying(128) NOT NULL,
    last_visit timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.bbii_session OWNER TO postgres;

--
-- Name: bbii_setting; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE bbii_setting (
    id integer NOT NULL,
    contact_email character varying(255) DEFAULT NULL::character varying
);


ALTER TABLE public.bbii_setting OWNER TO postgres;

--
-- Name: bbii_setting_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE bbii_setting_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.bbii_setting_id_seq OWNER TO postgres;

--
-- Name: bbii_setting_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE bbii_setting_id_seq OWNED BY bbii_setting.id;


--
-- Name: bbii_spider; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE bbii_spider (
    id integer NOT NULL,
    name character varying(45) NOT NULL,
    user_agent character varying(255) NOT NULL,
    hits bigint DEFAULT 0::bigint NOT NULL,
    last_visit timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.bbii_spider OWNER TO postgres;

--
-- Name: bbii_spider_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE bbii_spider_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.bbii_spider_id_seq OWNER TO postgres;

--
-- Name: bbii_spider_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE bbii_spider_id_seq OWNED BY bbii_spider.id;


--
-- Name: bbii_topic; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE bbii_topic (
    id integer NOT NULL,
    forum_id bigint NOT NULL,
    user_id bigint NOT NULL,
    title character varying(255) NOT NULL,
    first_post_id bigint NOT NULL,
    last_post_id bigint NOT NULL,
    num_replies bigint DEFAULT 0::bigint NOT NULL,
    num_views bigint DEFAULT 0::bigint NOT NULL,
    approved smallint DEFAULT 0::smallint NOT NULL,
    locked smallint DEFAULT 0::smallint NOT NULL,
    sticky smallint DEFAULT 0::smallint NOT NULL,
    global smallint DEFAULT 0::smallint NOT NULL,
    moved bigint DEFAULT 0::bigint NOT NULL,
    upvoted smallint DEFAULT 0::smallint
);


ALTER TABLE public.bbii_topic OWNER TO postgres;

--
-- Name: bbii_topic_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE bbii_topic_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.bbii_topic_id_seq OWNER TO postgres;

--
-- Name: bbii_topic_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE bbii_topic_id_seq OWNED BY bbii_topic.id;


--
-- Name: bbii_upvoted; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE bbii_upvoted (
    member_id bigint NOT NULL,
    post_id bigint NOT NULL
);


ALTER TABLE public.bbii_upvoted OWNER TO postgres;

--
-- Name: bbii_vote; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE bbii_vote (
    poll_id bigint NOT NULL,
    choice_id bigint NOT NULL,
    user_id bigint NOT NULL
);


ALTER TABLE public.bbii_vote OWNER TO postgres;

--
-- Name: gameId; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Games" ALTER COLUMN "gameId" SET DEFAULT nextval('"3DS_Games_gameId_seq"'::regclass);


--
-- Name: itemId; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Items" ALTER COLUMN "itemId" SET DEFAULT nextval('"3DS_Items_itemId_seq"'::regclass);


--
-- Name: matchId; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Matches" ALTER COLUMN "matchId" SET DEFAULT nextval('"3DS_Matches_matchId_seq"'::regclass);


--
-- Name: organizationId; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Organization" ALTER COLUMN "organizationId" SET DEFAULT nextval('"3DS_Organization_organizationId_seq"'::regclass);


--
-- Name: roundId; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Rounds" ALTER COLUMN "roundId" SET DEFAULT nextval('"3DS_Rounds_roundId_seq"'::regclass);


--
-- Name: stageId; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Stages" ALTER COLUMN "stageId" SET DEFAULT nextval('"3DS_Stages_stageId_seq"'::regclass);


--
-- Name: tournamentId; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Tournaments" ALTER COLUMN "tournamentId" SET DEFAULT nextval('"3DS_Tournaments_tournamentId_seq"'::regclass);


--
-- Name: characterGlickoId; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "CharacterGlickoData" ALTER COLUMN "characterGlickoId" SET DEFAULT nextval('"CharacterGlickoData_characterGlickoId_seq"'::regclass);


--
-- Name: characterId; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Characters" ALTER COLUMN "characterId" SET DEFAULT nextval('"Characters_characterId_seq"'::regclass);


--
-- Name: financesId; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Finances" ALTER COLUMN "financesId" SET DEFAULT nextval('"Finances_financesId_seq"'::regclass);


--
-- Name: glickoId; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "GlickoData" ALTER COLUMN "glickoId" SET DEFAULT nextval('"GlickoData_glickoId_seq"'::regclass);


--
-- Name: locationId; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Location" ALTER COLUMN "locationId" SET DEFAULT nextval('"Location_locationId_seq"'::regclass);


--
-- Name: playerId; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Players" ALTER COLUMN "playerId" SET DEFAULT nextval('"Players_playerId_seq"'::regclass);


--
-- Name: locationId; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Players" ALTER COLUMN "locationId" SET DEFAULT nextval('"Players_locationId_seq"'::regclass);


--
-- Name: rulesetId; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Rulesets" ALTER COLUMN "rulesetId" SET DEFAULT nextval('"Rulesets_rulesetId_seq"'::regclass);


--
-- Name: stageGlickoId; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "StageGlickoData" ALTER COLUMN "stageGlickoId" SET DEFAULT nextval('"StageGlickoData_stageGlickoId_seq"'::regclass);


--
-- Name: userId; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Users" ALTER COLUMN "userId" SET DEFAULT nextval('"Users_userId_seq"'::regclass);


--
-- Name: gameId; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Games" ALTER COLUMN "gameId" SET DEFAULT nextval('"Games_gameId_seq"'::regclass);


--
-- Name: itemId; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Items" ALTER COLUMN "itemId" SET DEFAULT nextval('"Items_itemId_seq"'::regclass);


--
-- Name: matchId; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Matches" ALTER COLUMN "matchId" SET DEFAULT nextval('"Matches_matchId_seq"'::regclass);


--
-- Name: organizationId; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Organization" ALTER COLUMN "organizationId" SET DEFAULT nextval('"Organization_organizationId_seq"'::regclass);


--
-- Name: roundId; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Rounds" ALTER COLUMN "roundId" SET DEFAULT nextval('"Rounds_roundId_seq"'::regclass);


--
-- Name: stageId; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Stages" ALTER COLUMN "stageId" SET DEFAULT nextval('"Stages_stageId_seq"'::regclass);


--
-- Name: tournamentId; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Tournaments" ALTER COLUMN "tournamentId" SET DEFAULT nextval('"Tournaments_tournamentId_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY bbii_choice ALTER COLUMN id SET DEFAULT nextval('bbii_choice_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY bbii_forum ALTER COLUMN id SET DEFAULT nextval('bbii_forum_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY bbii_ipaddress ALTER COLUMN id SET DEFAULT nextval('bbii_ipaddress_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY bbii_membergroup ALTER COLUMN id SET DEFAULT nextval('bbii_membergroup_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY bbii_message ALTER COLUMN id SET DEFAULT nextval('bbii_message_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY bbii_poll ALTER COLUMN id SET DEFAULT nextval('bbii_poll_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY bbii_post ALTER COLUMN id SET DEFAULT nextval('bbii_post_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY bbii_setting ALTER COLUMN id SET DEFAULT nextval('bbii_setting_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY bbii_spider ALTER COLUMN id SET DEFAULT nextval('bbii_spider_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY bbii_topic ALTER COLUMN id SET DEFAULT nextval('bbii_topic_id_seq'::regclass);


--
-- Name: 3DS_Games_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "3DS_Games"
    ADD CONSTRAINT "3DS_Games_pkey" PRIMARY KEY ("gameId");


--
-- Name: 3DS_Items_itemName_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "3DS_Items"
    ADD CONSTRAINT "3DS_Items_itemName_key" UNIQUE ("itemName");


--
-- Name: 3DS_Items_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "3DS_Items"
    ADD CONSTRAINT "3DS_Items_pkey" PRIMARY KEY ("itemId");


--
-- Name: 3DS_Matches_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "3DS_Matches"
    ADD CONSTRAINT "3DS_Matches_pkey" PRIMARY KEY ("matchId");


--
-- Name: 3DS_Organization_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "3DS_Organization"
    ADD CONSTRAINT "3DS_Organization_pkey" PRIMARY KEY ("organizationId");


--
-- Name: 3DS_Rounds_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "3DS_Rounds"
    ADD CONSTRAINT "3DS_Rounds_pkey" PRIMARY KEY ("organizationId");


--
-- Name: 3DS_Stages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "3DS_Stages"
    ADD CONSTRAINT "3DS_Stages_pkey" PRIMARY KEY ("stageId");


--
-- Name: 3DS_Stages_stageName_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "3DS_Stages"
    ADD CONSTRAINT "3DS_Stages_stageName_key" UNIQUE ("stageName");


--
-- Name: 3DS_Tournament_Characters_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "3DS_Tournament_Characters"
    ADD CONSTRAINT "3DS_Tournament_Characters_pkey" PRIMARY KEY ("tournamentId", "characterId");


--
-- Name: 3DS_Tournament_Items_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "3DS_Tournament_Items"
    ADD CONSTRAINT "3DS_Tournament_Items_pkey" PRIMARY KEY ("tournamentId", "itemId");


--
-- Name: 3DS_Tournament_Organizers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "3DS_Tournament_Organizers"
    ADD CONSTRAINT "3DS_Tournament_Organizers_pkey" PRIMARY KEY ("tournamentId", "userId");


--
-- Name: 3DS_Tournament_Players_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "3DS_Tournament_Players"
    ADD CONSTRAINT "3DS_Tournament_Players_pkey" PRIMARY KEY ("tournamentId", "playerId");


--
-- Name: 3DS_Tournament_Stages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "3DS_Tournament_Stages"
    ADD CONSTRAINT "3DS_Tournament_Stages_pkey" PRIMARY KEY ("tournamentId", "stageId");


--
-- Name: 3DS_Tournaments_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "3DS_Tournaments"
    ADD CONSTRAINT "3DS_Tournaments_pkey" PRIMARY KEY ("tournamentId");


--
-- Name: AuthAssignment_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "AuthAssignment"
    ADD CONSTRAINT "AuthAssignment_pkey" PRIMARY KEY (itemname, userid);


--
-- Name: AuthItemChild_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "AuthItemChild"
    ADD CONSTRAINT "AuthItemChild_pkey" PRIMARY KEY (parent, child);


--
-- Name: AuthItem_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "AuthItem"
    ADD CONSTRAINT "AuthItem_pkey" PRIMARY KEY (name);


--
-- Name: CharacterGlickoData_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "CharacterGlickoData"
    ADD CONSTRAINT "CharacterGlickoData_pkey" PRIMARY KEY ("characterGlickoId");


--
-- Name: Characters_characterName_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "Characters"
    ADD CONSTRAINT "Characters_characterName_key" UNIQUE ("characterName");


--
-- Name: Characters_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "Characters"
    ADD CONSTRAINT "Characters_pkey" PRIMARY KEY ("characterId");


--
-- Name: Finances_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "Finances"
    ADD CONSTRAINT "Finances_pkey" PRIMARY KEY ("financesId");


--
-- Name: Games_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "WiiU_Games"
    ADD CONSTRAINT "Games_pkey" PRIMARY KEY ("gameId");


--
-- Name: GlickoData_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "GlickoData"
    ADD CONSTRAINT "GlickoData_pkey" PRIMARY KEY ("glickoId");


--
-- Name: Items_itemName_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "WiiU_Items"
    ADD CONSTRAINT "Items_itemName_key" UNIQUE ("itemName");


--
-- Name: Items_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "WiiU_Items"
    ADD CONSTRAINT "Items_pkey" PRIMARY KEY ("itemId");


--
-- Name: Location_locationCode_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "Location"
    ADD CONSTRAINT "Location_locationCode_key" UNIQUE ("locationCode");


--
-- Name: Location_locationName_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "Location"
    ADD CONSTRAINT "Location_locationName_key" UNIQUE ("locationName");


--
-- Name: Location_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "Location"
    ADD CONSTRAINT "Location_pkey" PRIMARY KEY ("locationId");


--
-- Name: Matches_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "WiiU_Matches"
    ADD CONSTRAINT "Matches_pkey" PRIMARY KEY ("matchId");


--
-- Name: Organization_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "WiiU_Organization"
    ADD CONSTRAINT "Organization_pkey" PRIMARY KEY ("organizationId");


--
-- Name: Players_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "Players"
    ADD CONSTRAINT "Players_pkey" PRIMARY KEY ("playerId");


--
-- Name: Players_playerNickname_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "Players"
    ADD CONSTRAINT "Players_playerNickname_key" UNIQUE ("playerNickname");


--
-- Name: Rounds_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "WiiU_Rounds"
    ADD CONSTRAINT "Rounds_pkey" PRIMARY KEY ("organizationId");


--
-- Name: Rulesets_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "Rulesets"
    ADD CONSTRAINT "Rulesets_pkey" PRIMARY KEY ("rulesetId");


--
-- Name: Rulesets_rulesetName_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "Rulesets"
    ADD CONSTRAINT "Rulesets_rulesetName_key" UNIQUE ("rulesetName");


--
-- Name: StageGlickoData_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "StageGlickoData"
    ADD CONSTRAINT "StageGlickoData_pkey" PRIMARY KEY ("stageGlickoId");


--
-- Name: Stages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "WiiU_Stages"
    ADD CONSTRAINT "Stages_pkey" PRIMARY KEY ("stageId");


--
-- Name: Stages_stageName_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "WiiU_Stages"
    ADD CONSTRAINT "Stages_stageName_key" UNIQUE ("stageName");


--
-- Name: Tournament_Characters_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "WiiU_Tournament_Characters"
    ADD CONSTRAINT "Tournament_Characters_pkey" PRIMARY KEY ("tournamentId", "characterId");


--
-- Name: Tournament_Items_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "WiiU_Tournament_Items"
    ADD CONSTRAINT "Tournament_Items_pkey" PRIMARY KEY ("tournamentId", "itemId");


--
-- Name: Tournament_Organizers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "WiiU_Tournament_Organizers"
    ADD CONSTRAINT "Tournament_Organizers_pkey" PRIMARY KEY ("tournamentId", "userId");


--
-- Name: Tournament_Players_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "WiiU_Tournament_Players"
    ADD CONSTRAINT "Tournament_Players_pkey" PRIMARY KEY ("tournamentId", "playerId");


--
-- Name: Tournament_Stages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "WiiU_Tournament_Stages"
    ADD CONSTRAINT "Tournament_Stages_pkey" PRIMARY KEY ("tournamentId", "stageId");


--
-- Name: Tournaments_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "WiiU_Tournaments"
    ADD CONSTRAINT "Tournaments_pkey" PRIMARY KEY ("tournamentId");


--
-- Name: Users_emailAddress_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "Users"
    ADD CONSTRAINT "Users_emailAddress_key" UNIQUE ("emailAddress");


--
-- Name: Users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "Users"
    ADD CONSTRAINT "Users_pkey" PRIMARY KEY ("userId");


--
-- Name: Users_userName_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "Users"
    ADD CONSTRAINT "Users_userName_key" UNIQUE ("userName");


--
-- Name: bbii_choice_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY bbii_choice
    ADD CONSTRAINT bbii_choice_pkey PRIMARY KEY (id);


--
-- Name: bbii_forum_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY bbii_forum
    ADD CONSTRAINT bbii_forum_pkey PRIMARY KEY (id);


--
-- Name: bbii_ipaddress_ip_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY bbii_ipaddress
    ADD CONSTRAINT bbii_ipaddress_ip_key UNIQUE (ip);


--
-- Name: bbii_ipaddress_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY bbii_ipaddress
    ADD CONSTRAINT bbii_ipaddress_pkey PRIMARY KEY (id);


--
-- Name: bbii_log_topic_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY bbii_log_topic
    ADD CONSTRAINT bbii_log_topic_pkey PRIMARY KEY (member_id, topic_id);


--
-- Name: bbii_member_member_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY bbii_member
    ADD CONSTRAINT bbii_member_member_name_key UNIQUE (member_name);


--
-- Name: bbii_member_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY bbii_member
    ADD CONSTRAINT bbii_member_pkey PRIMARY KEY (id);


--
-- Name: bbii_membergroup_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY bbii_membergroup
    ADD CONSTRAINT bbii_membergroup_pkey PRIMARY KEY (id);


--
-- Name: bbii_message_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY bbii_message
    ADD CONSTRAINT bbii_message_pkey PRIMARY KEY (id);


--
-- Name: bbii_poll_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY bbii_poll
    ADD CONSTRAINT bbii_poll_pkey PRIMARY KEY (id);


--
-- Name: bbii_post_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY bbii_post
    ADD CONSTRAINT bbii_post_pkey PRIMARY KEY (id);


--
-- Name: bbii_session_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY bbii_session
    ADD CONSTRAINT bbii_session_pkey PRIMARY KEY (id);


--
-- Name: bbii_setting_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY bbii_setting
    ADD CONSTRAINT bbii_setting_pkey PRIMARY KEY (id);


--
-- Name: bbii_spider_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY bbii_spider
    ADD CONSTRAINT bbii_spider_pkey PRIMARY KEY (id);


--
-- Name: bbii_topic_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY bbii_topic
    ADD CONSTRAINT bbii_topic_pkey PRIMARY KEY (id);


--
-- Name: bbii_vote_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY bbii_vote
    ADD CONSTRAINT bbii_vote_pkey PRIMARY KEY (poll_id, choice_id, user_id);


--
-- Name: create_time_INDEX; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX "create_time_INDEX" ON bbii_post USING btree (create_time);


--
-- Name: forum_id_INDEX; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX "forum_id_INDEX" ON bbii_topic USING btree (forum_id);


--
-- Name: idx_choice_poll; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX idx_choice_poll ON bbii_choice USING btree (poll_id);


--
-- Name: idx_log_forum_id; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX idx_log_forum_id ON bbii_log_topic USING btree (forum_id);


--
-- Name: idx_poll_post; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX idx_poll_post ON bbii_poll USING btree (post_id);


--
-- Name: idx_upvoted_member; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX idx_upvoted_member ON bbii_upvoted USING btree (member_id);


--
-- Name: idx_upvoted_post; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX idx_upvoted_post ON bbii_upvoted USING btree (post_id);


--
-- Name: idx_vote_choice; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX idx_vote_choice ON bbii_vote USING btree (choice_id);


--
-- Name: idx_vote_poll; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX idx_vote_poll ON bbii_vote USING btree (poll_id);


--
-- Name: idx_vote_user; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX idx_vote_user ON bbii_vote USING btree (user_id);


--
-- Name: sendfrom_INDEX; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX "sendfrom_INDEX" ON bbii_message USING btree (sendfrom);


--
-- Name: sendto_INDEX; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX "sendto_INDEX" ON bbii_message USING btree (sendto);


--
-- Name: topic_id_INDEX; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX "topic_id_INDEX" ON bbii_post USING btree (topic_id);


--
-- Name: user_id_INDEX; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX "user_id_INDEX" ON bbii_post USING btree (user_id);


--
-- Name: createTimeUpdate; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER "createTimeUpdate" BEFORE UPDATE ON bbii_message FOR EACH ROW EXECUTE PROCEDURE upd_createtime();


--
-- Name: lastVisitUpdate; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER "lastVisitUpdate" BEFORE UPDATE ON bbii_session FOR EACH ROW EXECUTE PROCEDURE upd_lastvisit();


--
-- Name: lastVisitUpdate; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER "lastVisitUpdate" BEFORE UPDATE ON bbii_spider FOR EACH ROW EXECUTE PROCEDURE upd_lastvisit();


--
-- Name: 3DS_Games_characterPlayer1_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Games"
    ADD CONSTRAINT "3DS_Games_characterPlayer1_fkey" FOREIGN KEY ("characterPlayer1") REFERENCES "Characters"("characterId");


--
-- Name: 3DS_Games_characterPlayer2_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Games"
    ADD CONSTRAINT "3DS_Games_characterPlayer2_fkey" FOREIGN KEY ("characterPlayer2") REFERENCES "Characters"("characterId");


--
-- Name: 3DS_Games_characterPlayer3_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Games"
    ADD CONSTRAINT "3DS_Games_characterPlayer3_fkey" FOREIGN KEY ("characterPlayer3") REFERENCES "Characters"("characterId");


--
-- Name: 3DS_Games_characterPlayer4_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Games"
    ADD CONSTRAINT "3DS_Games_characterPlayer4_fkey" FOREIGN KEY ("characterPlayer4") REFERENCES "Characters"("characterId");


--
-- Name: 3DS_Games_matchId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Games"
    ADD CONSTRAINT "3DS_Games_matchId_fkey" FOREIGN KEY ("matchId") REFERENCES "3DS_Matches"("matchId");


--
-- Name: 3DS_Matches_nextMatch_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Matches"
    ADD CONSTRAINT "3DS_Matches_nextMatch_fkey" FOREIGN KEY ("nextMatch") REFERENCES "3DS_Matches"("matchId");


--
-- Name: 3DS_Matches_player1_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Matches"
    ADD CONSTRAINT "3DS_Matches_player1_fkey" FOREIGN KEY (player1) REFERENCES "Players"("playerId");


--
-- Name: 3DS_Matches_player2_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Matches"
    ADD CONSTRAINT "3DS_Matches_player2_fkey" FOREIGN KEY (player2) REFERENCES "Players"("playerId");


--
-- Name: 3DS_Matches_player3_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Matches"
    ADD CONSTRAINT "3DS_Matches_player3_fkey" FOREIGN KEY (player3) REFERENCES "Players"("playerId");


--
-- Name: 3DS_Matches_player4_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Matches"
    ADD CONSTRAINT "3DS_Matches_player4_fkey" FOREIGN KEY (player4) REFERENCES "Players"("playerId");


--
-- Name: 3DS_Matches_previousMatch_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Matches"
    ADD CONSTRAINT "3DS_Matches_previousMatch_fkey" FOREIGN KEY ("previousMatch") REFERENCES "3DS_Matches"("matchId");


--
-- Name: 3DS_Matches_roundId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Matches"
    ADD CONSTRAINT "3DS_Matches_roundId_fkey" FOREIGN KEY ("roundId") REFERENCES "3DS_Rounds"("organizationId");


--
-- Name: 3DS_Matches_tournamentId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Matches"
    ADD CONSTRAINT "3DS_Matches_tournamentId_fkey" FOREIGN KEY ("tournamentId") REFERENCES "3DS_Tournaments"("tournamentId");


--
-- Name: 3DS_Organization_tournamentId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Organization"
    ADD CONSTRAINT "3DS_Organization_tournamentId_fkey" FOREIGN KEY ("tournamentId") REFERENCES "3DS_Tournaments"("tournamentId");


--
-- Name: 3DS_Rounds_organizationId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Rounds"
    ADD CONSTRAINT "3DS_Rounds_organizationId_fkey" FOREIGN KEY ("organizationId") REFERENCES "3DS_Organization"("organizationId");


--
-- Name: 3DS_Tournament_Characters_characterId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Tournament_Characters"
    ADD CONSTRAINT "3DS_Tournament_Characters_characterId_fkey" FOREIGN KEY ("characterId") REFERENCES "Characters"("characterId") ON DELETE CASCADE;


--
-- Name: 3DS_Tournament_Characters_tournamentId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Tournament_Characters"
    ADD CONSTRAINT "3DS_Tournament_Characters_tournamentId_fkey" FOREIGN KEY ("tournamentId") REFERENCES "3DS_Tournaments"("tournamentId") ON DELETE CASCADE;


--
-- Name: 3DS_Tournament_Items_itemId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Tournament_Items"
    ADD CONSTRAINT "3DS_Tournament_Items_itemId_fkey" FOREIGN KEY ("itemId") REFERENCES "3DS_Items"("itemId") ON DELETE CASCADE;


--
-- Name: 3DS_Tournament_Items_tournamentId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Tournament_Items"
    ADD CONSTRAINT "3DS_Tournament_Items_tournamentId_fkey" FOREIGN KEY ("tournamentId") REFERENCES "3DS_Tournaments"("tournamentId") ON DELETE CASCADE;


--
-- Name: 3DS_Tournament_Organizers_tournamentId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Tournament_Organizers"
    ADD CONSTRAINT "3DS_Tournament_Organizers_tournamentId_fkey" FOREIGN KEY ("tournamentId") REFERENCES "3DS_Tournaments"("tournamentId") ON DELETE CASCADE;


--
-- Name: 3DS_Tournament_Organizers_userId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Tournament_Organizers"
    ADD CONSTRAINT "3DS_Tournament_Organizers_userId_fkey" FOREIGN KEY ("userId") REFERENCES "Users"("userId") ON DELETE CASCADE;


--
-- Name: 3DS_Tournament_Players_playerId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Tournament_Players"
    ADD CONSTRAINT "3DS_Tournament_Players_playerId_fkey" FOREIGN KEY ("playerId") REFERENCES "Players"("playerId") ON DELETE CASCADE;


--
-- Name: 3DS_Tournament_Players_tournamentId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Tournament_Players"
    ADD CONSTRAINT "3DS_Tournament_Players_tournamentId_fkey" FOREIGN KEY ("tournamentId") REFERENCES "3DS_Tournaments"("tournamentId") ON DELETE CASCADE;


--
-- Name: 3DS_Tournament_Stages_stageId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Tournament_Stages"
    ADD CONSTRAINT "3DS_Tournament_Stages_stageId_fkey" FOREIGN KEY ("stageId") REFERENCES "3DS_Stages"("stageId") ON DELETE CASCADE;


--
-- Name: 3DS_Tournament_Stages_tournamentId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Tournament_Stages"
    ADD CONSTRAINT "3DS_Tournament_Stages_tournamentId_fkey" FOREIGN KEY ("tournamentId") REFERENCES "3DS_Tournaments"("tournamentId") ON DELETE CASCADE;


--
-- Name: 3DS_Tournaments_financesId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Tournaments"
    ADD CONSTRAINT "3DS_Tournaments_financesId_fkey" FOREIGN KEY ("financesId") REFERENCES "Finances"("financesId");


--
-- Name: 3DS_Tournaments_locationId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Tournaments"
    ADD CONSTRAINT "3DS_Tournaments_locationId_fkey" FOREIGN KEY ("locationId") REFERENCES "Location"("locationId");


--
-- Name: 3DS_Tournaments_rulesetId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "3DS_Tournaments"
    ADD CONSTRAINT "3DS_Tournaments_rulesetId_fkey" FOREIGN KEY ("rulesetId") REFERENCES "Rulesets"("rulesetId");


--
-- Name: AuthAssignment_itemname_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "AuthAssignment"
    ADD CONSTRAINT "AuthAssignment_itemname_fkey" FOREIGN KEY (itemname) REFERENCES "AuthItem"(name) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: AuthItemChild_child_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "AuthItemChild"
    ADD CONSTRAINT "AuthItemChild_child_fkey" FOREIGN KEY (child) REFERENCES "AuthItem"(name) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: AuthItemChild_parent_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "AuthItemChild"
    ADD CONSTRAINT "AuthItemChild_parent_fkey" FOREIGN KEY (parent) REFERENCES "AuthItem"(name) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: CharacterGlickoData_characterId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "CharacterGlickoData"
    ADD CONSTRAINT "CharacterGlickoData_characterId_fkey" FOREIGN KEY ("characterId") REFERENCES "Characters"("characterId");


--
-- Name: CharacterGlickoData_playerId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "CharacterGlickoData"
    ADD CONSTRAINT "CharacterGlickoData_playerId_fkey" FOREIGN KEY ("playerId") REFERENCES "Players"("playerId");


--
-- Name: CharacterGlickoData_teammateCharacter_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "CharacterGlickoData"
    ADD CONSTRAINT "CharacterGlickoData_teammateCharacter_fkey" FOREIGN KEY ("teammateCharacter") REFERENCES "Characters"("characterId");


--
-- Name: CharacterGlickoData_teammateId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "CharacterGlickoData"
    ADD CONSTRAINT "CharacterGlickoData_teammateId_fkey" FOREIGN KEY ("teammateId") REFERENCES "Players"("playerId");


--
-- Name: Games_characterPlayer1_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Games"
    ADD CONSTRAINT "Games_characterPlayer1_fkey" FOREIGN KEY ("characterPlayer1") REFERENCES "Characters"("characterId");


--
-- Name: Games_characterPlayer2_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Games"
    ADD CONSTRAINT "Games_characterPlayer2_fkey" FOREIGN KEY ("characterPlayer2") REFERENCES "Characters"("characterId");


--
-- Name: Games_characterPlayer3_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Games"
    ADD CONSTRAINT "Games_characterPlayer3_fkey" FOREIGN KEY ("characterPlayer3") REFERENCES "Characters"("characterId");


--
-- Name: Games_characterPlayer4_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Games"
    ADD CONSTRAINT "Games_characterPlayer4_fkey" FOREIGN KEY ("characterPlayer4") REFERENCES "Characters"("characterId");


--
-- Name: Games_matchId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Games"
    ADD CONSTRAINT "Games_matchId_fkey" FOREIGN KEY ("matchId") REFERENCES "WiiU_Matches"("matchId") ON DELETE CASCADE;


--
-- Name: Games_stagePicker1_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Games"
    ADD CONSTRAINT "Games_stagePicker1_fkey" FOREIGN KEY ("stagePicker1") REFERENCES "Characters"("characterId");


--
-- Name: Games_stagePicker2_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Games"
    ADD CONSTRAINT "Games_stagePicker2_fkey" FOREIGN KEY ("stagePicker2") REFERENCES "Characters"("characterId");


--
-- Name: Games_winner1_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Games"
    ADD CONSTRAINT "Games_winner1_fkey" FOREIGN KEY (winner1) REFERENCES "Characters"("characterId");


--
-- Name: Games_winner2_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Games"
    ADD CONSTRAINT "Games_winner2_fkey" FOREIGN KEY (winner2) REFERENCES "Characters"("characterId");


--
-- Name: GlickoData_playerId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "GlickoData"
    ADD CONSTRAINT "GlickoData_playerId_fkey" FOREIGN KEY ("playerId") REFERENCES "Players"("playerId");


--
-- Name: GlickoData_teammateId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "GlickoData"
    ADD CONSTRAINT "GlickoData_teammateId_fkey" FOREIGN KEY ("teammateId") REFERENCES "Players"("playerId");


--
-- Name: Matches_nextMatch_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Matches"
    ADD CONSTRAINT "Matches_nextMatch_fkey" FOREIGN KEY ("nextMatch") REFERENCES "WiiU_Matches"("matchId");


--
-- Name: Matches_player1_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Matches"
    ADD CONSTRAINT "Matches_player1_fkey" FOREIGN KEY (player1) REFERENCES "Players"("playerId");


--
-- Name: Matches_player2_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Matches"
    ADD CONSTRAINT "Matches_player2_fkey" FOREIGN KEY (player2) REFERENCES "Players"("playerId");


--
-- Name: Matches_player3_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Matches"
    ADD CONSTRAINT "Matches_player3_fkey" FOREIGN KEY (player3) REFERENCES "Players"("playerId");


--
-- Name: Matches_player4_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Matches"
    ADD CONSTRAINT "Matches_player4_fkey" FOREIGN KEY (player4) REFERENCES "Players"("playerId");


--
-- Name: Matches_previousMatch_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Matches"
    ADD CONSTRAINT "Matches_previousMatch_fkey" FOREIGN KEY ("previousMatch") REFERENCES "WiiU_Matches"("matchId");


--
-- Name: Matches_roundId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Matches"
    ADD CONSTRAINT "Matches_roundId_fkey" FOREIGN KEY ("roundId") REFERENCES "WiiU_Rounds"("organizationId");


--
-- Name: Matches_tournamentId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Matches"
    ADD CONSTRAINT "Matches_tournamentId_fkey" FOREIGN KEY ("tournamentId") REFERENCES "WiiU_Tournaments"("tournamentId");


--
-- Name: Organization_tournamentId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Organization"
    ADD CONSTRAINT "Organization_tournamentId_fkey" FOREIGN KEY ("tournamentId") REFERENCES "WiiU_Tournaments"("tournamentId");


--
-- Name: Players_locationId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Players"
    ADD CONSTRAINT "Players_locationId_fkey" FOREIGN KEY ("locationId") REFERENCES "Location"("locationId");


--
-- Name: Rounds_organizationId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Rounds"
    ADD CONSTRAINT "Rounds_organizationId_fkey" FOREIGN KEY ("organizationId") REFERENCES "WiiU_Organization"("organizationId");


--
-- Name: StageGlickoData_playerId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "StageGlickoData"
    ADD CONSTRAINT "StageGlickoData_playerId_fkey" FOREIGN KEY ("playerId") REFERENCES "Players"("playerId");


--
-- Name: StageGlickoData_stageId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "StageGlickoData"
    ADD CONSTRAINT "StageGlickoData_stageId_fkey" FOREIGN KEY ("stageId") REFERENCES "WiiU_Stages"("stageId");


--
-- Name: StageGlickoData_teammateId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "StageGlickoData"
    ADD CONSTRAINT "StageGlickoData_teammateId_fkey" FOREIGN KEY ("teammateId") REFERENCES "Players"("playerId");


--
-- Name: Tournament_Characters_characterId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Tournament_Characters"
    ADD CONSTRAINT "Tournament_Characters_characterId_fkey" FOREIGN KEY ("characterId") REFERENCES "Characters"("characterId") ON DELETE CASCADE;


--
-- Name: Tournament_Characters_tournamentId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Tournament_Characters"
    ADD CONSTRAINT "Tournament_Characters_tournamentId_fkey" FOREIGN KEY ("tournamentId") REFERENCES "WiiU_Tournaments"("tournamentId") ON DELETE CASCADE;


--
-- Name: Tournament_Items_itemId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Tournament_Items"
    ADD CONSTRAINT "Tournament_Items_itemId_fkey" FOREIGN KEY ("itemId") REFERENCES "WiiU_Items"("itemId") ON DELETE CASCADE;


--
-- Name: Tournament_Items_tournamentId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Tournament_Items"
    ADD CONSTRAINT "Tournament_Items_tournamentId_fkey" FOREIGN KEY ("tournamentId") REFERENCES "WiiU_Tournaments"("tournamentId") ON DELETE CASCADE;


--
-- Name: Tournament_Organizers_tournamentId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Tournament_Organizers"
    ADD CONSTRAINT "Tournament_Organizers_tournamentId_fkey" FOREIGN KEY ("tournamentId") REFERENCES "WiiU_Tournaments"("tournamentId") ON DELETE CASCADE;


--
-- Name: Tournament_Organizers_userId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Tournament_Organizers"
    ADD CONSTRAINT "Tournament_Organizers_userId_fkey" FOREIGN KEY ("userId") REFERENCES "Users"("userId") ON DELETE CASCADE;


--
-- Name: Tournament_Players_playerId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Tournament_Players"
    ADD CONSTRAINT "Tournament_Players_playerId_fkey" FOREIGN KEY ("playerId") REFERENCES "Players"("playerId") ON DELETE CASCADE;


--
-- Name: Tournament_Players_tournamentId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Tournament_Players"
    ADD CONSTRAINT "Tournament_Players_tournamentId_fkey" FOREIGN KEY ("tournamentId") REFERENCES "WiiU_Tournaments"("tournamentId") ON DELETE CASCADE;


--
-- Name: Tournament_Stages_stageId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Tournament_Stages"
    ADD CONSTRAINT "Tournament_Stages_stageId_fkey" FOREIGN KEY ("stageId") REFERENCES "WiiU_Stages"("stageId") ON DELETE CASCADE;


--
-- Name: Tournament_Stages_tournamentId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Tournament_Stages"
    ADD CONSTRAINT "Tournament_Stages_tournamentId_fkey" FOREIGN KEY ("tournamentId") REFERENCES "WiiU_Tournaments"("tournamentId") ON DELETE CASCADE;


--
-- Name: Tournaments_financesId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Tournaments"
    ADD CONSTRAINT "Tournaments_financesId_fkey" FOREIGN KEY ("financesId") REFERENCES "Finances"("financesId");


--
-- Name: Tournaments_locationId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Tournaments"
    ADD CONSTRAINT "Tournaments_locationId_fkey" FOREIGN KEY ("locationId") REFERENCES "Location"("locationId");


--
-- Name: Tournaments_rulesetId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "WiiU_Tournaments"
    ADD CONSTRAINT "Tournaments_rulesetId_fkey" FOREIGN KEY ("rulesetId") REFERENCES "Rulesets"("rulesetId");


--
-- Name: Users_playerId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Users"
    ADD CONSTRAINT "Users_playerId_fkey" FOREIGN KEY ("playerId") REFERENCES "Players"("playerId");


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

