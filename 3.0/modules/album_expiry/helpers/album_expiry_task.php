<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Copyright (C) 2014 Holger Brunn
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or (at
 * your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street - Fifth Floor, Boston, MA  02110-1301, USA.
 */

class album_expiry_task {
  
  static function available_tasks() {
    $expired_albums = db::build()
      ->where('expiry_enabled', '=', true)
      ->where('expiry_date', '<=', time())
      ->count_records('items');
    return array(Task_Definition::factory()
      ->callback("album_expiry_task::delete_expired_albums")
      ->name(t("Delete expired albums"))
      ->description(
        $expired_albums ?
        t2("One album is expired", "%count albums are expired", $expired_albums) :
        t("No albums are expired"))
      ->severity($expired_albums ? log::WARNING : log::SUCCESS));
  }

  static function delete_expired_albums($task) {
    $expired_albums = ORM::factory("item")
      ->where('expiry_enabled', '=', true)
      ->where('expiry_date', '<=', time())
      ->find_all();
    foreach($expired_albums as $album) {
      $album->delete();
    }
    $task->done = true;
    $task->state = 'success';
    $task->percent_complete = 100;
    $task->status = t2("One album was deleted", "%count albums were", count($expired_albums));
  }
}

// vim: set filetype=g3:
?>
