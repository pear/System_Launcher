# System_Launcher #

System_Launcher is a simple opener of filenames and URLs.

It could help other PEAR command-line tools, such as a mythical
`pear report-bug` command, which could open a web page with a
form, pre-filled with useful values (by just using the query-
string) when the user has entered for which PEAR package to
report a bug.

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