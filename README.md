README
======
Dokuwiki plugin to draw organization charts; the plug-in is present in the Dokuwiki tools collection.

Generates charts using the applet orgapp (http://www.eiroca.net/orgapp/).

Syntax:
<orgapp attribute="value" attribute="value" ...>
 chart definition
</orgapp>

The chart can be defined either directly in the Wiki page or in an external file. In the first case is sufficient to include the definition within the tag orgapp, in the second case you should use the attribute url to define the URL of the definition.

Complete documentation here: http://www.eiroca.net/doku_orgapp