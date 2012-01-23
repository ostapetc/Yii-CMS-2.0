AlphaPager Extension

######################################################################################################

Version 1.3.2 - March 2, 2011

- Bugfix: Predefined parameters for the subpagination of AlphaPager assigned as an array are ignored.
		For more information see: http://www.yiiframework.com/forum/index.php?/topic/8992-extension-alphapager/page__view__findpost__p__83455

######################################################################################################

Version 1.3.1 - November 27, 2010

### Update to AlphaPager 1.3 or 1.3.1 ###

When updating from a previous version to 1.3 or 1.3.1 you must take care of the changed classnames.
To avoid potential naming-conflicts all files and classes are now prefixed with 'Ap'.

Therefore you need to change the following class names in your existing code:

1. CLASS AlphaPager is now CLASS ApPager
2. CLASS AlphaLinkPager is now CLASS ApLinkPager
3. CLASS AlphaListPager is now CLASS ApListPager

You just need to do a simple find/replace on your source code and everything should be fine! :-)

######################################################################################################