CREATE TABLE "bbii_forum" (
  "id" serial NOT NULL,
  "cat_id" bigint DEFAULT NULL,
  "name" varchar(255) NOT NULL,
  "subtitle" varchar(255) DEFAULT NULL,
  "type" smallint NOT NULL DEFAULT '0',
  "public" smallint NOT NULL DEFAULT '1',
  "locked" smallint NOT NULL DEFAULT '0',
  "moderated" smallint NOT NULL DEFAULT '0',
  "sort" smallint NOT NULL DEFAULT '0',
  "num_posts" bigint NOT NULL DEFAULT '0',
  "num_topics" bigint NOT NULL DEFAULT '0',
  "last_post_id" bigint DEFAULT NULL,
  "poll" smallint NOT NULL DEFAULT '0',
  "membergroup_id" bigint DEFAULT '0',
  PRIMARY KEY ("id")
);

CREATE TABLE "bbii_ipaddress" (
  "id" serial NOT NULL,
  "ip" varchar(39) DEFAULT NULL,
  "address" varchar(255) DEFAULT NULL,
  "source" smallint DEFAULT '0',
  "count"  bigint DEFAULT '0',
  "create_time" timestamp NULL DEFAULT NULL,
  "update_time" timestamp NULL DEFAULT NULL,
  PRIMARY KEY ("id"),
  UNIQUE ("ip")
);

CREATE TABLE "bbii_member" (
  "id"  bigint  NOT NULL,
  "member_name" varchar(45) DEFAULT NULL,
  "gender" smallint DEFAULT NULL,
  "birthdate" date DEFAULT NULL,
  "location" varchar(255) DEFAULT NULL,
  "personal_text" varchar(255) DEFAULT NULL,
  "signature" text,
  "avatar" varchar(255) DEFAULT NULL,
  "show_online" smallint DEFAULT '1',
  "contact_email" smallint DEFAULT '0',
  "contact_pm" smallint DEFAULT '1',
  "timezone" varchar(80) DEFAULT NULL,
  "first_visit" timestamp NULL DEFAULT NULL,
  "last_visit" timestamp NULL DEFAULT NULL,
  "warning" smallint DEFAULT '0',
  "posts"  bigint  DEFAULT '0',
  "group_id" smallint DEFAULT '0',
  "upvoted" smallint DEFAULT '0',
  "blogger" varchar(255) DEFAULT NULL,
  "facebook" varchar(255) DEFAULT NULL,
  "flickr" varchar(255) DEFAULT NULL,
  "google" varchar(255) DEFAULT NULL,
  "linkedin" varchar(255) DEFAULT NULL,
  "metacafe" varchar(255) DEFAULT NULL,
  "myspace" varchar(255) DEFAULT NULL,
  "orkut" varchar(255) DEFAULT NULL,
  "tumblr" varchar(255) DEFAULT NULL,
  "twitter" varchar(255) DEFAULT NULL,
  "website" varchar(255) DEFAULT NULL,
  "wordpress" varchar(255) DEFAULT NULL,
  "yahoo" varchar(255) DEFAULT NULL,
  "youtube" varchar(255) DEFAULT NULL,
  "moderator" smallint NOT NULL DEFAULT '0',
  PRIMARY KEY ("id"),
  UNIQUE ("member_name")
);

CREATE TABLE "bbii_membergroup" (
  "id"  serial  NOT NULL,
  "name" varchar(45) NOT NULL,
  "description" text,
  "min_posts" smallint NOT NULL DEFAULT '-1',
  "color" varchar DEFAULT NULL,
  "image" varchar(255) DEFAULT NULL,
  PRIMARY KEY ("id")
);

CREATE TABLE "bbii_message" (
  "id"  serial  NOT NULL,
  "sendfrom"  bigint  NOT NULL,
  "sendto"  bigint  NOT NULL,
  "subject" varchar(255) NOT NULL,
  "content" text NOT NULL,
  "create_time" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "read_indicator" smallint NOT NULL DEFAULT '0',
  "type" smallint NOT NULL DEFAULT '0',
  "inbox" smallint NOT NULL DEFAULT '1',
  "outbox" smallint NOT NULL DEFAULT '1',
  "ip" varchar(39) NOT NULL,
  "post_id"  bigint  DEFAULT NULL,
  PRIMARY KEY ("id")
);

  CREATE INDEX "sendfrom_INDEX" ON "bbii_message"("sendfrom");
  CREATE INDEX "sendto_INDEX" ON "bbii_message"("sendto");

CREATE TABLE "bbii_post" (
  "id"  serial  NOT NULL,
  "subject" varchar(255) NOT NULL,
  "content" text NOT NULL,
  "user_id"  bigint  NOT NULL,
  "topic_id"  bigint  DEFAULT NULL,
  "forum_id"  bigint  DEFAULT NULL,
  "ip" varchar(39) DEFAULT NULL,
  "create_time" timestamp NULL DEFAULT NULL,
  "approved" smallint DEFAULT NULL,
  "change_id"  bigint  DEFAULT NULL,
  "change_time" timestamp NULL DEFAULT NULL,
  "change_reason" varchar(255) DEFAULT NULL,
  "upvoted" smallint DEFAULT '0',
  PRIMARY KEY ("id")
);

  CREATE INDEX "user_id_INDEX" ON "bbii_post"("user_id");
  CREATE INDEX "topic_id_INDEX" ON "bbii_post"("topic_id");
  CREATE INDEX "create_time_INDEX" ON "bbii_post"("create_time");

