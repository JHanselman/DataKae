--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

--
-- Data for Name: AuthItem; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO "AuthItem" VALUES ('authenticated', 2, 'authenticated user', 'return !Yii::app()->user->isGuest;', 'N;');
INSERT INTO "AuthItem" VALUES ('guest', 2, 'guest user', 'return Yii::app()->user->isGuest;', 'N;');
INSERT INTO "AuthItem" VALUES ('admin', 2, 'administrator', NULL, 'N;');
INSERT INTO "AuthItem" VALUES ('updateSelf', 1, 'update own information', 'return Yii::app()->user->id==$params["User"]->userId;', 'N;');
INSERT INTO "AuthItem" VALUES ('TO', 2, 'tournament organizer', NULL, 'N;');
INSERT INTO "AuthItem" VALUES ('editOwnWiiUTourney', 1, 'edit own Wii U tourney', 'return TournamentOrganizers_WiiU::ownTourney($params["Tournament"]->tournamentId,Yii::app()->user->id);', 'N;');
INSERT INTO "AuthItem" VALUES ('editOwn3DSTourney', 1, 'edit own 3DS tourney', 'return TournamentOrganizers_3DS::ownTourney($params["Tournament"]->tournamentId,Yii::app()->user->id);', NULL);


--
-- PostgreSQL database dump complete
--

