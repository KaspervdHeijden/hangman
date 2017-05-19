# General notes #

When installing dependencies with composer, I could not install "doctrine/doctrine-migrations-bundle": "2.1.*@dev". I had to change it to "doctrine/doctrine-migrations-bundle": "1.1.1" to get it to work.

Preferably, I would install the FOS Rest bundle (friendsofsymfony/rest-bundle) to optimize the REST server. This would require a minor version migratation of Symfony (>=2.7), which is fairly simple for this project.
However, I feel uncomfortable upgrading Symfony when it's version was fixed not by me. In addition, a minial implementation was requested. So I decided against it, and we shall return JSON, and JSON only.

Initially, I presumed PHP 7.1. The varous type hints were commented out to support PHP 5.3. I tested it in PHP 5.6, PHP 7.0 and PHP 7.1. PHP 5.3 is missing, because I don't have it installed.

In addition to the required fields as stated in README.md, every request also returnes the following fields:

  *	*game_id*: The game ID. Required after a successful "POST /games" request; how else could the client interact with the created game?
  *	*message*: A short message containing feedback over an action.