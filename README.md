[![Build Status](https://travis-ci.org/leeyc0/dokuwiki_plugin_canonicalchinese.svg?branch=master)](https://travis-ci.org/leeyc0/dokuwiki_plugin_canonicalchinese) [![codecov](https://codecov.io/gh/leeyc0/dokuwiki_plugin_canonicalchinese/branch/master/graph/badge.svg)](https://codecov.io/gh/leeyc0/dokuwiki_plugin_canonicalchinese)


# TL;DR
You don't need this dokuwiki plugin.

# Long description
This dokuwiki plugin is developed to do Chinese character replacement to its "canonical" form, to meet specific requirements of Chinese linguistics. The exact replacement is defined in the dictionary table. I recap, you don't need this dokuwiki plugin. As such I will not publish this plugin to dokuwiki plugin repository.

# Extra syntax
To override automatic character replacement, wrap the character with <nochinesecanonical></nochinesecanonical> tags. The tag is a crude hack and prone to bugs, wrap the actual character not to be replaced only.

Example:
&lt;nochinesecanonical&gt;真&lt;/nochinesecanonical&gt;真

The first 真 will not be replaced while the second 真 will be replaced with 眞
