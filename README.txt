$Id$

Description
-----------

The AdminRSS module creates RSS feeds for the administrative information for drupal website.
These are protected with a key that can be set in admin/settings/adminrss page.

The resulting pages can then be read at:
  adminrss/node/keystring  - RSS feed for unapproved nodes
  adminrss/comment/keystring - RSS feed for unapproved comments
  
  


Installation
------------

1) copy the adminrss directory into the modules directory

2) enable the 'gmap module' in drupal

3) edit admin/settings/adminrss to set a keystring

4) configure your rss reader to read the appropriate page



To do
-----

- Add a feed for the watchdog notices

Credit
------

Written by:
James Blake
http://www.webgeer.com/James

Thanks to Fredrik Jonsson and Gabor Hojtsy for their modules adminblock and
commentrss which were heavily used to

History
-------

2005-01-30
 - initial development

