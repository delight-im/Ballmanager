<?php

require_once(__DIR__.'/../utils/database.php');

class LigaController {

    public static function getLigaNameByTeamIds($ids) {
        $sql = "SELECT name FROM " . CONFIG_TABLE_PREFIX . "ligen WHERE ids = (SELECT liga FROM " . CONFIG_TABLE_PREFIX . "teams WHERE ids = '" . $ids . "')";
        $result = DB::query($sql, FALSE);
        $result = mysql_fetch_object($result);
        if (!$result) {
            //TODO:: Error log
        }

        return $result->name;
    }

}
