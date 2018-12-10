@extends('backpack::layout')
@section('header')
    <section class="content-header">
        <h1>
            SBC <small>Find most used player in SBC</small>
        </h1>
    </section>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-body">
                <?php if(!isset($_GET['sbc'])){ ?>
                    <form action="/used" method="GET">
                        <div class="form-group">
                            <label for="url">Inserisci l'url della SBC</label>
                            <input class="form-control" type="url" name="sbc" id="url" aria-describedby="sbc-help">
                            <small id="sbc-help" class="form-text text-muted">L'url della sbc può essere ricavato scegliendo <code>Completed Challenge</code> <a href="https://www.futbin.com/squad-building-challenges" target="_blank">a questo link.</a></small>
                        </div>
                        <button type="submit" class="btn btn-primary">Trova</button>
                    </form>
                <?php } else {
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
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Soluzioni</th>
                                <th>Overrall</th>
                                <th>Costo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($players_list as $player) { ?>
                                <tr>
                                    <td><?php echo $player['name']; ?></td>
                                    <td><?php echo $player['count']; ?></td>
                                    <td><?php echo $player['rating']; ?></td>
                                    <td><?php echo $player['price']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
@endsection
