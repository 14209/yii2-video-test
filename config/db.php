<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=postgresql;port=5432;dbname=maindb',
    'username' => 'test',
    'password' => 'secret',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
