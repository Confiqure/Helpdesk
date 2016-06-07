Helpdesk
========

Helpdesk is a project created to be used as a collaborative tool where students and teachers post articles that anyone can view and benefit from. The primary purpose of this application is to provide technical assistance to those in need. When someone encounters a problem, they can pull up the forum and search for it either by text or by searching from tags in the appropriate category. Basic framework exists for this application, but there is much to be added.

This project began as an idea our school's media specialist had about bringing tech support right to the hands of each and every person in our school without having to schedule an appointment with our IT department. I created this framework for my Senior Project but unfortunately was not able to see the project through to the end due to time constraints. Much has been done here, but *much* more can be done to improve the overall functionality and usefulness of this application.

Features
--------
  * Database to store form posts and user accounts
  * Search posts by selecting tags
  * Sneak-previews presented with buttons to see more
  * Useful resources provided on the right-hand side of page
  * Paging system
  * User accounts and log-in system
  * `htaccess` file to redirect tag URLs

To-Do List
----------
  * General
    * Register page
    * Create an advanced searching algorithm to allow for text searches
  * Live support system
    * Create a way to sign up for and manage time-slots
    * Implement mechanism to initiate a chat session and text person on call
    * Design an anonymous chatting interface
  * User accounts
    * Interface to create posts
    * Create a profile page that keeps track of user statistics (links to their profiles on their posts)
    * Ability to edit posts they've authored
	* Design a hierarchy to differentiate students from moderators and administrators

Implementation
--------------
Making this project work is fairly straightforward. You must first copy all project files into the **base** directory of your site (otherwise `htaccess` will not work properly).

Next, locate the places in the source where `try` blocks have been implemented and specify an email to send error reports to. This will help you stay on top of bugs as soon as they happen!

Then, set up an SQL database and put all database credentials inside of `dbconfig.php` to ensure proper connection to data. Note that this file should be kept especially safe.

Finally, set up SQL database with the following commands:

```SQL
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
```

After you've followed these steps everything should be set up properly! The following section contains a few notes about understanding the less straightforward elements about the project.

Notes
-----

### Website

A large amount of code is renewed from page to page. This is why the `body.html` file exists. This file provides the basic skeleton of the website, where the individual pages control the meat of the page. The `body.html` file is never reached on its own, rather its code is reused from file to file.

### SQL

`articles`: `id` is an arbitrary string of 10 letters, `picture` is simply the URL of the image to display at the top of the article, `contents` can be any HTML formatted text, and `tags` should be a list of different keywords separated by spaces.

`live_support`: `phone` should be an email address associated with the phone to text (for example, a Verizon phone with number (555) 555-1234 would be formatted as 5555551234@vtext.com), `schedule` is how often the times repeat (day indicates daily, and a specific week day indicates repeating that day every week), `time_lower` is the time at which the person is first available formatted in military time as one number (for example, 2:30 PM becomes 1430), and `time_upper` is the time at which the person is no longer available formatted the same way as `time_lower`.

`users`: `token` is a random string assigned by the server when the user attempts to log in. This verifies their session and makes it impossible for anyone else to hijack the session.
