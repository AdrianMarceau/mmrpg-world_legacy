<?
// Define the content type
header("Content-type: text/css; charset=iso-8859-1");
header("Cache-Control: must-revalidate");
$use_cache = 3600;//set to 0 if you want
$Expiration = "Expires: ".gmdate("D, d M Y H:i:s",time() + $use_cache)." GMT";
header($Expiration);

// Define whether to show guide lines
$show_lines = false;

// Create the colour pallet
$pallet = array();
$pallet[0] = '#C7D8EA';

?>
.wrapper {
    margin: 0;
    padding: 20px;
    background: transparent url(../mmpu_background.gif) fixed repeat top left;
    height: 100%;
    text-align: center;
    font-size: 16px;
    line-height: 1.4;
    font-family: Arial;
    -moz-border-radius: 6px;
    -webkit-border-radius: 6px;
    border-radius: 6px;
}
#page {
    display: block;
    margin: 0 auto;
    min-height: 100%;
    width: 740px;
    min-width: 740px;
    border-width: 4px;
    border-style: solid;
    border-color: <?=$pallet[0]?>;
    background-color: #FFF;
    background: #FFF url(../images/mmpu_background_fade.jpg) fixed repeat-x 0 100px;
    text-align: center;
    padding: 10px;
    color: #222;
}
#page h1 {
    font-size: 180%;
    margin: 6px auto;
    text-align: left;
    border-bottom: 4px double #222;
    color: #222;
    padding-bottom: 8px;
}
#page h2 {
    font-size: 150%;
    margin: 3px auto;
    text-align: right;
}
#page h3 {
    font-size: 120%;
    margin: 0 auto;
    text-align: right;
    font-style: italic;
    font-size: 12px;
}

#battle {
    width: 700px;
    border-collapse: collapse;
    border-style: none;
    margin: 10px auto 50px;
}
#battle td, #battle tr, #battle thead, #battle tbody, #battle tfoot, #battle table {
    padding: 0;
    border-collapse: collapse;
    border-spacing: 0;
}
#battle td.container_row {
    padding: 0;
    <?= $show_lines ? "border: 1px dotted blue;\r\n" : '' ?>
    text-align: center;
}

#battle table.battle_header {
    width: 700px;
    border-collapse: collapse;
    border-style: none;
    margin: 0 auto 15px;
}
#battle table.battle_header td.team_box_container {
    width: 250px;
    text-align: center;
    <?= $show_lines ? "border: 1px dotted green;\r\n" : '' ?>
}

#battle table.battle_header table.team_box {
    width: 300px;
    border-collapse: collapse;
    margin: 0 auto;
    color: #464646;
    background-color: transparent;
    border-style: none;
}
#battle table.battle_header table.team_box thead tr {
    border-style: none;
}
#battle table.battle_header table.team_box tbody.team_row td {
    font-weight: bold;
    padding: 0;
    padding-top: 2px;
    padding-bottom: 5px;
}

#battle table.battle_header td.vs_box_container {
    width: 200px;
    text-align: center;
    vertical-align: bottom;
}
#battle table.battle_header div.vs_box {
    margin: 10px auto 40px;
    vertical-align: bottom;
}
#battle table.battle_header div.vs_box img {
    margin: 0;
    vertical-align: bottom;
}

#battle table.battle_header table.team_box div.sprite_box,
#battle table.battle_header table.team_box div.sprite_name,
#battle table.battle_header table.team_box div.sprite_stats {
    width: 100px;
    padding: 0;
    margin: 0 auto;
    text-align: center;
}

#battle table.battle_header table.team_box div.sprite_box {
    background: transparent url(../images/sprite_shadow_large.png) no-repeat center center;
    text-align: center;
}
#battle table.battle_header table.team_box div.sprite_box img {
    vertical-align: top;
}
#battle table.battle_header table.team_box div.sprite_name {
    font-size: 75%;
    font-weight: bold;
}
#battle table.battle_header table.team_box div.sprite_stats {
    font-size: 55%;
    font-weight: bold;
}


#battle table.battle_header table.player_box {
    width: 300px;
    border-collapse: collapse;
    margin: 4px auto 0;
    border-style: none;
    color: #464646;
    background-color: transparent;
}
#battle table.battle_header table.player_box td {
    font-size: 80%;
    font-weight: bold;
    padding-top: 4px;
    padding-bottom: 4px;
    vertical-align: top;
}
#battle table.battle_header table.player_box td.left {
    text-align: left;
}
#battle table.battle_header table.player_box td.right {
    text-align: right;
}

