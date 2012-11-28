SlickMap CSS
Version 1.1
2009-07-010

Created by Matt Everson of Astuteo, LLC
http://astuteo.com/slickmap

============================================================================

Thanks for downloading SlickMap CSS. Enclosed in this bundle you will find
an example HTML file, slickmap.css, and a number of lightweight images.

For the sake of optimal performance, SlickMap relies heavily on CSS pseudo
classes and elements. The default styles also include a few CSS3 specific
elements (rounded corners, RGBA colors) which you are free to modify, expand
upon, or eliminate at will. 

SlickMap CSS was created for web designers, and such was tested and developed
for use with Safari, Firefox, Opera, and other standards-compliant browsers. 
Because of that, current versions of Internet Explorer (and probably IE 
versions long into the future) might look like sh*t. And I don't really careâ 
though you're welcome to suggest improvements in that arena. 

SlickMap CSS is free of charge, free to share, and free to modify. It
includes a snippet of Eric Meyer's browser reset stylesheet: 

http://meyerweb.com/eric/tools/css/reset/

============================================================================

HOW TO USE:

1) Create an HTML file with an unordered list of links. SlickMap was
   designed to style actual linked navigation, not simply lists, so make
   sure to include anchor tags. See index.html for the correct formatting.

2) Apply slickmap.css as you would any other stylesheet, using it for both 
   "screen" and "print" media as seen here:

   <link rel="stylesheet" type="text/css" media="screen,print" href="slickmap.css" />

3) Within your HTML file, the link to your home page should be at the top 
   of the unordered list and have the id of #home. This is required to pull
   the home page link out above the rest of the site tree.

4) The SlickMap default is 4 columns. In order to change the number of 
   columns, you simply need to change the class of the PrimaryNav unordered 
   list (col4, col5, etc.) SlickMap CSS will accomodate 1 to 10 columns,
   some much better than others.

   NOTE: Due to Internet Explorer's difficulty in rounding numbers, you may
   find the farthest right column drops down instead of appearing in line.
   If need be, you can resolve this issue by adjusting the CSS to use a 
   slightly smaller percentage than what you really need, i.e. (pun intended)
   24.9% instead of 25%.

5) Depending on how you use these files, you may need to correct the image
   paths within the CSS file.

============================================================================

