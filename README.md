
# Description

The AdminRSS module creates RSS feeds for the administrative information
of a drupal website. These are protected with a key string that can be set at
the `admin/config/services/adminrss` page.

The resulting pages can then be fetched at:

- `adminrss/node/keystring`  - RSS feed for unapproved nodes
- `adminrss/comment/keystring` - RSS feed for unapproved comments
  
Since the key is transmitted often and in clear text, it should be complex and 
changed often.


# Installation

- copy the adminrss directory into the `modules/contrib` directory
- enable the `AdminRSS` module in Drupal
- go to `admin/config/services/adminrss` to set a keystring and the feed links
- configure your RSS reader to read the appropriate page


# Credit

- Originally created by:
    - James Blake (webgeer)
    - https://www.drupal.org/u/webgeer
    
- Drupal 5, 6, 7 and 8 versions by:
    - Frederic G. Marand (fgm / osinet)
    - http://blog.riff.org/

Thanks to Fredrik Jonsson and Gábor Hojtsy for their modules [adminblock] and
[commentrss] which were heavily used to create the original version of adminrss.

[adminblock]: https://www.drupal.org/project/adminblock
[commentrss]: https://www.drupal.org/project/commentrss
[oldwebgeerblog]: http://www.webgeer.com/James


# History

- 2016-09-17 Port for Drupal 8 (osinet)
- 2013-05-11 Port for Drupal 7 (osinet)
- 2010-09-11 Port for Drupal 6 (osinet)
    - New format for node feed: list nodes either unpublished OR under moderation
- 2007-01-16 Port for Drupal 5 (osinet),
    - New format for the comment feed.
    - Direct links to feeds added in settings.
    - Install/uninstall procedures
- 2006-01-30 Port for Drupal 4.7
- 2005-01-30 Initial development for Drupal 4.6
