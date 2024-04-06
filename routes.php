<?php

require_once __DIR__.'/router.php';

post('/images', 'scripts/televersement.php');

get('/images', 'scripts/telechargement.php');

// For GET or POST
// The 404.php which is inside the views folder will be called
// The 404.php has access to $_GET and $_POST
any('/404','404.php');
