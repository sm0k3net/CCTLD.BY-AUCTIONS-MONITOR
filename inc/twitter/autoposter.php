<?php
require_once 'twitterapi.php';

//Post to Twitter
\Codebird\Codebird::setConsumerKey("API KEY", "SECRET KEY");
$cb = \Codebird\Codebird::getInstance();
$cb->setToken("TOKEN", "SECRET KEY");
$params = array(
'status' => 'Доступен свежий #список #доменов с #аукциона #cctldby!'
 );
$reply = $cb->statuses_update($params);
?>