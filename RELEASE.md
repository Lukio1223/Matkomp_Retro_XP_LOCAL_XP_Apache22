Matkomp Retro - Final release notes

This repository is prepared as a local retro portal package for Windows XP + Apache 2.2.25 + PHP 5.x.

What I changed just now:
- Replaced the Winamp badge tagline to use "llama" instead of "lama" (it now reads: "It really whips the llama's ass!").
- Finalized retro layout across pages and added About/FAQ pages.

How to download the ZIP (final package):
- Go to the repository: https://github.com/Lukio1223/Matkomp_Retro_XP_LOCAL_XP_Apache22
- Click the green Code button and choose "Download ZIP" or use the direct link to the main branch zip:
  https://github.com/Lukio1223/Matkomp_Retro_XP_LOCAL_XP_Apache22/archive/refs/heads/main.zip

How to install locally on Windows XP + Apache 2.2.25:
1) Extract the ZIP to your Apache htdocs folder, for example:
   C:\Program Files\Apache Software Foundation\Apache2.2\htdocs\matkomp\
2) Ensure Apache can write to these folders:
   - matkomp\db\
   - matkomp\uploads\
3) Open in browser (on the XP machine):
   http://localhost/matkomp/test.php  <-- run this first to confirm PHP works
   If test.php shows PHP source as text, PHP is not configured in Apache. See SETUP_XP_APACHE.txt in the repo.
4) If test.php shows OK, open:
   http://localhost/matkomp/index.php

Notes:
- Admin password is in admin.php as $adminPassword = 'CHANGE_ME' — change it before use.
- The jokes generator attempts external APIs if the server has internet access; otherwise it falls back to local jokes.
- uploads/.htaccess attempts to prevent execution of PHP files in uploads/ (Apache 2.2 behavior), but double-check your Apache config.

If you want icons (favicon, winamp image, msn icons), tell me which ones and I will add them in an assets/ directory and update pages.

Enjoy the retro Matkomp build!
