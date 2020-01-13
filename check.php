<?php

include "lib.php";
$nl = nl();
init_html();
ascii_logo();

if (extension_loaded("curl")) {
    echo "cURL is loaded$nl";
    $curl=True;
} else {
    echo "Please install cURL$nl";
    $curl=False;
}
if (extension_loaded("sqlite3")) {
    echo "SQLite3 is loaded$nl";
    $sqlite=True;
} else {
    echo "Please install SQLite3$nl";
    $sqlite=False;
}
if (is_writable(".")) {
    echo "Folder is writeable$nl";
    $writeable=True;
} else {
    echo "Folder is not writeable$nl";
    $writeable=False;
}
if ($curl && $writeable && $sqlite) {
    echo "Everything's OK ! You are ready to run this TWTXT Registry$nl";
}

end_html();