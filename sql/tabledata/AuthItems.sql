BEGIN TRANSACTION;


INSERT INTO "AuthItem" VALUES ('authenticated', 2, 'authenticated user', 'return !Yii::app()->user->isGuest;', 'N;');
INSERT INTO "AuthItem" VALUES ('guest', 2, 'guest user', 'return Yii::app()->user->isGuest;', 'N;');
INSERT INTO "AuthItem" VALUES ('admin', 2, 'administrator', NULL, 'N;');
INSERT INTO "AuthItem" VALUES ('updateSelf', 1, 'update own information', 'return Yii::app()->user->id==$params["User"]->userId;', 'N;');
INSERT INTO "AuthItem" VALUES ('TO', 2, 'tournament organizer', NULL, 'N;');
INSERT INTO "AuthItem" VALUES ('editOwnWiiUTourney', 1, 'edit own Wii U tourney', 'return TournamentOrganizers_WiiU::ownTourney($params["Tournament"]->tournamentId,Yii::app()->user->id);', 'N;');
INSERT INTO "AuthItem" VALUES ('editOwn3DSTourney', 1, 'edit own 3DS tourney', 'return TournamentOrganizers_3DS::ownTourney($params["Tournament"]->tournamentId,Yii::app()->user->id);', NULL);

COMMIT;