# TWTXT Registry
This is a tiny Registry for TWTXT I wrote in less than a day, it stores users in a file named `twtxt.sqlite3` which is as his name says an SQLite3 database (it's `.gitignore`'d so you can easily update).
<br>The code is not the best I've ever done but it's correct.

Even if it's a one day project, it's open to any Pull Request/Feature Request/Issue Reporting on [GitHub](https://github.com/jusdepatate/twtxt-registry/).

## Logging ?
No logging. (but you can ip ban using `$banned_ips` in `ban.php`)

## There is no forms ? how do I add my link ?
Using the good old way:
<br>`curl http://here is the instance url/add.php -F'name="Here is your name"' -F'url="Here is the address of your twtxt"`.

## Are we able to delete users/links ?
- Users:
<br>No, ask the admin of your instance with proofs to delete your link/user.

- Admins:
<br>Use any tool to change the database (I recommend the CLI one `sqlite3`), I'm not planning to do an admin panel.

## How does it checks that links are correct ?
- Checks that the URL is actually an URL,
- Checks the HTTP response code,
- Checks the MIME Type of the file,
- *to be done* Checks that the user doesn't exist.

## Tested on
- PHP 7.2 & Apache2.4 on Ubuntu 18.04.

## Installation
1. `git clone https://github.com/jusdepatate/twtxt-registry && cd twtxt-registry`,
2. `php check.php` (or go at `http://instance url/check.php`) look at the errors here and install all missing modules.
3. That's all.