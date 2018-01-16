<?php require_once 'inc/db.php'; 

$auctionDatePast = mysql_fetch_row(mysql_query("SELECT * FROM auction_date WHERE auction_state = 'finished' ORDER BY id desc LIMIT 1"));
$auctionDateNext = mysql_fetch_row(mysql_query("SELECT * FROM auction_date WHERE auction_state <> 'finished' ORDER BY id desc LIMIT 1"));
$find_all_domains_past = mysql_fetch_row(mysql_query("SELECT COUNT(domain) FROM domains_list WHERE auction_date = '$auctionDatePast[1]' OR auction_date = '$auctionDatePast[2]'"));
$find_all_domains_next = mysql_fetch_row(mysql_query("SELECT COUNT(domain) FROM domains_list WHERE auction_date = '$auctionDateNext[1]' OR auction_date = '$auctionDateNext[2]'"));
//$domainsCount = mysql_fetch_row($find_all_domains);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://auction.cctld.by/");
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.37');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
curl_close ($ch);
$find_date = preg_match("/.+состоится (.+?)\./", $output, $auctionData);
if($find_date) {
	$nextAuction = $auctionData[1];
} else {
	echo "Дата не определена";
}



 if(strtotime(date('d-m-Y')) == strtotime($auctionDateNext[1]) || strtotime(date('d-m-Y')) == strtotime($auctionDateNext[2]) || strtotime((date('d')+2).date('-m-Y')) > strtotime($auctionDateNext[2])) {
	$ticDomains = mysql_fetch_row(mysql_query("SELECT COUNT(domain) FROM domains_list WHERE tic > '0' AND auction_date = '$auctionDateNext[1]'"));
	$alexaDomains = mysql_fetch_row(mysql_query("SELECT COUNT(domain) FROM domains_list WHERE alexa > '0' AND auction_date = '$auctionDateNext[1]'"));
	$domainsCount = $find_all_domains_next[0];

		$getAllDomains = mysql_query("SELECT domain FROM domains_list WHERE auction_date BETWEEN '$auctionDateNext[1]' AND '$auctionDateNext[2]'");
	while($domains_row = mysql_fetch_array($getAllDomains)) {
		$domains[] = $domains_row['domain'];
	}

	foreach($domains as $item) {
		$getZone = explode(".", $item);
		if($getZone[1] == "by") {
			$domainsBy[] .= $getZone[1];
		} elseif($getZone[1] == "бел") {
			$domainsBel[] .= $getZone[1];
		}
	}

	$findListDates = mysql_fetch_row(mysql_query("SELECT * FROM auction_date WHERE auction_state <> 'finished' ORDER BY id desc LIMIT 1"));
	$get_domains_list = scandir('/var/www/html/cctldby/www/files/');
	foreach($get_domains_list as $list) {
		$actual = "domains_".$findListDates[1]."-".$findListDates[2].".txt";
		if($list == $actual) {
			$getList = "//".$_SERVER['SERVER_NAME']."/files/".$list;
		}
	}

	$auctionState = "(новый аукцион)";
} else {
	$tillNextAuction = date("d-m-Y", strtotime($auctionDatePast[1]));
	$ticDomains = mysql_fetch_row(mysql_query("SELECT COUNT(domain) FROM domains_list WHERE tic > '0' AND auction_date = '$auctionDatePast[2]'"));
	$alexaDomains = mysql_fetch_row(mysql_query("SELECT COUNT(domain) FROM domains_list WHERE alexa > '0' AND auction_date = '$auctionDateNext[1]'"));
	$domainsCount = $find_all_domains_past[0];

	$getAllDomains = mysql_query("SELECT domain FROM domains_list WHERE auction_date = '$auctionDatePast[2]'");
	while($domains_row = mysql_fetch_array($getAllDomains)) {
		$domains[] = $domains_row['domain'];
	}

	foreach($domains as $item) {
		$getZone = explode(".", $item);
		if($getZone[1] == "by") {
			$domainsBy[] .= $getZone[1];
		} elseif($getZone[1] == "бел") {
			$domainsBel[] .= $getZone[1];
		}
	}

	$findListDates = mysql_fetch_row(mysql_query("SELECT * FROM auction_date WHERE auction_state = 'finished' ORDER BY id desc LIMIT 1"));
	$get_domains_list = scandir('/var/www/html/cctldby/www/files/');
	foreach($get_domains_list as $list) {
		$actual = "domains_".$findListDates[1]."-".$findListDates[2].".txt";
		if($list == $actual) {
			$getList = "//".$_SERVER['SERVER_NAME']."/files/".$list;
		}
	}

	$auctionState = "(прошедший аукцион)";
}



