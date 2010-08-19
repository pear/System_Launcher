# System_Launcher #

System_Launcher is a simple opener of filenames and URLs.

It could help other PEAR command-line tools.

Original author: cweiske

Maintainer: olleolleolle

## Usage ##

    <?php
    require_once 'System/Launcher.php';
    // open a file
    System_Launcher::launchBackground('/data/docs/index.html');
    // or a URL
    System_Launcher::launchBackground('http://pear.php.net');
    ?>

These commands are run:

*   Windows:        `start <filename>`
*   Linux
  * KDE:         `kfmclient exec <filename>`
  * With Portland:    `xdg-open <filename>`
  * Gnome:       `gnome-open <filename>`
*   Mac OS X:         `open <filename>`

# TODO

(the empty list)