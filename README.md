# Mock.Server

A mock server for testing.

## Features

## Server

### vhost.conf

```
server {
    listen 80;
    root /data1/www/htdocs/mock/;
    server_name mock.com;

    access_log /data1/www/logs/mock-access_log main;
    error_log /data1/www/logs/mock-error_log;

    rewrite "^/(.*)" /index.php/$1;

    location ~* "^/(favicon\.ico|crossdomain\.xml|robots\.txt)$|\.(?:html|js|css|png|jpg|gif|cur)$" {
        if ( $uri ~* "^/favicon\.ico" ) {
            expires 30d;
        }

        root /data1/www/htdocs/mock/;
    }

    location  / {
        fastcgi_intercept_errors on;
        error_page 404 500 502 503 504 /about;

        set $script_uri "";
        if ( $request_uri ~* "([^?]*)?" ) {
            set $script_uri $1;
        }

        fastcgi_pass 127.0.0.1:9093;
        fastcgi_param SCRIPT_URL $script_uri;
        fastcgi_param REQUEST_ID $request_uid;
        include fastcgi/comm_fastcgi_params;
    }
}
```

### fpm.conf

```
[mock]
user = www
group = www
listen = 127.0.0.1:9093
listen.allowed_clients = 127.0.0.1
pm = dynamic
pm.max_children = 300
pm.start_servers = 1
pm.min_spare_servers = 1
pm.max_spare_servers = 1
pm.max_requests = 2000

slowlog = /data1/www/logs/$pool-slow_log
request_slowlog_timeout = 20
request_terminate_timeout = 30

```

### daemons

```bash
# start timer
php /data1/www/htdocs/mock/vendor/got/stark/src/Stark/run.php -f /data1/www/htdocs/mock/vendor/got/tarth/scripts/timer.ini

# start callback processor
php /data1/www/htdocs/mock/vendor/got/stark/src/Stark/run.php -f /data1/www/htdocs/mock/vendor/got/tarth/scripts/processor.ini

```

## API

### Create

```
POST http://mock.com/mock/create
@title mock_title
@content mock_script
```

```
curl -X POST -H "Content-Type: application/x-www-form-urlencoded" -d 'title=mock&content={"_MOCK_":[{"function": "redirect", "url": "http://sample.weibo.com?rid=@natural()&pid=@request('pid', '0')","ms": "@int(100, 500)"}]}' "http://mock.com/mock/create"
```

### Mock

```
GET http://mock.weibo.com/mock/[mock_id]?x=xxx
```

### List

```
GET http://mock.weibo.com/mock/[page]/[count]
```

### Update

```
PUT http://mock.com/mock/[mock_id]/update
@title mock_title
@content mock_script
```


