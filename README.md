Clover Picker
=============

A Self Hosted PHP viewer paired with the BASC-Archiver for archiving threads from 4chan.

This application is meant for personal use. It is recommended you do not use this for production.

Why
---

I wanted an easy to setup solution for personal use. There are a lot of larger community oriented projects that already serve the same purpose, but I wanted something smaller that would be right at home on a smaller server, meant for a user to just pick and choose threads as they come across them.

Features
--------

BASC Archiver takes any thread URL and downloads it to the filesystem.

Individual board views give links to a web render of the thread as it was, an images only view with a full size view (supports webms), a ZIP download link, and an update checker to see if the thread has an available update (with the ability to do so right from the view) or is closed.

Menu will update with new boards with a refresh of the site by copying the index, download, update, and images PHP pages into any new board folders.

All POST and GET inputs are either validated or scrubbed.

Install
-------

**Linux Only, though a properly built binary of the latest version of BASC Archiver and some slight modifications can make this work in Windows**

Setup the base install of your favorite web server, and PHP7.

Run the setup.py install script in the BASC-Archiver folder to get a working binary.

Make sure the httpd user is able to manipulate the filesystem within the webapp directory, and that you bump PHP's upload and memory limit for serving the zip files.

Note to people using any distro with SELinux; SELinux hates it when web servers make outbound queries. Proceed with caution. 

TODO
----

Make a close method for 404 cases.

Fix ZIP file serving.

Fix scaling for full size images.
