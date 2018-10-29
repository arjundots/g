<?php
function new_game($players, $mode = 'Easy', $board_size = 100)
{
    $game_modes = ["Easy" => 5, "Medium" => 10, "Hard" => 20];
    $snakes_ladders = random_board($game_modes[$mode], $board_size);
    //play($players, $snakes_ladders, $board_size);
	$snakes_ladders_list = snakes_ladders_list($snakes_ladders);
	// echo "<pre>";
	// print_r($snakes_ladders);
	// print_r($snakes_ladders_list);
	return $snakes_ladders_list;
}
function snakes_ladders_list($snakes_ladders){
	$list = array_chunk($snakes_ladders, ceil(count($snakes_ladders) / 2),true);
	$snakes_ladders_list['snakes'] = $list[0];
	$snakes_ladders_list['ladders'] = $list[1];
	return $snakes_ladders_list;
}
function play($players, $snakes_ladders, $board_size)
{
    $players_positions = array_map(function () {return 0;}, $players);
    $starting_player = rand(1, count($players)) - 1;
    $winner = move($players, $players_positions, $starting_player, $snakes_ladders, $board_size);
    echo $players[$winner] . " won!";
}

function throw_dice()
{
    return rand(1, 6);
}

function move($players, $player_positions, $player_turn, $snakes_ladders, $board_size)
{
    $new_position = $player_positions[$player_turn] + throw_dice();
    if (array_key_exists($new_position, $snakes_ladders))
        $new_position = $snakes_ladders[$new_position];
    if ($new_position == $board_size) return $player_turn;
    $player = $players[$player_turn];
    if ($new_position < $board_size) {
        echo "Move $player to $new_position <br>";
        $player_positions[$player_turn] = $new_position;
    } else
        echo "Skipping player $player <br>";


    $next_player = next_player($player_turn, $player_positions);
    return move($players, $player_positions, $next_player, $snakes_ladders, $board_size);
}

function next_player($player_turn, $player_positions)
{
    return ($player_turn + 1) % count($player_positions);
}

function random_board($no_of_snakes_ladders, $board_size)
{
    $snakes_ladders = [];
    for ($i = 0; $i < $no_of_snakes_ladders; $i++) {
        list($start, $end) = snake_or_ladder($board_size);
        $snakes_ladders[$start] = $end;
    }
    return $snakes_ladders;
}

function snake_or_ladder($board_size)
{
    $start = random_cell_value($board_size);
    $ending = random_cell_value($board_size);
    if ($start != $ending) return [$start, $ending];
    return snake_or_ladder($board_size);
}

function random_cell_value($board_size)
{
    return rand(1, $board_size);
}

$players = ["PHP", "Julia", "APL", "Erlang", "Clojure", "Scala"];
// new_game($players); - Easy Mode
new_game($players, "Easy", 100);