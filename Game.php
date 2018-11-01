<?php
function new_game($mode = 'Easy', $board_size = 100)
{
    $game_modes = ["Easy" => 5, "Medium" => 10, "Hard" => 20];
    $snakes_ladders = random_board($game_modes[$mode], $board_size);
	return array_chunk($snakes_ladders, ceil(count($snakes_ladders) / 2),true);
}
function throw_dice()
{
    return rand(1, 6);
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
    return array_unique($snakes_ladders);
}
function snake_or_ladder($board_size)
{
    $start = random_cell_value($board_size);
    $ending = random_cell_value($board_size);
    if ($start < $ending) return [$start, $ending];
    return snake_or_ladder($board_size);
}
function random_cell_value($board_size)
{
    return rand(2, $board_size-1);
}