#battle table.battle_header table.player_box div.avatar {
    width: 100px;
    text-align: center;
}
#battle table.battle_header table.player_box div.avatar img {
 vertical-align: top;
 margin: 4px auto;
 border: 2px solid <?=$pallet[0]?>;
}
#battle table.battle_header table.player_box div.name {
    width: 200px;
    margin-top: 5px;
    font-weight: bold;
    font-size: 100%;
}
#battle table.battle_header table.player_box div.info {
    width: 200px;
    margin: 2px auto;
    font-size: 80%;
}


#battle table.battle_footer table.team_box {
    width: 300px;
    border-collapse: collapse;
    margin: 0 auto;
    margin-top: 15px;
    color: #464646;
    background-color: #FFF;
}
#battle table.battle_footer table.team_box tbody tr {
    border-style: none;
}
#battle table.battle_footer table.team_box tbody td {
    padding-top: 5px;
    padding-bottom: 5px;
}

#battle table.battle_footer td.vs_box_container {
    width: 200px;
    text-align: center;
}
#battle table.battle_footer div.vs_box img {
    margin: 10px auto;
}

#battle table.battle_footer table.team_box div.sprite_box,
#battle table.battle_footer table.team_box div.sprite_name,
#battle table.battle_footer table.team_box div.sprite_stats {
    width: 100px;
    padding: 0;
    margin: 0 auto;
    text-align: center;
}

#battle table.battle_footer table.team_box div.sprite_box {
    background: transparent url(../images/sprite_shadow_small.png) no-repeat center center;
    text-align: center;
}
#battle table.battle_footer table.team_box div.sprite_box img {
    vertical-align: top;
}
#battle table.battle_footer table.team_box div.sprite_box img.normal {

}
#battle table.battle_footer table.team_box div.sprite_box img.knocked-out {
    opacity:0.4;
    filter:alpha(opacity=40);
}
#battle table.battle_footer table.team_box div.sprite_name {
    font-size: 75%;
    font-weight: bold;
}
#battle table.battle_footer table.team_box div.sprite_stats {
    font-size: 55%;
    font-weight: bold;
}
#battle table.battle_footer table.team_box div.sprite_action {
    font-size: 55%;
    font-weight: normal;
    color: #ABABAB;
}

#battle table.turn_header {
    width: 700px;
    border-collapse: collapse;
    border-style: none;
    margin: 4px auto;
}
#battle table.turn_header td.left, #battle table.turn_header td.right {
width: 200px;
}
#battle table.turn_header td div.hide, #battle table.turn_header td div.show {
    width: 200px;
    margin: 0;
    color: #464646;
}
#battle table.turn_header td.left div.hide a, #battle table.turn_header td.left div.show a,
#battle table.turn_header td.right div.hide a, #battle table.turn_header td.right div.show a {
    color: #686868;
    text-decoration: none;
    font-style: italic;
}
#battle table.turn_header td.left div.hide a:hover, #battle table.turn_header td.left div.show a:hover,
#battle table.turn_header td.right div.hide a:hover, #battle table.turn_header td.right div.show a:hover {
    color: #464646;
}
#battle table.turn_header td.left div.hide {
    border-top: 2px solid <?=$pallet[0]?>;
    border-left: 2px solid <?=$pallet[0]?>;
    text-align: left;
    padding-left: 10px;
    font-size: 90%;
}
#battle table.turn_header td.right div.hide {
    border-top: 2px solid <?=$pallet[0]?>;
    border-right: 2px solid <?=$pallet[0]?>;
    text-align: right;
    padding-right: 10px;
    font-size: 90%;
}
#battle table.turn_header td.left div.show {
    border-bottom: 2px solid <?=$pallet[0]?>;
    border-left: 2px solid <?=$pallet[0]?>;
    text-align: left;
    padding-left: 10px;
    font-size: 70%;
}
#battle table.turn_header td.right div.show {
    border-bottom: 2px solid <?=$pallet[0]?>;
    border-right: 2px solid <?=$pallet[0]?>;
    text-align: right;
    padding-right: 10px;
    font-size: 70%;
}
#battle table.turn_header td.turn_title_hide, #battle table.turn_header td.turn_title_show {
    color: #686868;
    font-weight: bold;
}
#battle table.turn_header td.turn_title_hide {
    font-size: 90%;
}
#battle table.turn_header td.turn_title_show {
    font-size: 70%;
}
#battle table.turn_header td.turn_title_hide a, #battle table.turn_header td.turn_title_show a {
    color: #686868;
    text-decoration: none;
}
#battle table.turn_header td.turn_title_hide a:hover, #battle table.turn_header td.turn_title_show a:hover {
    color: #464646;
    text-decoration: underline;
}

