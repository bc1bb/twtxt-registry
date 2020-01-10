<?php

include "lib.php";
$nl = nl();
init_html();
ascii_logo();

if (extension_loaded("curl")) {
    echo "php's curl is loaded$nl";
    $curl=True;
} else {
    echo "Please install php's curl$nl";
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
    echo "folder is writeable$nl";
    $writeable=True;
} else {
    echo "folder is not writeable$nl";
    $writeable=False;
}
if ($writeable && $sqlite && $curl) {
    echo "Everything's OK ! You are ready to run this TWTXT Registry$nl";
}

end_html();