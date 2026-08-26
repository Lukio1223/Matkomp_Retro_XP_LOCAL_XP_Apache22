Matkomp Retro XP - Local package
--------------------------------

1) Kako uporabljati:
- Razširite vse datoteke v vaš Apache htdocs direktorij, npr.:
  C:\Program Files\Apache Software Foundation\Apache2.2\htdocs\matkomp\

2) Preverite, da so naslednji direktoriji prisotni in imajo pravice:
- db/ (lahko shrani podatkovne .txt datoteke)
- uploads/ (za naložene datoteke)

3) Odprite v brskalniku:
- http://localhost/matkomp/test.php  <- za hitro diagnostiko PHP/Apache
- http://localhost/matkomp/index.php <- glavni portal

4) Sprememba admin gesla:
- Odprite inc/common.php in admin.php, poiščite $adminPassword = 'CHANGE_ME'; in ga spremenite.

5) Varovanje uploadov:
- V uploads/ je .htaccess, ki preprečuje izvajanje PHP datotek (Apache 2.2 podpora).

6) Če PHP ne dela:
- Poglejte SETUP_XP_APACHE.txt za korake kako povezati PHP z Apache 2.2.

7) Licence / opombe:
- Namenjeno izključno lokalni uporabi.