#battle table.turn_footer {
    width: 700px;
    border-collapse: collapse;
    border-style: none;
    margin: 4px auto;
}
#battle table.turn_footer td.left, #battle table.turn_footer td.right {
width: 200px;
}
#battle table.turn_footer td div {
    width: 200px;
    margin: 0;
    color: #464646;
}
#battle table.turn_footer td.left div a, #battle table.turn_footer td.left div a,
#battle table.turn_footer td.right div a, #battle table.turn_footer td.right div a {
    color: #686868;
    text-decoration: none;
    font-style: italic;
}
#battle table.turn_footer td.left div a:hover, #battle table.turn_footer td.left div a:hover,
#battle table.turn_footer td.right div a:hover, #battle table.turn_footer td.right div a:hover {
    color: #464646;
}
#battle table.turn_footer td.left div {
    border-bottom: 2px solid <?=$pallet[0]?>;
    border-left: 2px solid <?=$pallet[0]?>;
    text-align: left;
    padding-left: 10px;
    font-size: 70%;
}
#battle table.turn_footer td.right div {
    border-bottom: 2px solid <?=$pallet[0]?>;
    border-right: 2px solid <?=$pallet[0]?>;
    text-align: right;
    padding-right: 10px;
    font-size: 70%;
}
#battle table.turn_footer td.turn_title {
    color: #686868;
    font-weight: bold;
    font-size: 70%;
}

#battle div.event {
    width: 600px;
    border-collapse: collapse;
    border-style: none;
    margin: 2px auto;
    padding: 0;
}

#battle div.event table.event_shout_box {
    width: 600px;
    border-collapse: separate;
    border-style: none;
}
#battle div.event table.event_shout_box td.player_info {
    width: 100px;
    text-align: center;
    border-style: none;
    background-color: transparent;
}
#battle div.event table.event_shout_box td.player_info img.player_avatar {
    border: 2px solid <?=$pallet[0]?>;
    margin: 5px;
    vertical-align: top;
}
#battle div.event table.event_shout_box td.player_info strong {
    display: inline-block;
    margin: 0 5px 5px;
    font-size: 60%;
}
#battle div.event table.event_shout_box td.shout_text_top, #battle div.event table.event_shout_box td.shout_text_bottom,
#battle div.event table.event_shout_box td.shout_text_middle {
    width: 100%;
    height: 100%;
    margin: 0;
    border-style: none;
}
#battle div.event table.event_shout_box td.shout_text_middle {
    border-top-style: none;
    border-bottom-style: none;
    background-color: transparent;
}
#battle div.event table.event_shout_box td.shout_text_top {
    border-top-style: none;
    font-size: 10%;
}
#battle div.event table.event_shout_box td.shout_text_bottom {
    border-bottom-style: none;
    font-size: 10%;
}
#battle div.event table.event_shout_box td.shout_text_middle span.title {
    display: block;
    width: 480px;
    margin: 5px auto 4px;
    color: #747474;
    font-size: 70%;
    text-align: left;
}
#battle div.event table.event_shout_box td.shout_text_middle span.text {
    display: block;
    width: 480px;
    margin: 0 auto;
    color: #464646;
    font-size: 95%;
    text-align: left;
}
#battle div.event table.event_shout_box td.shout_text_middle span.date {
    display: block;
    width: 480px;
    margin: 2px auto 2px;
    color: #CACACA;
    font-size: 55%;
    text-align: right;
}


