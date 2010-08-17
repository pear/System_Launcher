# File_Launcher #

File_Launcher is a simple opener of filenames and URLs.

It could help other PEAR command-line tools.

Original author: cweiske

Maintainer: olleolleolle

## Usage ##

    <?php
    require_once 'File/Launcher.php';
    File_Launcher::launchBackground('/data/docs/index.html');
    ?>

These commands are run:

*   Windows:        `start <filename>`
*   Linux
  * KDE:         `kfmclient exec <filename>`
  * With Portland:    `xdg-open <filename>`
  * Gnome:       `gnome-open <filename>`
*   Mac OS X:         `open <filename>`
