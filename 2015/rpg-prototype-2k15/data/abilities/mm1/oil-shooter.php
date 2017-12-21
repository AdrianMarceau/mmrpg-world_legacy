<?
// OIL SHOOTER
$ability = array(
  'ability_name' => 'Oil Shooter',
  'ability_token' => 'oil-shooter',
  'ability_game' => 'MM01',
  'ability_group' => 'MM01/Weapons/00B',
  'ability_master' => 'oil-man',
  'ability_number' => 'DLN-00B',
  'ability_description' => 'The user fires a large blob of crude oil at the target, surrounding them in a puddle of flammable liquid and doubling the damage they receive from Flame type attacks!  Robots affected by this ability appear to take reduced damage from Water type attacks, however, so choose your targets with care.',
  'ability_type' => 'earth',
  'ability_energy' => 4,
  'ability_damage' => 16,
  'ability_accuracy' => 96,
  'ability_target' => 'select_target',
  'ability_function' => function($objects){

    // Extract all objects into the current scope
    extract($objects);

    // Define this ability's attachment token
    $this_attachment_token = 'ability_'.$this_ability->ability_token.'_'.$target_robot->robot_id;
    $this_attachment_info = array(
    	'class' => 'ability',
    	'ability_token' => $this_ability->ability_token,
    	'attachment_duration' => 9,
      'attachment_damage_input_booster_flame' => 2.0,
      'attachment_damage_input_breaker_water' => 0.5,
    	'attachment_weaknesses' => array('flame'),
    	'attachment_create' => array(
        'trigger' => 'special',
        'kind' => '',
        'percent' => true,
        'frame' => 'defend',
        'rates' => array(100, 0, 0),
        'success' => array(9, -10, -5, -10, $target_robot->print_robot_name().' found itself in a puddle of crude oil!<br /> '.$target_robot->print_robot_name().'&#39;s <span class="ability_name ability_type ability_type_flame">Flame</span> resistance was compromised&hellip;'),
        'failure' => array(9, -10, -5, -10, $target_robot->print_robot_name().' found itself in a puddle of crude oil!<br /> '.$target_robot->print_robot_name().'&#39;s <span class="ability_name ability_type ability_type_flame">Flame</span> resistance was compromised&hellip;')
        ),
    	'attachment_destroy' => array(
        'trigger' => 'special',
        'kind' => '',
        'type' => '',
        'percent' => true,
        'modifiers' => false,
        'frame' => 'taunt',
        'rates' => array(100, 0, 0),
        'success' => array(9, 0, -9999, 0,  'The oil surrounding '.$target_robot->print_robot_name().' faded away&hellip;<br /> '.$target_robot->print_robot_name().' is no longer vulnerable!'),
        'failure' => array(9, 0, -9999, 0, 'The oil surrounding '.$target_robot->print_robot_name().' faded away&hellip;<br /> '.$target_robot->print_robot_name().' is no longer vulnerable!')
        ),
      'ability_frame' => 0,
      'ability_frame_animate' => array(1, 2),
      'ability_frame_offset' => array('x' => 0, 'y' => -10, 'z' => -8)
      );

    // Target the opposing robot
    $this_ability->target_options_update(array(
      'frame' => 'shoot',
      'success' => array(0, 125, 5, 10, $this_robot->print_robot_name().' fires the '.$this_ability->print_ability_name().'!')
      ));
    $this_robot->trigger_target($target_robot, $this_ability);

    // Inflict damage on the opposing robot
    $this_ability->damage_options_update(array(
      'kind' => 'energy',
      'kickback' => array(5, 0, 0),
      'success' => array(1, -5, -10, 10, 'The '.$this_ability->print_ability_name().' splashed into the target!'),
      'failure' => array(1, -105, -10, -10, 'The '.$this_ability->print_ability_name().' missed&hellip;')
      ));
    $this_ability->recovery_options_update(array(
      'kind' => 'energy',
      'frame' => 'taunt',
      'kickback' => array(5, 0, 0),
      'success' => array(1, -5, -10, 10, 'The '.$this_ability->print_ability_name().' was absorbed by the target!'),
      'failure' => array(1, -105, -10, -10, 'The '.$this_ability->print_ability_name().' had no effect&hellip;')
      ));
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);

    // Attach the ability to the target if not disabled
    if ($target_robot->robot_status != 'disabled'
      && $this_ability->ability_results['this_result'] != 'failure'
      && $this_ability->ability_results['this_amount'] > 0){

      // If the ability flag was not set, attach the Proto Shield to the target
      if (!isset($target_robot->robot_attachments[$this_attachment_token])){

        // Attach this ability attachment to the robot using it
        $target_robot->robot_attachments[$this_attachment_token] = $this_attachment_info;
        $target_robot->update_session();

        // Target this robot's self
        $this_robot->robot_frame = 'base';
        $this_robot->update_session();
        $this_ability->target_options_update($this_attachment_info['attachment_create']);
        $target_robot->trigger_target($target_robot, $this_ability);

      }
      // Else if the ability flag was set, reinforce the shield by one more duration point
      else {

        // Collect the attachment from the robot to back up its info
        $this_attachment_info = $target_robot->robot_attachments[$this_attachment_token];
        $this_attachment_info['attachment_duration'] = 4;
        $target_robot->robot_attachments[$this_attachment_token] = $this_attachment_info;
        $target_robot->update_session();

        // Target the opposing robot
        $this_ability->target_options_update(array(
          'frame' => 'defend',
          'success' => array(9, 85, -10, -10, $this_robot->print_robot_name().' refreshed the '.$this_ability->print_ability_name().' puddle!<br /> '.$target_robot->print_robot_name().'&#39;s vulnerability has been extended!')
          ));
        $target_robot->trigger_target($target_robot, $this_ability);

      }

    }

    // Either way, update this ability's settings to prevent recovery
    $this_ability->damage_options_update($this_attachment_info['attachment_destroy'], true);
    $this_ability->recovery_options_update($this_attachment_info['attachment_destroy'], true);
    $this_ability->update_session();

    // Return true on success
    return true;


    }
  );
?>