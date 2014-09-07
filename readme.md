# nginx selective cache purge


This is configured based on the following nginx configuration options:

- `fastcgi_cache_key` should be  **"$scheme://$host$request_uri";**
- in `fastcgi_cache_path` levels be  **1:2**

---

*nginx-purge-plugin.php* is a WordPress plugin

*purge.php* receives the request to purge a particular cache

*purge-sample.conf* is a sample nginx conf for where purge.php might reside

---

wish list // to do list

- purge archive caches as needed
- more magic?

