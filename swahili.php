<?php
spl_autoload_register(
    function ($className)
    {
        $ds = DIRECTORY_SEPARATOR;
        $className = str_replace('js\\tools\\numbers2words', '', $className);
        $className = str_replace('\\', $ds, $className);
        $className = trim($className, $ds);

        $path = __DIR__ . $ds . 'src' . $ds . $className . '.php';

        if (!is_readable($path))
        {
            return false;
        }

        require $path;

        return true;
    },
    true
);

use js\tools\numbers2words\Speller;

echo Speller::spellCurrency(1000, Speller::LANGUAGE_SWAHILI, Speller::CURRENCY_TANZANIAN_SHILLING, true, true, true);
