# File_Launcher #

File_Launcher is a simple opener of filenames and URLs.

It could help other PEAR command-line tools.

Original author: cweiske

Maintainer: olleolleolle

## Usage ##

    <?php
    require_once 'File/Launcher.php';
    // open a file
    File_Launcher::launchBackground('/data/docs/index.html');
    // or a URL
    File_Launcher::launchBackground('http://pear.php.net');
    ?>

These commands are run:

*   Windows:        `start <filename>`
*   Linux
  * KDE:         `kfmclient exec <filename>`
  * With Portland:    `xdg-open <filename>`
  * Gnome:       `gnome-open <filename>`
*   Mac OS X:         `open <filename>`

# TODO

Use exceptions instead of triggering errors.

Rename to System_Launcher.

Avoid doing work in the constructor (it makes unit testing harder).

Split different kinds of OS into driver type classes.

Detect GNOME-ness using `$GNOME_DESKTOP_SESSION_ID`