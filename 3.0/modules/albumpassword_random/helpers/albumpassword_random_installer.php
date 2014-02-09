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

class albumpassword_random_installer {
  static function install() {
    module::set_version('albumpassword_random', 1);
  }

  static function can_activate() {
    if (!module::is_active("albumpassword")) {
      return array(
        "warn" => array(
          t("albumpassword_random requires the albumpassword module.")));
    }
    return array();
  }

}
// vim: set filetype=g3:
?>