#battle div.event table.event_ability_box {
    width: 400px;
    border-collapse: separate;
    border-style: none;
}
#battle div.event table.event_ability_box td.robot_info {
    width: 140px;
    text-align: center;
    border-style: none;
    background-color: transparent;
}
#battle div.event table.event_ability_box td.robot_info div.robot_avatar {
    vertical-align: top;
    text-align: center;
    width: 100px;
    border-style: none;
    margin: 4px;
    padding: 0;
    background: transparent url(../images/sprite_shadow_large.png) scroll no-repeat center center;
}
#battle div.event table.event_ability_box td.robot_info img.robot_avatar {
    border-style: none;
    margin: 0;
}
#battle div.event table.event_ability_box td.robot_info strong {
    display: inline-block;
    margin: 0 5px 5px;
    font-size: 60%;
}
#battle div.event table.event_ability_box td.ability_text_top,
#battle div.event table.event_ability_box td.ability_text_bottom,
#battle div.event table.event_ability_box td.ability_text_middle {
    width: 100%;
    height: 100%;
    margin: 0;
    border-style: none;
}
#battle div.event table.event_ability_box td.ability_text_middle {
    border-top-style: none;
    border-bottom-style: none;
    background-color: transparent;
    padding-bottom: 30px;
}
#battle div.event table.event_ability_box td.ability_text_top {
    border-top-style: none;
    font-size: 20%;
}
#battle div.event table.event_ability_box td.ability_text_bottom {
    border-bottom-style: none;
    font-size: 20%;
}
#battle div.event table.event_ability_box td.ability_text_middle span.title {
    display: block;
    width: 240px;
    margin: 5px auto 4px;
    color: #747474;
    font-size: 70%;
    text-align: left;
}
#battle div.event table.event_ability_box td.ability_text_middle span.ability {
    display: block;
    width: 240px;
    margin: 0 auto;
    color: #464646;
    font-size: 100%;
    text-align: left;
    border: 1px solid <?=$pallet[0]?>;
}
#battle div.event table.event_ability_box td.ability_text_middle span.ability[title^="POWR"],
#battle div.event table.event_ability_box td.ability_text_middle span.ability[title^="METL"],
#battle div.event table.event_ability_box td.ability_text_middle span.ability[title^="ERTH"],
#battle div.event table.event_ability_box td.ability_text_middle span.ability[title^="TIME"] {
    color: #EFEFEF;
}
#battle div.event table.event_ability_box td.ability_text_middle span.ability img.type_icon {
    vertical-align: middle;
    margin: 5px 10px;
}
#battle div.event table.event_ability_box td.ability_text_middle span.ability strong {
    vertical-align: middle;
    display: inline-block;
    margin: 5px auto;
    width: 145px;
    text-align: center;
}
#battle div.event table.event_ability_box td.ability_text_middle span.ability em {
    vertical-align: middle;
    display: inline-block;
    margin: 5px auto;
    width: 50px;
    text-align: center;
}
#battle div.event table.event_ability_box td.ability_text_middle span.date {
    display: block;
    width: 240px;
    margin: 2px auto 2px;
    color: #CACACA;
    font-size: 55%;
    text-align: right;
}






#battle div.event table.event_ability_impact_box {
    width: 190px;
    border-collapse: separate;
    border-style: none;
}
#battle div.event table.event_ability_impact_box td.robot_info {
    width: 90px;
    text-align: center;
    border-style: none;
    background-color: transparent;
}
#battle div.event table.event_ability_impact_box td.robot_info div.robot_avatar {
    vertical-align: top;
    text-align: center;
    width: 60px;
    border-style: none;
    margin: 0;
    padding: 0;
    background: transparent url(../images/sprite_shadow_small.png) scroll no-repeat center center;
}
#battle div.event table.event_ability_impact_box td.robot_info img.robot_avatar {
    border-style: none;
    margin: 0;
}
#battle div.event table.event_ability_impact_box td.robot_info strong {
    display: inline-block;
    margin: 0 5px 5px;
    font-size: 60%;
}
#battle div.event table.event_ability_impact_box td.impact_text_top, #battle div.event table.event_ability_impact_box td.impact_text_bottom,
#battle div.event table.event_ability_impact_box td.impact_text_middle {
    width: 100%;
    height: 100%;
    margin: 0;
    border-style: none;
}
#battle div.event table.event_ability_impact_box td.impact_text_middle {
    border-top-style: none;
    border-bottom-style: none;
    background-color: transparent;
}
#battle div.event table.event_ability_impact_box td.impact_text_top {
    border-top-style: none;
    font-size: 40%;
}
#battle div.event table.event_ability_impact_box td.impact_text_bottom {
    border-bottom-style: none;
    font-size: 40%;
}
#battle div.event table.event_ability_impact_box td.impact_text_middle span.title {
    display: block;
    width: 95%;
    margin: 2px auto;
    color: #747474;
    font-size: 60%;
    text-align: center;
}
#battle div.event table.event_ability_impact_box td.impact_text_middle span.impact {
    display: block;
    width: 95%;
    margin: 0 auto;
    color: #990000;
    font-size: 120%;
    text-align: center;
}















