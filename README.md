#Another of Many Simple Web Dashboards

Even worse, it's in PHP!

It was just supposed to be a way to monitor les.net account balance, but then I thought I may as well monitor server load, and then I thought I should make it easy to add more widgets.

It's very simple, cute, responsive, and simply cutely responsive. It probably won't look good in older browsers. Only tested in Firefox (latest stable).

##Installation

Just needs php (version 5 or 7), and the `curl` extension.

Put it in a web-accessible directory. Move `config.sample.php` to `config.php` and edit it. Make sure your permissions are `700` or so, at least for your config since it has api keys and stuff in it.
