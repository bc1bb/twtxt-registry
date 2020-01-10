<?php

include "lib.php";
ban();
$nl = nl();
init_html();

$db = new TWTXTdb();
$result = $db->query('SELECT * FROM users');

echo "user url$nl";

while ($row = $result->fetchArray()) {
    echo "{$row[0]} {$row[1]}$nl";
}

end_html();