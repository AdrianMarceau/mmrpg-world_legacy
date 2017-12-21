<?
// ITEM : LASER CORE
$ability = array(
  'ability_name' => 'Laser Core',
  'ability_token' => 'item-core-laser',
  'ability_game' => 'MMRPG',
  'ability_group' => 'MMRPG/Items/Laser',
  'ability_class' => 'item',
  'ability_subclass' => 'holdable',
  'ability_type' => 'laser',
  'ability_description' => 'A mysterious elemental core that radiates with the Laser type energy of a defeated robot master.  When held by another robot, this item allows the user to equip any Laser type ability.  This item is also coveted by a certain character and can be traded in for a variable amount of Zenny.',
  'ability_energy' => 0,
  'ability_speed' => 10,
  'ability_accuracy' => 100,
  'ability_target' => 'auto',
  'ability_function' => function($objects){
    return mmrpg_ability::item_function_core($objects);
  }
  );
?>