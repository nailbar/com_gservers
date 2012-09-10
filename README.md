com_gservers
============

Joomla! 2.5 component


The GServers Joomla! component is hard coded to look for the file:

http://the.website.liek/api/gservers_json.php

Then you can change the "require_once" statement to load the config file
from elsewhere since it's safer if the database login information is not
accessible through a GET request, even if it is inside a parsed PHP-script.
