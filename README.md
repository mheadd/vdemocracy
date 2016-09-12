# Vocal Democracy

Vocal Democracy is a project that is focused on the development of a phone-based voting system to be used in elections to assist voters with disabilities, visual impairment or other challenges in traveling to polling places. 

Note - this is a very old project.  More [details here](https://voiceingov.org/2006/10/17/vocal-democracy/). Moving it to Github for archival purposes.

## Requirements

To use Vocal Democracy, you will need the following:

* A VoiceXML platform.  Vocal Democracy was built to run on the Voxeo Prophecy platform (http://www.voxeo.com/prophecy/), but it can easily be modified to run on other platforms.

* A web server running PHP 5.x

* A database that is compatible with the ADOdb database abstraction library for PHP (http://phplens.com/adodb/supported.databases.html).

## Installation / Configuration

* Clone this repo

* Download and install the ADOdb library in the "adodb" subdirectory.

* Set up your database tables.  Execute the SQL script located in the "SQL" subdirectory.  When complete, you can delete the SQL directory and its contents.

* Open and review the file named "config.php".  This file contains application level settings for database access, and many other features.  Changing the value of $check_host and $host will control access to the PHP components of Vocal Democracy.  If you set $check_host to 'true' then the value of $host must be the IP address of your VoiceXML platform.

* Open and review the file name "app-root.vxml".  This file contains settings that control the VoiceXML portion of the application.  

Note, the variable "voteConfirm" determines if a caller's vote is repeated back to them for confirmation.  Ordinarily, this should always be set to true.  However, a bug in the Prophecy software causes issues when boolean fields are used in some instances (a boolean field is used to confirm the caller's vote).  Setting this value to false will bypass the voter confirmation until this issue is addressed in the next update of Prophecy.

## Making a call

* Set up a user in the "voters" table.  (Note: the value of ID in the voters table is the MD5 hash of a 9 digit identification number that is selected for each voter.)

* Set up your call routing in Prophecy to point to the "login.vxml" file.

* Place your call and submit your vote.
