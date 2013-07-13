<?php
/**
 * Functions for testing and evaluating NewFreetag.
 *
 * All functions defined here are namespaced <code>NewFreetag\Testing</code>.
 */

namespace DbAdapters\Tests;

use \RuntimeException;

function pre_r($var)
{
    return '<pre>' . print_r($var, "noecho") . "</pre>\n";
}

function pre_dump($var)
{
    ob_start();
    var_dump($var);

    return '<pre>' . ob_get_clean() . "</pre>\n";
}



function testUnit($title, $content = '', $code='')
{
	$result = '<h3>' . $title . "</h3>\n" . codeBox($content, $code, false);
	echo $result;
}


function codeBox($content = '', $code='', $echo = true)
{
    $result = '';
    if ($code) {
        $result .= '<code><pre>' . $code . "</pre></code>\n";
    }

    if ($content) {
        $result .= '<div class="test result">' . $content . "</div>\n";
    }
    if ($echo) {
        echo $result;
    }
    else {
        return $result;
    }

}




function getLabel($label, $type="")
{
	return '<span class="'.$type.' label">'.$label.'</span>';
}


function getObjectLabel($label, $type="object")
{
	return getLabel($label, $type);
}




/**
 * @return \PDO
 */
function getPdoConnection($db_driver, $db_host, $db_name, $db_user, $db_pass, $charset = 'utf8', $persistent = true)
{
    return new \PDO("$db_driver:host=$db_host;dbname=$db_name", $db_user, $db_pass);
}


/**
 * @return \ADOConnection
 */
function getDatabaseADOConnection($db_driver, $db_host, $db_name, $db_user, $db_pass, $charset = 'utf8', $persistent = true)
{
        $db = \ADONewConnection($db_driver);

        if (!$connecting = $persistent
        ? $db->PConnect($db_host, $db_user, $db_pass, $db_name)
        : $db->Connect($db_host, $db_user, $db_pass, $db_name)) {
            throw new \RuntimeException("Connectiong to Database failed.");
        }

        $db->Execute("set names '" .$charset. "'");

        return $db;
}
