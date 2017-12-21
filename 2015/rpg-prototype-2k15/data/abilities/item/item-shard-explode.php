<?
// ITEM : EXPLODE SHARD
$ability = array(
  'ability_name' => 'Explode Shard',
  'ability_token' => 'item-shard-explode',
  'ability_game' => 'MMRPG',
  'ability_group' => 'MMRPG/Items/Explode',
  'ability_class' => 'item',
  'ability_subclass' => 'collectible',
  'ability_type' => 'explode',
  'ability_description' => 'A mysterious elemental shard that radiates with the Explode type energy of a defeated support mecha.  Collect four of these items to generate a new core that can be held by a robot master to equip Explode type abilities or traded in at the shop for a variable amount of Zenny.',
  'ability_energy' => 0,
  'ability_speed' => 10,
  'ability_accuracy' => 100,
  'ability_target' => 'auto',
  'ability_function' => function($objects){
    return mmrpg_ability::item_function_shard($objects);
  }
  );
?>