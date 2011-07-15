# System_Launcher #

System_Launcher is a simple opener of filenames and URLs, based on the
operating system's conveniences for that.

It could help other PEAR command-line tools, such as a mythical
`pear report-bug` command, which could open a web page with a
form, pre-filled with useful values (by just using the query-
string) when the user has entered for which PEAR package to
report a bug.

## Usage ##

    <?php
    require_once 'System/Launcher.php';

    $launcher = new System_Launcher;

    // open a file
    $launcher->launch('/data/docs/index.html', true);
    
    // or a URL
    $launcher->launch('http://pear.php.net', true);
    ?>

These operating system commands are run:

*   Windows:        [`start <filename>`](http://www.microsoft.com/resources/documentation/windows/xp/all/proddocs/en-us/start.mspx?mfr=true)
*   Linux
  * KDE:         [`kfmclient exec <filename>`](http://techbase.kde.org/Development/Tools/Using_kfmclient)
  * With Portland:    [`xdg-open <filename>`](http://portland.freedesktop.org/xdg-utils-1.0/xdg-open.html)
  * Gnome:       [`gnome-open <filename>`](http://embraceubuntu.com/2006/12/16/gnome-open-open-anything-from-the-command-line/)
*   Mac OS X:         [`open <filename>`](http://www.manpagez.com/man/1/open/osx-10.6.php)

## Credits

Originally written by cweiske, and now developed by olleolleolle.

