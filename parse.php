<?php

include "lib.php";
ban();
$nl = nl();
init_html();

if (isset($_GET["q"])) {
    # if the user set an argument ?q to url, search for the user
    $q = strip_tags($_GET["q"]);
    $q = sqlite3::escapeString($q);
    # anti sql injection + anti xss (we never know)

    $db = new TWTXTdb();
    $query = $db->prepare('SELECT * FROM users WHERE name = ?');
    $query->bindParam(1, $q);

    $res = $query->execute();
    $row = $res->fetchArray();

    if ($row) {
        # if there is rows
        $url=$row[1];
        # get url at row 2

        // cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $filecontent = curl_exec($ch);
        $filecontent = strip_tags($filecontent);
        # remove html tags from result

        curl_close($ch);

        #$date="/^[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9](.*)[\t]/m";
        $comment="/^#(.*)$/m";

        if (!is_curlwget()) {
            $nlre="/[\n]/m";
            $filecontent = preg_replace($nlre, "<br>\n", $filecontent);
            # html new line
        }

        #$filecontent = preg_replace($date, "", $filecontent);
        # remove date

        $filecontent = preg_replace($comment, "", $filecontent);
        # remove comments

        echo $filecontent;
    } else {
        header("Not Found", TRUE, 404);
        echo $nl;
        # reply 404 to client if no user found by db
    }

    $db->close();
} else {
    echo "Missing an URL argument (?q) please define it.$nl";
}

end_html();