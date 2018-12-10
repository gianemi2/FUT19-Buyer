<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use duzun\hQuery;

class MostUsed extends Controller
{
    public function mostUsed(){
        $solution_url = $_GET['sbc'];
        // $solution_url = 'https://www.futbin.com/squad-building-challenges/ALL/550/Liga%20Bancomer%20MX%20POTS';
        $players_list = [];
        $doc = hQuery::fromUrl($solution_url);
        $url_list = $doc->find('a.squad_url');
        if($url_list){
            foreach ($url_list as $url) {
                $url = $url->attr('href');
                $doc = hQuery::fromUrl($url);
                $players = $doc->find('div.card > .cardetails > a');
                foreach ($players as $pos => $a) {
                    $player_card = $a->find('div')[0];
                    $player_id = $player_card->attr('data-player-id');
                    $count = 1;
                    if(array_key_exists( $player_id, $players_list)){
                        $count = $players_list[$player_id]['count'] + 1;
                    }
                    $players_list[$player_card->attr('data-player-id')] = [
                        'name'  =>  $player_card->attr('data-player-commom'),
                        'count'  =>  $count,
                        'rating'    =>  $player_card->attr('data-rating'),
                        'price'     =>  $player_card->attr('data-price-ps3')
                    ];
                };
            };
        }
        if(count($players_list) > 1){
            $count = array();
            $rate = array();
            foreach($players_list as $key => $player){
                $count[] = $player['count'];
                $rate[] = $player['rating'];
                $price[] = $player['price'];
            }
        }
        // now apply sort
    	array_multisort($count, SORT_DESC, SORT_NUMERIC, $rate, SORT_DESC, $players_list); ?>
        <style media="screen">
        table, th, td {
            border: 1px solid #eee;
        }
        </style>
        <table>
            <tr>
                <th>Nome</th>
                <th>Soluzioni</th>
                <th>Overrall</th>
                <th>Costo</th>
            </tr>
            <?php foreach ($players_list as $player) { ?>
                <tr>
                    <td><?php echo $player['name']; ?></td>
                    <td><?php echo $player['count']; ?></td>
                    <td><?php echo $player['rating']; ?></td>
                    <td><?php echo $player['price']; ?></td>
                </tr>
            <?php } ?>
        </table>
        <?php
    }
}
