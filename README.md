# Simple Hangman API #

This is a minimal version of a hangman API using the resources as mentioned below.

## Resources ##

**/games (POST)**

Start a new game. At the start of the game a random word will be picked from a list of words in the database.

**/games/[:id] (PUT)**

Guess a started game.

- Guessing a correct letter doesn't decrement the amount of tries left.
- Guessing a letter that has already been guessed issues a warning, but also doesn't decrement the amount of tries left.
- Only valid characters are a-z.

## Response ##

Every response should contain the following fields:

*word*: Representation of the word that is being guessed. Contains dots for letters that have not been guessed yet.
*tries_left*: The number of tries left to guess the word, starts at 11.
*status*: Current status of the game (busy|fail|success).
