<?
// ITEM : DEFENSE SHARD
$ability = array(
  'ability_name' => 'Defense Shard',
  'ability_token' => 'item-shard-defense',
  'ability_game' => 'MMRPG',
  'ability_group' => 'MMRPG/Items/Defense',
  'ability_class' => 'item',
  'ability_subclass' => 'collectible',
  'ability_type' => 'defense',
  'ability_description' => 'A mysterious elemental shard that radiates with the Defense type energy of a defeated support mecha.  These items have no effect in battle, but collecting five of them will generate a new core that can be traded in for Zenny.',
  'ability_energy' => 0,
  'ability_speed' => 10,
  'ability_accuracy' => 100,
  'ability_target' => 'auto',
  'ability_function' => function($objects){
    return mmrpg_ability::item_function_shard($objects);
  }
  );
?>