-- UP

CREATE TABLE personal_access_tokens (
    id             INTEGER PRIMARY KEY AUTOINCREMENT,
    tokenable_type TEXT    NOT NULL DEFAULT 'users',
    tokenable_id   INTEGER NOT NULL,
    name           TEXT    NOT NULL,
    token          TEXT    NOT NULL UNIQUE,
    abilities      TEXT    NOT NULL DEFAULT '["*"]',
    last_used_at   INTEGER,
    expires_at     INTEGER,
    created_at     INTEGER NOT NULL DEFAULT (unixepoch())
);

-- DOWN

DROP TABLE personal_access_tokens;
