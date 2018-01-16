# CCTLD.BY AUCTIONS MONITOR
#### PHP(5) + MySQL + Python(3)
Domains checker for auctions.cctld.by service (beta)

# What this service can do?
<pre>
- Detect correct date of the auctions
- Grap all the available domains
- Count domains & types
- Check them for yandex and alexa ranks
- Create TXT formated file with all the data inside
</pre>

## What need to fix
<pre>
1. In /scripts/domains.py update database credentials
2. In /inc/db.php update database credentials
3. In /inc/twitter/autoposter.php update credentials with your twitter API (if you want post updated into twitter)
</pre>

## Install
<pre>
1. Upload all the stuff
2. Check paths in all files
3. Create database and import SQL script into database
4. Set up tasks in cron for /scripts/auctions.php and /scripts/domains.py

"auctions.php" - works for actual auctions date detection and generating of new tasks for domains.py
"domains.py" - extracts actual domains list from auctions.cctld.by and stores everything into database, when all is done it also creates text file with date in the name and list of domains inside (in /files/ folder).
</pre>

### In plans
- Add domains monitoring with alerting system
- Check for blacklists


#cctldby #cctld.by #домены #мониторинг
