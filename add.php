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

                    try {
                        $db = new TWTXTdb();

                        $db->exec("CREATE TABLE IF NOT EXISTS users (name TEXT NOT NULL, url TEXT NOT NULL)");

                        $query = $db->prepare("INSERT INTO users (name, url) VALUES (?, ?)");
                        $query->bindParam(1, $name);
                        $query->bindParam(2, $url);
                        # bind name and url to the prepared

                        $query->execute();
                        # put the url in the database
                        $db->close();

                        echo "$url has been added to our database for user $name$nl";
                    } catch (Exception $e) {
                        die("Error catched !$nl\Please send an issue on GitHub (jusdepatate/twtxt-registry):$nl". $e->getMessage() ."$nl");
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