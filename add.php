<?php

include "lib.php";
ban();
$nl = nl();
init_html();
ascii_logo();

if (is_curlwget()) {

    echo "Welcome !$nl";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        # if user is posting
        $name = strval($_POST["name"]);
        $url = strval($_POST["url"]);
        # import variable

        $name = sqlite3::escapeString($name);
        $url = sqlite3::escapeString($url);
        # anti sql injection

        $name = strip_tags($name);
        $url = strip_tags($url);
        # anti xss

        # check if url is valid
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            # check header of the url
            $url_headers = get_headers($url, 1);

            # check if url gives 404 or not
            if (!strpos($url_headers[0], "404")) {
                # url doesn"t throw 404

                if (strpos($url_headers["Content-Type"], "text/plain;") !== false) {
                    # "!== false" is required as said here https://stackoverflow.com/a/6752601
                    # MIME Type is plain text (txt file)

                    $db = new TWTXTdb();
                    # prepare db

                    $db->exec("CREATE TABLE IF NOT EXISTS users (name TEXT NOT NULL, url TEXT NOT NULL)");
                    # create table *if not exists* so that we get no error with the checks below

                    $queryname = $db->prepare('SELECT * FROM users WHERE name = ?');
                    $queryname->bindParam(1, $name);

                    $queryurl = $db->prepare('SELECT * FROM users WHERE url = ?');
                    $queryurl->bindParam(1, $url);

                    $queryname = $queryname->execute();
                    $rowname = $queryname->fetchArray();

                    $queryurl = $queryurl->execute();
                    $rowurl = $queryurl->fetchArray();

                    if (!$rowname && !$rowurl) {
                        $query = $db->prepare("INSERT INTO users (name, url) VALUES (?, ?)");
                        $query->bindParam(1, $name);
                        $query->bindParam(2, $url);
                        # bind name and url to the prepared

                        $query->execute();
                        # put the url in the database
                        $db->close();

                        echo "$url has been added to our database for user $name$nl";
                    } else {
                        # user/url already exists
                        die("User or URL already exists$nl");
                    }
                } else {
                    # MIME Type is not valid
                    die("$url returns an invalid MIME Type$nl");
                }
            } else {
                # url throw 404
                die("$url is not a valid URL$nl");
            }
        } else {
            # url is not valid
            die("$url is not a valid URL$nl");
        }
    } else {
        # user is not POSTing
        echo "To add your link: curl http://". gethostname(). "/add.php -F'name=Here is your name' -F'url=Here is the address of your twtxt$nl";
    }
} else {
    echo "To add your link: curl http://". gethostname(). "/add.php -F'name=Here is your name' -F'url=Here is the address of your twtxt'$nl";
}

end_html();