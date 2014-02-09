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

class albumpassword_random_event {
  
  static function album_add_form($item, $form) {
    $group = $form->group("albumpassword_random");
    $expiry_enabled = $group->checkbox("password_enabled")
      ->label(t("Set a password for this album"))
      ->value("1")
      ->checked("checked")
      ->onchange("if(!this.checked) {\$('input[name=\'password\']').attr('disabled', 'disabled')} else {\$('input[name=\'password\']').removeAttr('disabled')}");
    $expiry_date = $group->input("password")
      ->label(t("Password"))
      ->value(
        join(
          array_map(
            function($v) { 
              return chr(rand(33, 125)); 
            },
            array_fill(0, 12, 0))));
  }

  static function album_add_form_completed($item, $form) {
    if($form->albumpassword_random->inputs['password_enabled']->value &&
       $form->albumpassword_random->inputs['password']->value) {
      // code borrowed from albumpassword/controllers/albumpassword.php 
      // Save the new password.
      $new_password = ORM::factory("items_albumpassword");
      $new_password->album_id = $item->id;
      $new_password->password = $form->albumpassword_random->inputs['password']->value;
      $new_password->save();

      // Add the album to the id cache.
      $cached_album = ORM::factory("albumpassword_idcache");
      $cached_album->password_id = $new_password->id;
      $cached_album->item_id = $item->id;
      $cached_album->save();
    }
  }
}

// vim: set filetype=g3:
?>
