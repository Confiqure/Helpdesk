Helpdesk
========

Helpdesk is a project created to be used as a collaborative tool where students and teachers post articles and anyone can view them. The primary purpose of this application is to provide technical assistance to those in need. When someone encounters a problem, they can pull up the forum and search for it either by text or by tags in the appropriate category. Basic framework exists for this application, but there is much to be added.

Features
--------
  * Database to store form posts and user accounts
  * Search posts by selecting tags
  * Useful resources provided on the right-hand side of page
  * Paging system
  * User accounts and log-in system
  * `htaccess` file to redirect tag URLs

To-do list
----------
  * Live support system
    * Create a way to sign up for time-slots
    * Implement mechanism to text person on call
    * Design an anonymous chatting interface
  * User accounts
    * Create a profile page that keeps track of user stats (links to their profiles on their posts)
    * Ability to edit posts they've authored
	* Design a hierarchy to differentiate students from moderators and admins

Implementation
--------------
Making this source work is fairly straightforward. You must copy all files into the base directory of your URL (otherwise `htaccess` will not work). Set up an SQL database and put all credentials inside of `dbconfig.php` to ensure proper connection to data. Then, set up SQL database with the following tables:

    CREATE TABLE IF NOT EXISTS `articles` (
      `id` varchar(10) NOT NULL,
      `title` varchar(64) NOT NULL,
      `author` varchar(32) NOT NULL,
      `picture` varchar(256) NOT NULL,
      `contents` varchar(4096) NOT NULL,
      `tags` varchar(128) NOT NULL,
      `timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1;

    CREATE TABLE IF NOT EXISTS `live_support` (
      `name` varchar(32) NOT NULL,
      `phone` varchar(32) NOT NULL,
      `schedule` varchar(16) NOT NULL,
      `time_lower` int(4) NOT NULL,
      `time_upper` int(4) NOT NULL
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1;

    CREATE TABLE IF NOT EXISTS `users` (
      `username` varchar(16) NOT NULL,
      `password` varchar(16) NOT NULL,
      `name` varchar(64) NOT NULL,
      `email` varchar(64) NOT NULL,
      `status` varchar(16) NOT NULL DEFAULT 'Student',
      `token` varchar(10) NOT NULL
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1;
