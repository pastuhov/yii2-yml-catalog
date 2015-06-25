/**
 * SQLite
 */

DROP TABLE IF EXISTS "item";

CREATE TABLE "item" (
  "id"          INTEGER NOT NULL PRIMARY KEY,
  "category_id" INTEGER NOT NULL,
  "name"        TEXT    NOT NULL,
  "price"       FLOAT   NOT NULL
);

DROP TABLE IF EXISTS "category";

CREATE TABLE "category" (
  "id"          INTEGER NOT NULL PRIMARY KEY,
  "parent_id"   INTEGER,
  "name"        TEXT    NOT NULL
);

DROP TABLE IF EXISTS "currency";

CREATE TABLE "currency" (
  "id"          INTEGER NOT NULL PRIMARY KEY,
  "name"        TEXT    NOT NULL,
  "rate"        TEXT,
  "plus"        FLOAT
);