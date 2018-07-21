Clover Picker
=============

A Self Hosted PHP viewer paired with the BASC-Archiver for archiving threads from 4chan.

This application is meant for personal use. It is recommended you do not use this for production.

Why
---

I wanted an easy to setup solution for personal use. There are a lot of larger community oriented projects that already serve the same purpose, but I wanted something smaller that would be right at home on a smaller server, meant for a user to just pick and choose threads as they come across them.

Features
--------

Web UI made using frames like the classic 2ch website.

BASC Archiver takes any thread URL and downloads it to the filesystem.

Individual board views give links to a web render of the thread as it was, an images only view with a full size view (supports webms), a ZIP download link, and an update checker to see if the thread has an available update (with the ability to do so right from the view) or is closed.

Menu will update with new boards with a refresh of the site.

Install
-------

**Linux Only, though a properly built binary of the latest version and some slight modifications can make this work in Windows**

Setup the base install of your favorite web server, and PHP7.

Run the setup.py install script in the BASC-Archiver folder to get a working binary.

Make sure the binary is available and executable by all users, and that the httpd user is able to manipulate the filesystem within the webapp directory.

_If you have SELinux enforcing, it WILL catch PHP's attempts to exec the binary, connections to 4chan, and filesystem manipulation. In my testing on CentOS7, I found it easier just to disable SELinux. Do not run this application on a public facing web server unless you know what you're doing._

TODO
----

Setup the update checker + Create an Update All function.

Make it less ugly.

Make an about page, link to 4chan.