/*
#battle div.event table.event_ability_box {
    width: 400px;
    border-collapse: separate;
    border-style: none;
}
#battle div.event table.event_ability_box td.robot_info {
    width: 140px;
    text-align: center;
    border: 2px solid <?=$pallet[0]?>;
    background-color: #FFF;
}
#battle div.event table.event_ability_box td.robot_info div.robot_avatar {
    vertical-align: top;
    text-align: center;
    width: 100px;
    border-style: none;
    margin: 4px;
    padding: 0;
    background: transparent url(../images/sprite_shadow_large.png) scroll no-repeat center center;
}
#battle div.event table.event_ability_box td.robot_info img.robot_avatar {
    border-style: none;
    margin: 0;
}
#battle div.event table.event_ability_box td.robot_info strong {
    display: inline-block;
    margin: 0 5px 5px;
    font-size: 60%;
}
#battle div.event table.event_ability_box td.ability_text_top, #battle div.event table.event_ability_box td.ability_text_bottom,
#battle div.event table.event_ability_box td.ability_text_middle {
    width: 100%;
    height: 100%;
    margin: 0;
    border: 2px solid <?=$pallet[0]?>;
}
#battle div.event table.event_ability_box td.ability_text_middle {
    border-top-style: none;
    border-bottom-style: none;
    background-color: #FFF;
}
#battle div.event table.event_ability_box td.ability_text_top {
    border-top-style: none;
    font-size: 20%;
}
#battle div.event table.event_ability_box td.ability_text_bottom {
    border-bottom-style: none;
    font-size: 20%;
}
#battle div.event table.event_ability_box td.ability_text_middle span.title {
    display: block;
    width: 240px;
    margin: 5px auto 4px;
    color: #747474;
    font-size: 70%;
    text-align: left;
}
#battle div.event table.event_ability_box td.ability_text_middle span.ability {
    display: block;
    width: 240px;
    margin: 0 auto;
    color: #464646;
    font-size: 100%;
    text-align: left;
    border: 1px solid <?=$pallet[0]?>;
}
#battle div.event table.event_ability_box td.ability_text_middle span.ability img.type_icon {
    vertical-align: middle;
    margin: 5px 10px;
}
#battle div.event table.event_ability_box td.ability_text_middle span.ability strong {
    vertical-align: middle;
    display: inline-block;
    margin: 5px auto;
    width: 145px;
    text-align: center;
}
#battle div.event table.event_ability_box td.ability_text_middle span.ability em {
    vertical-align: middle;
    display: inline-block;
    margin: 5px auto;
    width: 50px;
    text-align: center;
}
#battle div.event table.event_ability_box td.ability_text_middle span.date {
    display: block;
    width: 240px;
    margin: 2px auto 2px;
    color: #CACACA;
    font-size: 55%;
    text-align: right;
}
*/






/*
#battle div.event table.event_ability_impact_box {
    width: 190px;
    border-collapse: separate;
    border-style: none;
}
#battle div.event table.event_ability_impact_box td.robot_info {
    width: 90px;
    text-align: center;
    border: 2px solid <?=$pallet[0]?>;
    background-color: #FFF;
}
#battle div.event table.event_ability_impact_box td.robot_info div.robot_avatar {
    vertical-align: top;
    text-align: center;
    width: 60px;
    border-style: none;
    margin: 0;
    padding: 0;
    background: transparent url(../images/sprite_shadow_small.png) scroll no-repeat center center;
}
#battle div.event table.event_ability_impact_box td.robot_info img.robot_avatar {
    border-style: none;
    margin: 0;
}
#battle div.event table.event_ability_impact_box td.robot_info strong {
    display: inline-block;
    margin: 0 5px 5px;
    font-size: 60%;
}
#battle div.event table.event_ability_impact_box td.impact_text_top, #battle div.event table.event_ability_impact_box td.impact_text_bottom,
#battle div.event table.event_ability_impact_box td.impact_text_middle {
    width: 100%;
    height: 100%;
    margin: 0;
    border: 2px solid <?=$pallet[0]?>;
}
#battle div.event table.event_ability_impact_box td.impact_text_middle {
    border-top-style: none;
    border-bottom-style: none;
    background-color: #FFF;
}
#battle div.event table.event_ability_impact_box td.impact_text_top {
    border-top-style: none;
    font-size: 40%;
}
#battle div.event table.event_ability_impact_box td.impact_text_bottom {
    border-bottom-style: none;
    font-size: 40%;
}
#battle div.event table.event_ability_impact_box td.impact_text_middle span.title {
    display: block;
    width: 90px;
    margin: 2px auto;
    color: #747474;
    font-size: 60%;
    text-align: center;
}
#battle div.event table.event_ability_impact_box td.impact_text_middle span.impact {
    display: block;
    width: 90px;
    margin: 0 auto;
    color: #990000;
    font-size: 130%;
    text-align: center;
}
*/













