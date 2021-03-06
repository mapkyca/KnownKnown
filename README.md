Known -> Known crosspost
========================

This plugin links a user on one known site to a user on another known site, allowing you to cross post (most) content.

Primarily this was written as a test/proof of concept for my OAuth2 Server <https://github.com/mapkyca/KnownOAuth2>, but might actually be useful to some people - for example, 
if you have a corporate known blog and want to post to it from your personal blog.

Even though it was originally written as an OAuth2 tester, it also supports Known's native signed HTTP api authentication method.

Usage
-----

* Install in your plugins
* Create your application on the server you want to post to
* Enter those details into the account on the server you want to post from
* Go through your standard oauth linking

Supports
--------

* [x] Status posts
* [x] Text posts
* [x] Image posts
* [x] Location posts
* [x] Bookmarks
* [x] Checkins
* [x] Events
* [x] Audio

See
---
 * Author: Marcus Povey <http://www.marcus-povey.co.uk> 
 * OAuth2 Spec <https://tools.ietf.org/html/rfc6749>
 * My OAuth2 server <https://github.com/mapkyca/KnownOAuth2>
