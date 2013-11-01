<?php

if (isset($_GET['p'])) {
 header('HTTP/1.1 301 Moved Permanently');
 header('Location: '.$_GET['p']);
}
