<?php

// phpcs:ignoreFile

$memcache_nodes = getenv('CMS_MEMCACHE_NODES');
if (!empty($memcache_nodes)) {
  $memcache_servers = explode(',', $memcache_nodes);
  $memcache_servers = array_map(function ($memcache_server) {
    return trim($memcache_server) . ':11211';
  }, $memcache_servers);
  $settings['memcache']['servers'] = [];
  foreach ($memcache_servers as $memcache_server) {
    $settings['memcache']['servers'][$memcache_server] = 'default';
  }
  $settings['cache']['default'] = 'cache.backend.memcache';
}

$settings['cms_datadog_api_key'] = getenv('CMS_DATADOG_API_KEY');

// Update next-build site endpoint to the appropriate preview alias
$config['next.next_site.next_build_preview_server']['base_url'] = getenv('NEXT_BUILD_PREVIEW_HOSTNAME');
$config['next.next_site.next_build_preview_server']['preview_url'] = getenv('NEXT_BUILD_PREVIEW_HOSTNAME') . 'api/preview';
