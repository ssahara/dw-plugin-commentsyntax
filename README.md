Comment Syntax for DokuWiki
===========================

* enable 'C' style comment syntax ("`/*`" and "`*/`") in the wiki source text.
* comment syntax has **priority** to `Doku_Parser_Mode_listblock`
* support toolbar icon in the Edit window for encomment/uncomment selected source block.
* (Optional) recognize correctly **nested 'C' style comments**, enclosed outmost pair of "`/*`" and "`*/`" become a comment.
* (Optional) **One-line style comment** syntax "`//`" is available.


```
/* This is a comment */

/* this is 
a multi-line comment */

/*
 * This is a comment, too.  // Here is one-line comment
 */

/* There is a comment /* in a comment */
(nested comment)
*/

~~ This is a comment. Convenient when temporally disabling macro eg. NOCACHE~~

```

More infomation is available: http://www.dokuwiki.org/plugin:commentsyntax

----
Licensed under the GNU Public License (GPL) version 2

(c) 2014 Satoshi Sahara \<sahara.satoshi@gmail.com>

