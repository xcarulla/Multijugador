sqlite3 users.db "CREATE TABLE IF NOT EXISTS `users` (`user_id` INTEGER PRIMARY KEY, `user_name` varchar(63),`user_mail` varchar(63), `user_password` varchar(1023),`salt` varchar(31), `reset_token_hash` varchar(255),`reset_token_expires_at` DATETIME);"
sqlite3 users.db "CREATE UNIQUE INDEX `user_name_UNIQUE` ON `users` (`user_name` ASC);"
sqlite3 users.db "CREATE UNIQUE INDEX `user_mail_UNIQUE` ON `users` (`user_mail` ASC);"
sqlite3 users.db "CREATE UNIQUE INDEX `reset_token_hash_UNIQUE` ON `users` (`reset_token_hash` ASC);"