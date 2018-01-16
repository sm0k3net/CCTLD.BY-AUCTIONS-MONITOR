<?php
require_once '/var/www/html/cctldby/www/inc/db.php';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://auction.cctld.by/");
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.37');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec ($ch);
curl_close ($ch);

$find_date = preg_match("/.+состоится (.+?)\./", $output, $auctionData);
if($find_date) {
	$nextAuction = $auctionData[1];
} 

$compDates = array(
		"01" => "января",
		"02" => "февраля",
		"03" => "марта",
		"04" => "апреля",
		"05" => "мая",
		"06" => "июня",
		"07" => "июля",
		"08" => "августа",
		"09" => "сентября",
		"10" => "октября",
		"11" => "ноября",
		"12" => "декабря"
	);

$compareDate = preg_match("/по\s\d+\s(.+)/", $auctionData[1], $mmatch);
$findDay = preg_match("/по\s(\d{1,2})\s/", $auctionData[1], $dmatch);
$when = array_search($mmatch[1], $compDates);
$dayStart = ($dmatch[1]-2)."-".$when."-".date('Y');
$dayEnd = $dmatch[1]."-".$when."-".date('Y');

$checkIfScanExists = mysql_fetch_row(mysql_query("SELECT auction_start FROM auction_date WHERE auction_start = '$dayStart'"));

if($checkIfScanExists[0] != $dayStart) {
	$update_state = mysql_query("UPDATE auction_date SET auction_state = 'finished' WHERE auction_state <> 'finished'");
}

if($checkIfScanExists[0] != $dayStart) {
	$add_date = mysql_query("INSERT INTO auction_date (auction_start, auction_end) VALUES ('$dayStart', '$dayEnd')");
}
?>