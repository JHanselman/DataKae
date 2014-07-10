BEGIN TRANSACTION;

-- Authorization roles.
INSERT INTO "AuthItem" VALUES ('authenticated', 2, 'authenticated user', 'return !Yii::app()->user->isGuest;', 'N;');
INSERT INTO "AuthItem" VALUES ('guest', 2, 'guest user', 'return Yii::app()->user->isGuest;', 'N;');
INSERT INTO "AuthItem" VALUES ('admin', 2, 'administrator', NULL, 'N;');
INSERT INTO "AuthItem" VALUES ('updateSelf', 1, 'update own information', 'return Yii::app()->user->id==$params["User"]->userId;', 'N;');
INSERT INTO "AuthItem" VALUES ('deleteOwnTourney', 1, 'delete own tourney', 'return TournamentOrganizers::ownTourney($params["Tournament"]->tournamentId,Yii::app()->user->id);', 'N;');

COMMIT;