?>
<!DOCTYPE html>
<html lang="en">
 <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1.0">
 	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
 	<link href='assets/css/font-awesome.min.css' rel='stylesheet'/>
 	<meta name="keywords" content="cctld.by, #cctldby, аукцион, доменов, .BY, .БЕЛ, доменные имена беларусь">
 	<meta name="description" content="Информационная страница бота аукционов Белорусских доменов .BY и .БЕЛ - CCTLD.BY BOT">
 	<link rel="icon" type="image/png" href="assets/favicon.png" />
 	<meta name="yandex-verification" content="8843232b996a984c" />
 	<title>CCTLD.BY [BOT]: Информационная страничка аукционов</title>
 	<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter44120724 = new Ya.Metrika({
                    id:44120724,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/44120724" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
 </head>
 <body>
 <div class="container">
 <div class="col-lg-12"><h3>Вся информациях о доменах .BY и .БЕЛ для аукционов доменов <a href="//auction.cctld.by" target=_blank rel="nofollow">auction.CCTLD.BY</a></h3><hr /></div>
 	<div class="row">
 		<div class="col-lg-8">
 		<h3>Топ 10 доменов с самым высоким тИЦ</h3>
 		<p>
 		<?php $TopTicDomains = mysql_query("SELECT * FROM domains_list WHERE tic > '20' AND auction_date = '$auctionDateNext[1]' ORDER BY tic DESC LIMIT 10");
 		while($TopTicRow = mysql_fetch_array($TopTicDomains)) {
 			if($TopTicRow['yaca'] == '[]') { $topYaca = 'В каталогах / категориях нет'; } else { $topYaca = $TopTicRow['yaca']; }
 			if($TopTicRow['dmoz'] == 'false') { $topDmoz = 'В каталогах / категориях нет'; } else { $topDmoz = "В DMOZ есть"; }
 			$topTicData .= "<li><b>Домен:</b> ".$topTicDomain = $TopTicRow['domain']." - <b>тИЦ:</b> ".$topTicStat = $TopTicRow['tic']." - <b>YACA:</b> ".$topYaca." - <b>DMOZ:</b> ".$topDmoz."</li>";
 		}
 		echo $topTicData; ?>
 		</p>

 		<h3>Топ 10 доменов с самой высокой Alexa</h3>
 		<p>
 		<?php $aTopTicDomains = mysql_query("SELECT * FROM domains_list WHERE alexa <> '0' AND auction_date = '$auctionDateNext[1]' ORDER BY alexa ASC LIMIT 10");
 		while($aTopTicRow = mysql_fetch_array($aTopTicDomains)) {
 			if($aTopTicRow['yaca'] == '[]') { $atopYaca = 'В каталогах / категориях нет'; } else { $atopYaca = $aTopTicRow['yaca']; }
 			if($aTopTicRow['dmoz'] == 'false') { $atopDmoz = 'В каталогах / категориях нет'; } else { $atopDmoz = "В DMOZ есть"; }
 			$atopTicData .= "<li><b>Домен:</b> ".$atopTicDomain = $aTopTicRow['domain']." - <b>Alexa:</b> ".$atopTicStat = $aTopTicRow['alexa']." - <b>DMOZ:</b> ".$atopDmoz."</li>";
 		}
 		echo $atopTicData; ?>
 		</p>

 		</div>
 		
 		<div class="col-lg-4">
 			 <div class="panel panel-info">
            <div class="panel-heading">
              <div class="row">
                <div class="col-xs-3">
                 <i class="fa fa-at" style="font-size:5em;"></i>
                </div>
                <div class="col-xs-9 text-right">
                 <div class="huge">Всего доменов</div>
                  <div><?php echo $domainsCount; ?></div>
                  <div><?php echo $auctionState; ?></div>
                  </div>
                 </div>
                </div>
                <a href="<?php echo $getList; ?>" target=_blank>
                <div class="panel-footer">
                 <span class="pull-left">Получить полный список</span>
                 <span class="pull-right"><i class="fa fa-cloud-download"></i></span>
                 <div class="clearfix"></div>
                </div>
                </a>
            </div>
            		<div class="panel panel-primary">
		<div class="panel-heading"><h3 class="panel-title">Полезная информация</h3></div>
		<div class="panel-body">
			<ul class="list-group">
				<li class="list-group-item"><b>Доменов с тИЦ:</b> <?php echo $ticDomains[0]; ?></li>
				<li class="list-group-item"><b>Доменов с Alexa:</b> <?php echo $alexaDomains[0]; ?></li>
				<li class="list-group-item"><b>Доменов BY:</b> <?php echo count($domainsBy); ?>, <b>БЕЛ:</b> <?php echo count($domainsBel); ?></li>
				<li class="list-group-item"><b>Следующий аукцион:</b> <?php echo $nextAuction; ?></li>
				<li class="list-group-item"><a href='about.php'>Об аукционах</a></li>
				<li class="list-group-item"><a href='download/lookup.py' target=_blank>WHOIS доменов BY/БЕЛ/GENERIC</a></li>
				<li class="list-group-item"><a href="http://pr-cy.ru/" target=_blank rel="nofollow">Проверить домены на тИЦ и каталоги</a></li>
				<li class="list-group-item"><a href="http://pr-cy.ru/mass_domain/" target=_blank rel="nofollow">Массовая проверка доменов</a></li>
				<li class="list-group-item"><a href="https://seolik.ru/check-sanctions-yandex" target=_blank rel="nofollow">Проверка на АГС и фильтр</a></li>
				<li class="list-group-item"><a href="https://web-beta.archive.org/" target=_blank rel="nofollow">Веб-архив</a></li>
			</ul> 			
 			<a href="https://twitter.com/cctldby" class="twitter-follow-button" data-show-count="false">Следите за новостями @cctldby</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
 			<a class="twitter-timeline" data-width="400" data-height="200" href="https://twitter.com/cctldby" rel="nofollow">Последние твиты</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
 		</div>
 		</div>

 		</div>
 	</div>
 </div>
 <hr />
 <p><center>&copy; <a href="">CCTLD.BY [BOT]</a>, 2017 - <?php echo date('Y'); ?> | Работает на честном слове и с божьей помощью</center></p>
 </body>
 </html>