<?php

class TWTXTdb extends SQLite3 {
    function __construct() {
        $this->open("twtxt.sqlite3");
    }
}

function is_curlwget() {
    # is the page being curl'd, wget'd or shown thru a browser ?
    if (stristr($_SERVER["HTTP_USER_AGENT"], 'curl') or (stristr($_SERVER["HTTP_USER_AGENT"], 'wget'))) {
        # page is cURL'd
        return True;

    } else {
        # page is being accessed from a web browser
        return False;
    }
}

function init_html() {
    if (!is_curlwget()) {
    ?>
<html lang="en">
<head>
    <title>TWTXT Registry</title>
</head>
<body>
<?php
    }
}

function end_html() {
    if (!is_curlwget()) {
    ?>
</body>
</html>
<?php
    }
}

function nl() {
    # function to define variable $nl (=new line), <br>\n for browsers, \n for cURL/CLI
    if (is_curlwget()) {
        # in case of curl/wget/cli
        return "\n";
    } else {
        # in case of web browser
        return "<br>\n";
    }
}

function ascii_logo() {
    $nl = nl();
    # print ascii logo only for cURL/Wget
    if (is_curlwget()) {
        echo " _____ _    _ _______   _______  ______           _     _              $nl";
        echo "|_   _| |  | |_   _\ \ / /_   _| | ___ \         (_)   | |             $nl";
        echo "  | | | |  | | | |  \ V /  | |   | |_/ /___  __ _ _ ___| |_ _ __ _   _ $nl";
        echo "  | | | |/\| | | |  /   \  | |   |    // _ \/ _` | / __| __| '__| | | |$nl";
        echo "  | | \  /\  / | | / /^\ \ | |   | |\ \  __/ (_| | \__ \ |_| |  | |_| |$nl";
        echo "  \_/  \/  \/  \_/ \/   \/ \_/   \_| \_\___|\__, |_|___/\__|_|   \__, |$nl";
        echo "                                             __/ |                __/ |$nl";
        echo "                                            |___/                |___/ $nl";
        echo "$nl";
    }
}

function ban() {
    $banned_ips = [
        '255.255.255.255', # example IP
        '0.0.0.0' # Another example IP, you won't encounter them as they are out of range (1->254)
    ];

    if (in_array($_SERVER['REMOTE_ADDR'], $banned_ips)) {
        # if client IP is a banned one, give him a 403 error
        http_response_code(403);
        die("Banned");
    }
}