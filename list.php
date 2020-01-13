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
        print_r("{$row[0]} {$row[1]}$nl");
        # output the user we've found (will output only the first occurence)
    } else {
        header("Not Found", TRUE, 404);
        echo $nl;
        # reply 404 to client if no user found by db
    }

} else {
    $db = new TWTXTdb();
    $query = $db->query('SELECT * FROM users');

    while ($row = $query->fetchArray()) {
        echo "{$row[0]} {$row[1]}$nl";
    }
}
$db->close();

end_html();