<?php

Router::add('/updateAufstellung', 'ApiController@updateAufstellung');
Router::add('/takeAufstellung', 'ApiController@takeAufstellung');

Router::add('/createPlayers', 'AdminController@createPlayers');