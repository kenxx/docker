<?php
function get_mysql_server_version() {
	$mysql = new \mysqli();
	$mysql->connect($_SERVER['MYSQL_HOST'], 'root', $_SERVER['MYSQL_ROOT_PASSWORD']);
	if ($mysql->connect_errno) {
		return false;
	}

    $version = $mysql->get_server_info();
    $mysql->close();

    return $version;
}

function get_mongo_server_version() {
	$manager = new MongoDB\Driver\Manager('mongodb://'.$_SERVER['MONGODB_HOST'].':27017/');
	$command = new MongoDB\Driver\Command(['serverStatus' => 1]);
	try {
		$cursor = $manager->executeCommand('test', $command);
	} catch (\MongoDB\Driver\Exception\Exception $e) {
	  return false;
  }

  $version = $cursor->toArray()[0]->version;

	return $version;

}

function get_redis_server_version() {
  $redis = new Redis();

  $ret = $redis->connect($_SERVER['REDIS_HOST']);

  if ($ret) {
    $version = ((array)$redis->info())['redis_version'];

    $redis->close();

	  return $version;
  }

  return false;
}

function get_memcache_server_version() {
  $m = new Memcached();

  $ret = $m->addServer($_SERVER['MEMCACHED_HOST'], 11211);

  if ($ret) {
    $version = $m->getVersion();

    $m->quit();

    return $version ? current($version) : false;
  }

  return false;
}

if (isset($_GET['phpinfo']) && $_GET['phpinfo']) {
  phpinfo();
  return;
}
?>

<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome to Develop docker-compose stack</title>
</head>
<body>
<h3>We have some services running in this stack:</h3>
<ol>
    <li>PHP: <?php echo phpversion() ?></li>
    <li>nginx: <?php echo str_replace('nginx/', '', $_SERVER['SERVER_SOFTWARE']) ?></li>
    <li>MySQL: <?php echo get_mysql_server_version(); ?></li>
    <li>MongoDB: <?php echo get_mongo_server_version(); ?></li>
    <li>Redis: <?php echo get_redis_server_version(); ?></li>
    <li>Memcached: <?php echo get_memcache_server_version(); ?></li>
</ol>
<h3>We also have some extensions in php runtime (installed by using PECL):</h3>
<ol>
  <li>XDebug: <?php echo phpversion('xdebug'); ?></li>
  <li>Memcached: <?php echo phpversion('memcached'); ?></li>
  <li>phpredis: <?php echo phpversion('redis'); ?></li>
  <li>mongodb: <?php echo phpversion('mongodb'); ?></li>
  <li>igbinary: <?php echo phpversion('igbinary'); ?></li>
  <li>msgpack: <?php echo phpversion('msgpack'); ?></li>
</ol>
<h3>Other things</h3>
<p>To get PHP info, please <a href="?phpinfo=1">click here</a>.</p>
<p>We have a adminer docker to manage MySQL in case you can not link to it , <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>:8080">click here</a>.</p>
<p>You may also needs composer which we already install the latest version, you can use this command to get the version:</p>
<pre><code>docker exec -it --user www-data dev_php composer -V</code></pre>
<p>To get more docker info, please using this command: </p>
<pre><code>docker ps -a</code></pre>
<p>Then you may get something like this: </p>
<pre>
CONTAINER ID        IMAGE               COMMAND                  CREATED             STATUS              PORTS                                      NAMES
cbba415a805c        mongo:latest        "docker-entrypoint.s…"   About an hour ago   Up About an hour    0.0.0.0:27017->27017/tcp                   dev_mongo
afd0ae7241f6        redis:latest        "docker-entrypoint.s…"   About an hour ago   Up About an hour    0.0.0.0:6379->6379/tcp                     dev_redis
f93119535a5f        memcached:latest    "docker-entrypoint.s…"   About an hour ago   Up About an hour    0.0.0.0:11211->11211/tcp                   cache_memcached
f0663c6f9b6b        mysql:5.7           "docker-entrypoint.s…"   About an hour ago   Up About an hour    0.0.0.0:3306->3306/tcp                     dev_mysql
04b930300667        adminer:latest      "entrypoint.sh docke…"   About an hour ago   Up About an hour    0.0.0.0:8080->8080/tcp                     dev_adminer
f84cc9368e02        develop_php         "docker-php-entrypoi…"   About an hour ago   Up About an hour    0.0.0.0:9000->9000/tcp                     dev_php
1cb1bcea9808        nginx:latest        "nginx -g 'daemon of…"   About an hour ago   Up About an hour    0.0.0.0:80->80/tcp, 0.0.0.0:443->443/tcp   dev_nginx
</pre>
<p>This Docker Compose is a simple project that I maintenance now, for more info please <a href="https://github.com/kenxx/Dockers/tree/master/develop">click here</a>.</p>
</body>
</html>