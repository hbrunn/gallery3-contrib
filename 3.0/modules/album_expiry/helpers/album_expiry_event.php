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

class album_expiry_event {
  
  static function album_add_form($item, $form) {
    $item->expiry_enabled = false;
    self::item_edit_form($item, $form, true);
  }

  static function item_edit_form($item, $form, $force=false) {
    if((!$item->is_album() || $item->id == 1) && !$force) {
      return;
    }
    $group = $form->group("album_expiry");
    $expiry_enabled = $group->checkbox("expiry_enabled")
      ->label(t("Expiry enabled"))
      ->value("1")
      ->onchange("if(!this.checked) {\$('select.expiry_date').attr('disabled', 'disabled')} else {\$('select.expiry_date').removeAttr('disabled')}");
    $expiry_date = $group->dateselect("expiry_date")
      ->label(t("Expiry date"))
      ->years(date('Y'), date('Y')+5)
      ->value($item->expiry_date ? $item->expiry_date : time() + 2 * 7 * 24 * 3600)
      ->class("expiry_date");
    if(!$item->expiry_enabled) {
      $expiry_date->disabled("disabled");
    }
    else
    {
      $expiry_enabled->checked("checked");
    }
  }

  static function album_add_form_completed($item, $form) {
    self::item_edit_form_completed($item, $form);
  }

  static function item_edit_form_completed($item, $form) {
    if(!$item->is_album() || $item->id == 1) {
      return;
    }
    $item->expiry_enabled = $form->album_expiry->inputs['expiry_enabled']->value;
    if($item->expiry_enabled) {
      $item->expiry_date = $form->album_expiry->inputs['expiry_date']->value;
    } else {
      $item->expiry_date = null;
    }
    $item->save();
  }
}

// vim: set filetype=g3:
?>
