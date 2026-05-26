-- UP

CREATE TABLE jobs (
    id           INTEGER PRIMARY KEY AUTOINCREMENT,
    queue        TEXT    NOT NULL DEFAULT 'default',
    payload      TEXT    NOT NULL,
    attempts     INTEGER NOT NULL DEFAULT 0,
    reserved_at  INTEGER,
    available_at INTEGER NOT NULL,
    created_at   INTEGER NOT NULL
);

CREATE TABLE failed_jobs (
    id         INTEGER PRIMARY KEY AUTOINCREMENT,
    queue      TEXT    NOT NULL,
    payload    TEXT    NOT NULL,
    exception  TEXT    NOT NULL,
    failed_at  INTEGER NOT NULL DEFAULT (unixepoch())
);

-- DOWN

DROP TABLE failed_jobs;
DROP TABLE jobs;
