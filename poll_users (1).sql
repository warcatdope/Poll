/*
Poll SQL
*/

-- Drop all existing tables
DROP TABLE IF EXISTS poll_users;
DROP TABLE IF EXISTS polls;
DROP TABLE IF EXISTS polls_choices;
DROP TABLE IF EXISTS polls_answers;

-- Creates the users data for login in
CREATE TABLE poll_users (
	id int(11) UNIQUE AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(16) NULL,
	given_name VARCHAR(16) NULL,
	family_name VARCHAR(16) NULL,
	password VARCHAR(40) NOT NULL,
	email VARCHAR(30) NULL);

	
-- Creates polls that will hold the question and start and end date
CREATE TABLE polls (
	id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	question varchar(255) NOT NULL,
	starts date NOT NULL,
	ends date NOT NULL);
	
-- Creates the options for the user to pick from the question
CREATE TABLE polls_choices (
	id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	poll int(11) NOT NULL,
	name varchar(255) NOT NULL);
	
-- Collects the anwers from the poll and choices made
CREATE TABLE polls_answers (
	id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	user int(11) NOT NULL,
	poll int(11) NOT NULL,
	choice int(11) NOT NULL);
	
INSERT INTO polls (id, question, starts, ends) VALUES (1, 'Do you like this website', '2017-11-05', '2018-11-05');
INSERT INTO polls (id, question, starts, ends) VALUES (2, 'Do you like doing polls', '2017-11-05', '2018-11-05');

INSERT INTO polls_choices (id, poll, name) VALUES (1, 1, 'I love it');
INSERT INTO polls_choices (id, poll, name) VALUES (2, 1, 'Its alright');
INSERT INTO polls_choices (id, poll, name) VALUES (3, 1, 'I hate it');
INSERT INTO polls_choices (id, poll, name) VALUES (4, 2, 'I llove polls');
INSERT INTO polls_choices (id, poll, name) VALUES (5, 2, 'Not now');
INSERT INTO polls_choices (id, poll, name) VALUES (6, 2, 'Waste of Time');
	
