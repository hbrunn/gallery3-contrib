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

class album_expiry_installer {
  static function install() {
    $db = Database::instance();

    $db->query("ALTER TABLE items
      ADD COLUMN
      (
        `expiry_enabled` boolean default 0,
        `expiry_date` int(9) default NULL
      )");
 
    module::set_version('album_expiry', 1);
  }
}
// vim: set filetype=g3:
?>
