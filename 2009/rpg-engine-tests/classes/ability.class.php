<?php
/*
 * Filename : ability.class.php
 * Title  : MegaMan RPG Engine - Ability Class
 * Programmer/Designer : Ageman20XX / Adrian Marceau
 * Created  : May 10, 2009
 *
 * Description:
 * This class is used for creating an ability with properties and statistics
 */

// Require the database connect function
require_once("{$FUNCTIONROOT}database_connect.php");
require_once("{$INCLUDESROOT}define_types.php");

// Create the ability class
class ability {

    // Delare any ability variables
    public $ability_id, $ability_name, $ability_type;
    public $ability_base_power, $ability_weapon_energy, $ability_targets;
    public $ability_text_description, $ability_text_effect, $ability_text_usetext;

    // Activate and construct the ability by feeding it values
    function ability($type_library, $ability_array) {
      // Define the ability properies
      //echo('<pre>$ability_array = '.print_r($ability_array, true).'</pre>');
      $this->ability_id = !empty($ability_array['ability_id']) ? $ability_array['ability_id'] : 0;
      $this->ability_name = !empty($ability_array['ability_name']) ? $ability_array['ability_name'] : 'Ability';
      $this->ability_type = !empty($ability_array['ability_type']) && isset($type_library[$ability_array['ability_type']]) ? $type_library[$ability_array['ability_type']] : '';
      $this->ability_base_power = !empty($ability_array['ability_base_power']) ? $ability_array['ability_base_power'] : 0;
      $this->ability_weapon_energy = !empty($ability_array['ability_weapon_energy']) ? $ability_array['ability_weapon_energy'] : 0;
      $this->ability_targets = !empty($ability_array['ability_targets']) ? $ability_array['ability_targets'] : '';
      $this->ability_text_description = !empty($ability_array['ability_text_description']) ? $ability_array['ability_text_description'] : '';
      $this->ability_text_effect = !empty($ability_array['ability_text_effect']) ? $ability_array['ability_text_effect'] : '';
      $this->ability_text_usetext = !empty($ability_array['ability_text_usetext']) ? $ability_array['ability_text_usetext'] : '';
    }
}
?>