CREATE TABLE "bbii_setting" (
  "id"  serial NOT NULL,
  "contact_email" varchar(255) DEFAULT NULL,
  PRIMARY KEY ("id")
);

CREATE TABLE "bbii_topic" (
  "id"  serial  NOT NULL,
  "forum_id"  bigint  NOT NULL,
  "user_id"  bigint  NOT NULL,
  "title" varchar(255) NOT NULL,
  "first_post_id"  bigint  NOT NULL,
  "last_post_id"  bigint  NOT NULL,
  "num_replies"  bigint  NOT NULL DEFAULT '0',
  "num_views"  bigint  NOT NULL DEFAULT '0',
  "approved" smallint NOT NULL DEFAULT '0',
  "locked" smallint NOT NULL DEFAULT '0',
  "sticky" smallint NOT NULL DEFAULT '0',
  "global" smallint NOT NULL DEFAULT '0',
  "moved"  bigint  NOT NULL DEFAULT '0',
  "upvoted" smallint DEFAULT '0',
  PRIMARY KEY ("id")
);


CREATE INDEX  "forum_id_INDEX" ON "bbii_topic"("forum_id");

CREATE TABLE "bbii_session" (
  "id" varchar(128) NOT NULL,
  "last_visit" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY ("id")
);

CREATE TABLE "bbii_log_topic" (
  "member_id"  bigint  NOT NULL,
  "topic_id"  bigint  NOT NULL,
  "forum_id"  bigint  NOT NULL,
  "last_post_id"  bigint  NOT NULL,
  PRIMARY KEY ("member_id","topic_id")
);

CREATE INDEX  "idx_log_forum_id" ON "bbii_log_topic"("forum_id");

CREATE TABLE "bbii_upvoted" (
  "member_id"  bigint  NOT NULL,
  "post_id"  bigint  NOT NULL
) ;

  CREATE INDEX  "idx_upvoted_member" ON "bbii_upvoted" ("member_id");
  CREATE INDEX  "idx_upvoted_post" ON  "bbii_upvoted"("post_id");

CREATE TABLE "bbii_poll" (
  "id"  serial  NOT NULL,
  "question" varchar(200) NOT NULL,
  "post_id"  bigint  NOT NULL,
  "user_id"  bigint  NOT NULL,
  "expire_date" date DEFAULT NULL,
  "allow_revote" smallint NOT NULL DEFAULT '0',
  "allow_multiple" smallint NOT NULL DEFAULT '0',
  "votes"  bigint NOT NULL DEFAULT '0',
  PRIMARY KEY ("id")
);

CREATE INDEX  "idx_poll_post" ON "bbii_poll"("post_id");

CREATE TABLE "bbii_choice" (
  "id"  serial  NOT NULL,
  "choice" varchar(200) NOT NULL,
  "poll_id"  bigint  NOT NULL,
  "sort" smallint NOT NULL DEFAULT '0',
  "votes"  bigint NOT NULL DEFAULT '0',
  PRIMARY KEY ("id")
);


CREATE INDEX  "idx_choice_poll" ON "bbii_choice"("poll_id");

CREATE TABLE "bbii_vote" (
  "poll_id"  bigint  NOT NULL,
  "choice_id"  bigint  NOT NULL,
  "user_id"  bigint  NOT NULL,
  PRIMARY KEY ("poll_id","choice_id","user_id")
);

  CREATE INDEX  "idx_vote_poll" ON "bbii_vote" ("poll_id");
  CREATE INDEX  "idx_vote_user" ON "bbii_vote" ("user_id");
  CREATE INDEX  "idx_vote_choice" ON "bbii_vote" ("choice_id");

CREATE TABLE "bbii_spider" (
  "id"  serial  NOT NULL,
  "name" varchar(45) NOT NULL,
  "user_agent" varchar(255) NOT NULL,
  "hits"  bigint  NOT NULL DEFAULT '0',
  "last_visit" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY ("id")
);

CREATE OR REPLACE FUNCTION upd_createTime() RETURNS TRIGGER 
LANGUAGE plpgsql
AS
$$
BEGIN
    NEW."create_time" = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;

CREATE TRIGGER "createTimeUpdate"
  BEFORE UPDATE
  ON "bbii_message"
  FOR EACH ROW
  EXECUTE PROCEDURE upd_createTime();
  
  CREATE OR REPLACE FUNCTION upd_lastvisit() RETURNS TRIGGER 
LANGUAGE plpgsql
AS
$$
BEGIN
    NEW."last_visit" = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;

CREATE TRIGGER "lastVisitUpdate"
  BEFORE UPDATE
  ON "bbii_session"
  FOR EACH ROW
  EXECUTE PROCEDURE upd_lastvisit();
  
CREATE TRIGGER "lastVisitUpdate"
  BEFORE UPDATE
  ON "bbii_spider"
  FOR EACH ROW
  EXECUTE PROCEDURE upd_lastvisit();
