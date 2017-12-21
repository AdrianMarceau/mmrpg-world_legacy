<?
// ITEM : DEFENSE CORE
$ability = array(
  'ability_name' => 'Defense Core',
  'ability_token' => 'item-core-defense',
  'ability_game' => 'MMRPG',
  'ability_group' => 'MMRPG/Items/Defense',
  'ability_class' => 'item',
  'ability_subclass' => 'holdable',
  'ability_type' => 'defense',
  'ability_description' => 'A mysterious elemental core that radiates with the Defense type energy of a defeated robot master.  These items have no effect in battle, but are loved by a certain character and can be traded in for a respectable amount of Zenny.',
  'ability_energy' => 0,
  'ability_speed' => 10,
  'ability_accuracy' => 100,
  'ability_target' => 'auto',
  'ability_function' => function($objects){
    return mmrpg_ability::item_function_core($objects);
  }
  );
?>