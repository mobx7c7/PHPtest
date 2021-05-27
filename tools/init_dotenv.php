<?php
require 'constants.php';

function getResponseSTDIN($text, $default = '')
{
    if (empty($default)) {
        echo "$text";
    } else {
        echo "$text ($default)";
    }

    echo PHP_EOL;

    echo '> ';

    $response = trim(fgets(STDIN));

    echo PHP_EOL;

    return !empty($response) ? $response : $default;
}

function writeEnvFile($arr)
{
    echo 'Writing to '.ENV_FILE.PHP_EOL;

    $file = fopen(ENV_FILE,'w');
    foreach ($arr as $key => $val)
    {
        fwrite($file, "$key=\"$val\"".PHP_EOL);
    }
    fclose($file);
}

echo 'DOTENV INITIALIZER'.PHP_EOL.PHP_EOL;

$env['DB_HOST'] = getResponseSTDIN('Enter with a database host','localhost');
$env['DB_PORT'] = getResponseSTDIN('Enter with a database port', '3306');
$env['DB_USER'] = getResponseSTDIN('Enter with a database user', 'root');
$env['DB_PASS'] = getResponseSTDIN('Enter with a database password','');
$env['DB_NAME'] = getResponseSTDIN('Enter with a database name','phptest');

writeEnvFile($env);

echo 'Done.';