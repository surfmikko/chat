<?php

require_once dirname(__FILE__) . "/../lib/common.php";
require_once dirname(__FILE__) . "/../lib/db/textfile.php";

$db = new DatabaseTextFile(getDatabaseDirectory());
$chatname = get_chatname();

if (!$db->exists()) {
    if ($chatname) {
        $db->setup();
        echo "Created new database: '$chatname'";
    } else {
        echo "Invalid parameters!";
        exit;
    }
}

$messageid = null;
if (isset($_REQUEST["messageid"])) {
        $messageid = $_REQUEST['messageid'];
}

$messages = $db->getLatestMessages($messageid);

$template = <<<EOT
<a href='#' id='{message_id}' class='message'>
{timestamp}<strong>{username}</strong></a><strong>:</strong> {text}
<div class='messageinfo' id='messageinfo_{message_id}'></div>
EOT;

foreach ($messages as $message) {
        $output = $template;
        foreach ($message as $key => $value) {
                $output = str_replace('{' . $key . '}', "$value", $output);
        }
        echo $output;
}

?>
