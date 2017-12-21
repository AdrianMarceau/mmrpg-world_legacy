<?
// ITEM : ATTACK PELLET
$ability = array(
  'ability_name' => 'Attack Pellet',
  'ability_token' => 'item-attack-pellet',
  'ability_game' => 'MMRPG',
  'ability_group' => 'MM00/Items/Attack',
  'ability_class' => 'item',
  'ability_subclass' => 'consumable',
  'ability_type' => 'attack',
  'ability_description' => 'A small weapon pellet that boosts the attack stat of one robot on the user\'s side of the field by {RECOVERY}%.  This item appears to have a secondary effect, slightly boosting attack bonuses during the target\'s next level-up.',
  'ability_energy' => 0,
  'ability_speed' => 10,
  'ability_recovery' => 10,
  'ability_recovery_percent' => true,
  'ability_accuracy' => 100,
  'ability_target' => 'select_this',
  'ability_function' => function($objects){

    // Extract all objects into the current scope
    extract($objects);

    // Target this robot's self
    $this_ability->target_options_update(array(
      'frame' => 'summon',
      'success' => array(0, 40, -2, 99,
        $this_player->print_player_name().' uses an item from the inventory&hellip; <br />'.
        $target_robot->print_robot_name().' is given the '.$this_ability->print_ability_name().'!'
        )
      ));
    $target_robot->trigger_target($target_robot, $this_ability);

    // Increase this robot's attack stat
    $this_ability->recovery_options_update(array(
      'kind' => 'attack',
      'percent' => true,
      'modifiers' => false,
      'frame' => 'taunt',
      'success' => array(9, 0, 0, -9999, $target_robot->print_robot_name().'&#39;s weapons powered up!'),
      'failure' => array(9, 0, 0, -9999, $target_robot->print_robot_name().'&#39;s weapons were not affected&hellip;')
      ));
    $attack_recovery_amount = ceil($target_robot->robot_base_attack * ($this_ability->ability_recovery / 100));
    $target_robot->trigger_recovery($target_robot, $this_ability, $attack_recovery_amount);

    // If this a human player on the left side, also increase their pending attack boost on level-up
    if ($this_player->player_controller == 'human'){
      $session_token = mmrpg_game_token();
      // Collect any existing pending boosts and then add the ability recovery value
      if (!empty($_SESSION['RPG2k15'][$session_token]['values']['battle_rewards'][$this_player->player_token]['player_robots'][$target_robot->robot_token]['robot_attack_pending'])){
        $session_attack_pending = $_SESSION['RPG2k15'][$session_token]['values']['battle_rewards'][$this_player->player_token]['player_robots'][$target_robot->robot_token]['robot_attack_pending'];
        $session_attack_pending += $this_ability->ability_recovery;
      } else {
        $session_attack_pending = $this_ability->ability_recovery;
      }
      // Update this value in the session and ensure the robot gains rewards on level-up
      $_SESSION['RPG2k15']['GAME']['values']['battle_rewards'][$target_player->player_token]['player_robots'][$target_robot->robot_token]['robot_attack_pending'] = $session_attack_pending;
    }

    // Return true on success
    return true;

  }
  );
?>