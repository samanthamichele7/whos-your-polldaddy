# Who's Your Polldaddy?

Simple PHP API wrapper class to display the latest poll from a Polldaddy account if you're lazy (or don't have consistent access to the backend)
and can't / don't feel like manually updating your code after you create every poll.  This widget should work on any PHP site as long as **allow_url_fopen** is 
on in your php.ini.

No cURL required!

Originally developed for [Rare](http://rare.us) and [Cox Media Group](http://www.coxmediagroup.com/).

* **Version**: 1.0
* **Contributing**: Contributions (along with bug reports) are more than welcome. Please submit a pull request against the master branch.

## Getting started

You will need to [register for a Polldaddy account and request an API key](http://polldaddy.com/register/). Once you have an API key and at least one
poll created, it's very easy to plug the widget into your site:

```php
<?php
    require_once('WYPD.class.php');

	$WYPD = new WhosYourPolldaddy('YOUR_API_KEY'); ?>

	<script type="text/javascript" charset="utf-8" src="http://static.polldaddy.com/p/<?php echo $WYPD->getLatestPoll(); ?>.js"></script>
?>
```
The widget will automatically find the ID of your latest poll and display it accordingly.

If you want to expand this wrapper to do more cool shit, you can check out the [Polldaddy API Docs](http://support.polldaddy.com/api/) for all the available methods.  Pull requests welcome!

## Credits

Copyright (c) 2014 by Samantha Geitz
Released under the [MIT License](http://opensource.org/licenses/MIT).