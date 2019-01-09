<?php
/**
* Created by PhpStorm.
* User: curtiscrewe
* Date: 29/10/2018
* Time: 18:34
*/

namespace App\Http\Controllers;

use Backpack\Settings\app\Models\Setting;
use Carbon\Carbon;
use FUTApi\Core;
use FUTApi\FutError;
use Illuminate\Console\Command;
use App\Models\Accounts;
use App\Models\Sbc;
use Illuminate\Support\Facades\Log;
use duzun\hQuery;
use App\Http\Controllers\TelegramBotController;

class SBCPurchase extends Controller {

    protected $signature = 'sbc_purchase:run {solution_url : SBC URL to FUTBIN Challenge} {--percentages : Whether to use our sniping percentages to buy players}';

    protected $description = 'Snipe SBC requirement cards';

    /**
    * The FUT API object
    *
    * @var array
    */
    protected $fut = [];

    /**
    * The Account Object
    *
    * @var array
    */
    protected $account = [];

    /**
    * FUT Cards Purchased
    *
    * @var array
    */
    protected $cards = [];

    public function purchase()
    {
        $telegram = new TelegramBotController;
        // $solution_url = $this->argument('s olution_url');
        if(!isset($_GET['toty'])){
            $solution_url = $_GET['buyList'];
        } else {
            $solution_url = '';
        }
        $percentages = false;
        if(Setting::get('sbc_mode') != 1){
            $telegram->sendMessage('*'.Setting::get('account_name')."* SBC purchaser non funziona se la SBC MODE è impostata su 1. Vai su settings e impostala su enabled.");
            // // Log::info('Abort for autobuyer status active. Switch it off on SETTINGS tab.');
            abort(403);
        };
        $this->account = Accounts::where('status', '1')->whereNotNull('phishingToken')->first();
        if(!$this->account) {
            // // Log::info('Account non trovato');
            abort(403);
        }
        Accounts::find($this->account->id)->update([
            'in_use' => '1'
        ]);
        try {

            $this->fut = new Core(
                $this->account->email,
                $this->account->password,
                strtolower($this->account->platform),
                null,
                false,
                false,
                storage_path(
                    'app/fut_cookies/' . md5($this->account->email)
                    )
                );
                $this->fut->setSession(
                    $this->account->personaId,
                    $this->account->nucleusId,
                    $this->account->phishingToken,
                    $this->account->sessionId,
                    date("Y-m", strtotime($this->account->dob))
                );
                if(isset($_GET['toty'])){
                    $this->cards['players'] = array (
                        0 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '700',
                                'pc' => 0,
                            ),
                            'futbin_id' => '3204',
                            'resource_id' => '200726',
                            'base_id' => '200726',
                            'rating' => '81',
                        ),
                        1 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '451',
                            'resource_id' => '186569',
                            'base_id' => '186569',
                            'rating' => '80',
                        ),
                        2 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1467',
                            'resource_id' => '177683',
                            'base_id' => '177683',
                            'rating' => '82',
                        ),
                        3 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1495',
                            'resource_id' => '192984',
                            'base_id' => '192984',
                            'rating' => '82',
                        ),
                        4 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1551',
                            'resource_id' => '203042',
                            'base_id' => '203042',
                            'rating' => '81',
                        ),
                        5 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1812',
                            'resource_id' => '188943',
                            'base_id' => '188943',
                            'rating' => '80',
                        ),
                        6 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '2054',
                            'resource_id' => '226753',
                            'base_id' => '226753',
                            'rating' => '78',
                        ),
                        7 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '2179',
                            'resource_id' => '104389',
                            'base_id' => '104389',
                            'rating' => '82',
                        ),
                        8 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '2303',
                            'resource_id' => '182494',
                            'base_id' => '182494',
                            'rating' => '81',
                        ),
                        9 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '2474',
                            'resource_id' => '148119',
                            'base_id' => '148119',
                            'rating' => '80',
                        ),
                        10 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1172',
                            'resource_id' => '194022',
                            'base_id' => '194022',
                            'rating' => '79',
                        ),
                        11 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1690',
                            'resource_id' => '189681',
                            'base_id' => '189681',
                            'rating' => '79',
                        ),
                        12 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '5125',
                            'resource_id' => '210625',
                            'base_id' => '210625',
                            'rating' => '76',
                        ),
                        13 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '800',
                                'pc' => 0,
                            ),
                            'futbin_id' => '201',
                            'resource_id' => '173771',
                            'base_id' => '173771',
                            'rating' => '81',
                        ),
                        14 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '800',
                                'pc' => 0,
                            ),
                            'futbin_id' => '233',
                            'resource_id' => '235212',
                            'base_id' => '235212',
                            'rating' => '75',
                        ),
                        15 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '800',
                                'pc' => 0,
                            ),
                            'futbin_id' => '623',
                            'resource_id' => '234035',
                            'base_id' => '234035',
                            'rating' => '80',
                        ),
                        16 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '800',
                                'pc' => 0,
                            ),
                            'futbin_id' => '641',
                            'resource_id' => '180216',
                            'base_id' => '180216',
                            'rating' => '80',
                        ),
                        17 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '800',
                                'pc' => 0,
                            ),
                            'futbin_id' => '707',
                            'resource_id' => '205965',
                            'base_id' => '205965',
                            'rating' => '76',
                        ),
                        18 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '800',
                                'pc' => 0,
                            ),
                            'futbin_id' => '930',
                            'resource_id' => '204259',
                            'base_id' => '204259',
                            'rating' => '78',
                        ),
                        19 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '800',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1034',
                            'resource_id' => '206591',
                            'base_id' => '206591',
                            'rating' => '78',
                        ),
                        20 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '650',
                                'pc' => 0,
                            ),
                            'futbin_id' => '5715',
                            'resource_id' => '183606',
                            'base_id' => '183606',
                            'rating' => '75',
                        ),
                        21 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '700',
                                'pc' => 0,
                            ),
                            'futbin_id' => '2595',
                            'resource_id' => '184477',
                            'base_id' => '184477',
                            'rating' => '78',
                        ),
                        22 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '700',
                                'pc' => 0,
                            ),
                            'futbin_id' => '2964',
                            'resource_id' => '213899',
                            'base_id' => '213899',
                            'rating' => '76',
                        ),
                        23 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '700',
                                'pc' => 0,
                            ),
                            'futbin_id' => '13279',
                            'resource_id' => '221540',
                            'base_id' => '221540',
                            'rating' => '80',
                        ),
                        24 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '700',
                                'pc' => 0,
                            ),
                            'futbin_id' => '13519',
                            'resource_id' => '195860',
                            'base_id' => '195860',
                            'rating' => '76',
                        ),
                        25 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '174',
                            'resource_id' => '211320',
                            'base_id' => '211320',
                            'rating' => '82',
                        ),
                        26 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '650',
                            'resource_id' => '220523',
                            'base_id' => '220523',
                            'rating' => '78',
                        ),
                        27 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '669',
                            'resource_id' => '210413',
                            'base_id' => '210413',
                            'rating' => '82',
                        ),
                        28 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '673',
                            'resource_id' => '186547',
                            'base_id' => '186547',
                            'rating' => '80',
                        ),
                        29 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '943',
                            'resource_id' => '216655',
                            'base_id' => '216655',
                            'rating' => '78',
                        ),
                        30 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1028',
                            'resource_id' => '177458',
                            'base_id' => '177458',
                            'rating' => '81',
                        ),
                        31 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1108',
                            'resource_id' => '202935',
                            'base_id' => '202935',
                            'rating' => '79',
                        ),
                        32 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1251',
                            'resource_id' => '192641',
                            'base_id' => '192641',
                            'rating' => '80',
                        ),
                        33 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '2106',
                            'resource_id' => '188829',
                            'base_id' => '188829',
                            'rating' => '80',
                        ),
                        34 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '2688',
                            'resource_id' => '226536',
                            'base_id' => '226536',
                            'rating' => '75',
                        ),
                        35 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '3064',
                            'resource_id' => '199393',
                            'base_id' => '199393',
                            'rating' => '77',
                        ),
                        36 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '3091',
                            'resource_id' => '208615',
                            'base_id' => '208615',
                            'rating' => '75',
                        ),
                        37 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '4269',
                            'resource_id' => '194201',
                            'base_id' => '194201',
                            'rating' => '76',
                        ),
                        38 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '13278',
                            'resource_id' => '220477',
                            'base_id' => '220477',
                            'rating' => '80',
                        ),
                        39 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '13515',
                            'resource_id' => '193869',
                            'base_id' => '193869',
                            'rating' => '76',
                        ),
                        40 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '539',
                            'resource_id' => '205923',
                            'base_id' => '205923',
                            'rating' => '81',
                        ),
                        41 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '951',
                            'resource_id' => '211385',
                            'base_id' => '211385',
                            'rating' => '76',
                        ),
                        42 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1143',
                            'resource_id' => '212491',
                            'base_id' => '212491',
                            'rating' => '76',
                        ),
                        43 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '2184',
                            'resource_id' => '192557',
                            'base_id' => '192557',
                            'rating' => '78',
                        ),
                        44 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '800',
                                'pc' => 0,
                            ),
                            'futbin_id' => '224',
                            'resource_id' => '209889',
                            'base_id' => '209889',
                            'rating' => '78',
                        ),
                        45 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '800',
                                'pc' => 0,
                            ),
                            'futbin_id' => '280',
                            'resource_id' => '205988',
                            'base_id' => '205988',
                            'rating' => '78',
                        ),
                        46 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '800',
                                'pc' => 0,
                            ),
                            'futbin_id' => '325',
                            'resource_id' => '183427',
                            'base_id' => '183427',
                            'rating' => '80',
                        ),
                        47 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '800',
                                'pc' => 0,
                            ),
                            'futbin_id' => '504',
                            'resource_id' => '205566',
                            'base_id' => '205566',
                            'rating' => '77',
                        ),
                        48 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '800',
                                'pc' => 0,
                            ),
                            'futbin_id' => '541',
                            'resource_id' => '169595',
                            'base_id' => '169595',
                            'rating' => '80',
                        ),
                        49 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '800',
                                'pc' => 0,
                            ),
                            'futbin_id' => '573',
                            'resource_id' => '177604',
                            'base_id' => '177604',
                            'rating' => '80',
                        ),
                        50 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '650',
                                'pc' => 0,
                            ),
                            'futbin_id' => '3786',
                            'resource_id' => '224574',
                            'base_id' => '224574',
                            'rating' => '75',
                        ),
                        51 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '700',
                                'pc' => 0,
                            ),
                            'futbin_id' => '2324',
                            'resource_id' => '124607',
                            'base_id' => '124607',
                            'rating' => '75',
                        ),
                        52 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '700',
                                'pc' => 0,
                            ),
                            'futbin_id' => '3937',
                            'resource_id' => '207412',
                            'base_id' => '207412',
                            'rating' => '76',
                        ),
                        53 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '700',
                                'pc' => 0,
                            ),
                            'futbin_id' => '4805',
                            'resource_id' => '214770',
                            'base_id' => '214770',
                            'rating' => '76',
                        ),
                        54 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '375',
                            'resource_id' => '205192',
                            'base_id' => '205192',
                            'rating' => '79',
                        ),
                        55 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1029',
                            'resource_id' => '199042',
                            'base_id' => '199042',
                            'rating' => '81',
                        ),
                        56 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1218',
                            'resource_id' => '225663',
                            'base_id' => '225663',
                            'rating' => '79',
                        ),
                        57 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '2065',
                            'resource_id' => '172143',
                            'base_id' => '172143',
                            'rating' => '76',
                        ),
                        58 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '2081',
                            'resource_id' => '212886',
                            'base_id' => '212886',
                            'rating' => '78',
                        ),
                        59 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '2761',
                            'resource_id' => '230965',
                            'base_id' => '230965',
                            'rating' => '75',
                        ),
                        60 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '3464',
                            'resource_id' => '162347',
                            'base_id' => '162347',
                            'rating' => '81',
                        ),
                        61 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '3952',
                            'resource_id' => '216451',
                            'base_id' => '216451',
                            'rating' => '82',
                        ),
                        62 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '4842',
                            'resource_id' => '231969',
                            'base_id' => '231969',
                            'rating' => '76',
                        ),
                        63 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '4863',
                            'resource_id' => '174549',
                            'base_id' => '174549',
                            'rating' => '75',
                        ),
                        64 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '5244',
                            'resource_id' => '193425',
                            'base_id' => '193425',
                            'rating' => '75',
                        ),
                        65 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '12395',
                            'resource_id' => '169051',
                            'base_id' => '169051',
                            'rating' => '76',
                        ),
                        66 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '800',
                                'pc' => 0,
                            ),
                            'futbin_id' => '195',
                            'resource_id' => '192318',
                            'base_id' => '192318',
                            'rating' => '82',
                        ),
                        67 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '800',
                                'pc' => 0,
                            ),
                            'futbin_id' => '196',
                            'resource_id' => '177413',
                            'base_id' => '177413',
                            'rating' => '82',
                        ),
                        68 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '800',
                                'pc' => 0,
                            ),
                            'futbin_id' => '212',
                            'resource_id' => '193283',
                            'base_id' => '193283',
                            'rating' => '79',
                        ),
                        69 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '800',
                                'pc' => 0,
                            ),
                            'futbin_id' => '263',
                            'resource_id' => '191740',
                            'base_id' => '191740',
                            'rating' => '82',
                        ),
                        70 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '800',
                                'pc' => 0,
                            ),
                            'futbin_id' => '552',
                            'resource_id' => '183394',
                            'base_id' => '183394',
                            'rating' => '76',
                        ),
                        71 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '800',
                                'pc' => 0,
                            ),
                            'futbin_id' => '678',
                            'resource_id' => '230938',
                            'base_id' => '230938',
                            'rating' => '78',
                        ),
                        72 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '800',
                                'pc' => 0,
                            ),
                            'futbin_id' => '788',
                            'resource_id' => '198031',
                            'base_id' => '198031',
                            'rating' => '79',
                        ),
                        73 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '800',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1449',
                            'resource_id' => '177600',
                            'base_id' => '177600',
                            'rating' => '80',
                        ),
                        74 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '800',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1478',
                            'resource_id' => '229261',
                            'base_id' => '229261',
                            'rating' => '77',
                        ),
                        75 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '800',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1500',
                            'resource_id' => '206511',
                            'base_id' => '206511',
                            'rating' => '78',
                        ),
                        76 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '800',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1585',
                            'resource_id' => '189251',
                            'base_id' => '189251',
                            'rating' => '81',
                        ),
                        77 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '800',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1702',
                            'resource_id' => '235569',
                            'base_id' => '235569',
                            'rating' => '78',
                        ),
                        78 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '800',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1967',
                            'resource_id' => '195365',
                            'base_id' => '195365',
                            'rating' => '82',
                        ),
                        79 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '800',
                                'pc' => 0,
                            ),
                            'futbin_id' => '2060',
                            'resource_id' => '228702',
                            'base_id' => '228702',
                            'rating' => '77',
                        ),
                        80 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '700',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1165',
                            'resource_id' => '190972',
                            'base_id' => '190972',
                            'rating' => '81',
                        ),
                        81 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '700',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1175',
                            'resource_id' => '216547',
                            'base_id' => '216547',
                            'rating' => '79',
                        ),
                        82 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '700',
                                'pc' => 0,
                            ),
                            'futbin_id' => '4451',
                            'resource_id' => '199151',
                            'base_id' => '199151',
                            'rating' => '76',
                        ),
                        83 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '700',
                                'pc' => 0,
                            ),
                            'futbin_id' => '13282',
                            'resource_id' => '221992',
                            'base_id' => '221992',
                            'rating' => '80',
                        ),
                        84 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '396',
                            'resource_id' => '189505',
                            'base_id' => '189505',
                            'rating' => '82',
                        ),
                        85 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1450',
                            'resource_id' => '189354',
                            'base_id' => '189354',
                            'rating' => '80',
                        ),
                        86 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '2052',
                            'resource_id' => '236632',
                            'base_id' => '236632',
                            'rating' => '79',
                        ),
                        87 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '2400',
                            'resource_id' => '229167',
                            'base_id' => '229167',
                            'rating' => '76',
                        ),
                        88 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '3471',
                            'resource_id' => '213956',
                            'base_id' => '213956',
                            'rating' => '75',
                        ),
                        89 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '7318',
                            'resource_id' => '236245',
                            'base_id' => '236245',
                            'rating' => '75',
                        ),
                        90 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '700',
                                'pc' => 0,
                            ),
                            'futbin_id' => '786',
                            'resource_id' => '227476',
                            'base_id' => '227476',
                            'rating' => '79',
                        ),
                        91 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '700',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1073',
                            'resource_id' => '199451',
                            'base_id' => '199451',
                            'rating' => '81',
                        ),
                        92 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '700',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1133',
                            'resource_id' => '190717',
                            'base_id' => '190717',
                            'rating' => '78',
                        ),
                        93 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '700',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1503',
                            'resource_id' => '223689',
                            'base_id' => '223689',
                            'rating' => '77',
                        ),
                        94 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '700',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1762',
                            'resource_id' => '204529',
                            'base_id' => '204529',
                            'rating' => '81',
                        ),
                        95 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '700',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1765',
                            'resource_id' => '176600',
                            'base_id' => '176600',
                            'rating' => '81',
                        ),
                        96 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '700',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1815',
                            'resource_id' => '205693',
                            'base_id' => '205693',
                            'rating' => '78',
                        ),
                        97 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '700',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1913',
                            'resource_id' => '189963',
                            'base_id' => '189963',
                            'rating' => '76',
                        ),
                        98 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '700',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1976',
                            'resource_id' => '207791',
                            'base_id' => '207791',
                            'rating' => '77',
                        ),
                        99 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '700',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1977',
                            'resource_id' => '225713',
                            'base_id' => '225713',
                            'rating' => '76',
                        ),
                        100 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '700',
                                'pc' => 0,
                            ),
                            'futbin_id' => '825',
                            'resource_id' => '183900',
                            'base_id' => '183900',
                            'rating' => '81',
                        ),
                        101 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '700',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1535',
                            'resource_id' => '164985',
                            'base_id' => '164985',
                            'rating' => '76',
                        ),
                        102 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '700',
                                'pc' => 0,
                            ),
                            'futbin_id' => '2843',
                            'resource_id' => '210463',
                            'base_id' => '210463',
                            'rating' => '75',
                        ),
                        103 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '700',
                                'pc' => 0,
                            ),
                            'futbin_id' => '3233',
                            'resource_id' => '204077',
                            'base_id' => '204077',
                            'rating' => '77',
                        ),
                        104 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '700',
                                'pc' => 0,
                            ),
                            'futbin_id' => '3805',
                            'resource_id' => '188268',
                            'base_id' => '188268',
                            'rating' => '77',
                        ),
                        105 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '700',
                                'pc' => 0,
                            ),
                            'futbin_id' => '7695',
                            'resource_id' => '232862',
                            'base_id' => '232862',
                            'rating' => '77',
                        ),
                        106 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '700',
                                'pc' => 0,
                            ),
                            'futbin_id' => '13253',
                            'resource_id' => '208128',
                            'base_id' => '208128',
                            'rating' => '80',
                        ),
                        107 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '1760',
                            'resource_id' => '224411',
                            'base_id' => '224411',
                            'rating' => '82',
                        ),
                        108 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '2924',
                            'resource_id' => '224218',
                            'base_id' => '224218',
                            'rating' => '75',
                        ),
                        109 =>
                        array (
                            'prices' =>
                            array (
                                'xbox' => 0,
                                'ps' => '750',
                                'pc' => 0,
                            ),
                            'futbin_id' => '3309',
                            'resource_id' => '196143',
                            'base_id' => '196143',
                            'rating' => '76',
                        ),
                    );
                } else {
                    $doc = hQuery::fromUrl($solution_url);
                    $challenge_name = $doc->find('div.chal-name > span')->text();
                    $players = $doc->find('div.card > .cardetails > a');
                    if($players) {
                        foreach($players as $pos => $a) {
                            $player_card = $a->find('div')[0];
                            if($player_card) {
                                $this->cards['players'][] = [
                                    'prices' => [
                                        'xbox' => $player_card->attr('data-price-xbl'),
                                        'ps' => $player_card->attr('data-price-ps3'),
                                        'pc' => $player_card->attr('data-price-pc')
                                    ],
                                    'futbin_id' => $player_card->attr('data-player-id'),
                                    'resource_id' => $player_card->attr('data-resource-id'),
                                    "base_id" => $player_card->attr('data-base-id'),
                                    'rating' => $player_card->attr('data-rating'),
                                    'bought' => false
                                ];
                            }
                        }
                    }
                }

                $cache_file = storage_path('app/public/'.$this->account->id.'-club_players.json');
                $cache_life = '500';
                $filemtime = @filemtime($cache_file);

                $bought_players_file = storage_path('app/public/'.$this->account->id.'-'.md5($solution_url).'-bought_players.json');
                if(!file_exists($bought_players_file)) {
                    file_put_contents($bought_players_file, '[]');
                    $this->cards['bought_players'] = [];
                } else {
                    $this->cards['bought_players'] = json_decode(file_get_contents($bought_players_file), true);
                }
                if (!$filemtime or (time() - $filemtime >= $cache_life)){
                    // Log::info("Please hold while we update your club contents cache.");
                    $club_players = $this->fut->club();
                    $start = 0;
                    do {
                        foreach ($club_players['itemData'] as $player) {
                            if (isset($player['loans']))
                            continue;
                            if ($player['resourceId'])
                            $this->cards['club_players'][] = $player['resourceId'];
                        }
                        $club_players = $this->fut->club(
                            'desc',
                            'player',
                            null,
                            $start
                        );
                        $count = count($club_players['itemData']);
                        $start = ($start + 91);
                        $rand = rand(4, 7);
                        sleep($rand);
                    } while ($count === 91);
                    file_put_contents($cache_file,json_encode($this->cards['club_players']));
                } else {
                    $this->cards['club_players'] = json_decode(file_get_contents($cache_file), true);
                }

                $collected_cards = 0;
                $required_cards = count($this->cards['players']);

                if(count($this->cards['players']) > 0) {
                    foreach ($this->cards['players'] as $player) {

                        if(in_array($player['resource_id'], $this->cards['bought_players'])) {
                            $collected_cards++;
                            // Log::info("It looks like we already bought: ".$player['resource_id']);
                            continue;
                        }
                        if(in_array($player['resource_id'], $this->cards['club_players'])) {
                            $collected_cards++;
                            // Log::info("Let's not buy: ".$player['resource_id']." as we already have it in our club");
                            continue;
                        }

                        switch($this->account->platform) {
                            case "XBOX":
                            if(isset($_GET['percentages'])) {
                                $price_arr = $prices = calculate_prices($player['prices']['xbox'], Setting::get('buy_percentage'), Setting::get('sell_percentage'));
                                $price = $price_arr['max_bin'];
                            } else {
                                $price = $player['prices']['xbox'];
                            }
                            break;
                            case "PS4":
                            if(isset($_GET['percentages'])) {
                                $percentages = true;
                                $price_arr = $prices = calculate_prices($player['prices']['ps'], Setting::get('buy_percentage'), Setting::get('sell_percentage'));
                                $price = $price_arr['max_bin'];
                            } else {
                                $price = $player['prices']['ps'];
                            }
                            break;
                            case "PC":
                            if(isset($_GET['percentages'])) {
                                $price_arr = $prices = calculate_prices($player['prices']['pc'], Setting::get('buy_percentage'), Setting::get('sell_percentage'));
                                $price = $price_arr['max_bin'];
                            } else {
                                $price = $player['prices']['pc'];
                            }
                            break;
                        }
                        // Log::info("We are going to search for ".$player['resource_id']." with a Max BIN of ".$price);
                        $telegram->sendMessage('*'.Setting::get('account_name')."* is going to search for ".$player['resource_id']." with a Max BIN of ".$price, true);
                        $counter = 0;
                        $search_limit = Setting::get('rpm_limit');
                        do {
                            if(isset($_GET['incrementOffer'])){
                                $price = $price + $_GET['incrementOffer'];
                            } else if(isset($_GET['toty'])){
                                if( $counter > ($search_limit / 2) ){
                                    $price = $price + '100';
                                }
                            }
                            $sleep_time = rand(1,8);
                            // Log::info("Sleeping for ".$sleep_time." seconds before we search for ".$player['resource_id']." at ".$price." - ".Carbon::now()->toDayDateTimeString());
                            sleep($sleep_time);
                            $randomBid = rand(14000000, 15000000);
                            $formattedBid = floor($randomBid / 1000) * 1000;
                            $search = $this->fut->searchAuctions(
                                'player',
                                null,
                                null,
                                $player['resource_id'],
                                null,
                                null,
                                $formattedBid,
                                null,
                                $price
                            );
                            if(!empty($search['auctionInfo'])) {
                                usort($search['auctionInfo'], function($previous, $next) {
                                    return $previous["buyNowPrice"] > $next["buyNowPrice"] ? 1 : -1;
                                });
                                $cheapest_item = $search['auctionInfo'][0];
                                $bid = $this->fut->bid($cheapest_item['tradeId'], $cheapest_item['buyNowPrice']);
                                if(isset($bid['auctionInfo'])) {
                                    $collected_cards++;
                                    // Log::info("It looks like we bought ".$player['resource_id']." successfully for ".$cheapest_item['buyNowPrice']."!");

                                    $telegram->sendMessage('*'.Setting::get('account_name')."* bought ".$player['resource_id']." successfully for ".$cheapest_item['buyNowPrice']."!", true);

                                    array_push($this->cards['bought_players'], (int)$player['resource_id']);
                                    $counter = $search_limit;
                                    file_put_contents($bought_players_file, json_encode($this->cards['bought_players']));
                                    sleep(2);
                                    $items = $this->fut->unassigned();
                                    if(count($items['itemData']) > 0) {
                                        foreach($items['itemData'] as $item) {
                                            $this->fut->sendToClub($item['id']);
                                        }
                                    }
                                }
                            }
                            $counter++;

                        } while($counter < $search_limit);
                    }
                }

                Accounts::find($this->account->id)->update([
                    'in_use' => '0'
                ]);
                $telegram->sendMessage('*'.Setting::get('account_name'). '* We have completed a run having collected '.$collected_cards.' cards out the required '.$required_cards );

                if($collected_cards == $required_cards){
                    $bought_players_file = unlink($bought_players_file);
                    $cache_file = unlink($cache_file);

                    if($bought_players_file){
                        // Log::info('Bought players deleted');
                    }
                    if($cache_file){
                        // Log::info('Club players deleted');
                    }
                }

                $sbc = new Sbc;
                $sbc->name = $challenge_name;
                $sbc->url = $_GET['buyList'];
                $sbc->bought = $collected_cards;
                $sbc->squadCount = $required_cards;
                $sbc->percentages = $percentages;
                $sbc->incrementBy = $_GET['incrementOffer'];
                $sbc->save();

            } catch(FutError $exception) {

                $error = $exception->GetOptions();

                if($error['reason'] == 'permission_denied') {
                    // Log::info('We was too slow trying to snipe!');
                    return;
                }

                Accounts::find($this->account->id)->update([
                    'phishingToken' => null,
                    'sessionId' => null,
                    'nucleusId' => null,
                    'status' => '-1',
                    'status_reason' => $error['reason'],
                    'in_use' => '0'
                ]);

            }
        }

    }
