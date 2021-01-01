Comment Syntax for DokuWiki
===========================

* enable 'C' style comment syntax ("`/*`" and "`*/`") in the wiki source text.
* text between "`~~`" and "`~~`" also become a comment when any special control macros syntax does not matched.
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

~~ This is a comment. Convenient when temporally disabling control macros eg. NOCACHE~~

```

* support HTML comment syntax: The HTML comment will not rendered by the browser, but can be viewed with “View source code” command.

```
<!-- This is a HTML comment -->
```


More infomation is available: http://www.dokuwiki.org/plugin:commentsyntax

----
Licensed under the GNU Public License (GPL) version 2

(c) 2014-2021 Satoshi Sahara \<sahara.satoshi@gmail.com>

