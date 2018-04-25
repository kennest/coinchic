<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Artist;
/**

 * Created by PhpStorm.
 * User: kyle
 * Date: 13/11/17
 * Time: 09:39
 */

class ArtistSeeder extends Seeder
{
    public function run(){
        Artist::create(
            [
                'name' => 'Yode et Siro',
                'avatar' => 'artists/avatars/dzmCnGVddy3nHlZgClBcXxLZIFaypmFZpdiiek3l.jpeg',
                'urlsample' => 'artists/samples/cDc4RAmrLgDkDNdlQ6VZDWJZJX7ptbKaYh74K3E6.mpga'
            ]
        );
        Artist::create(
            [
                'name' => 'JC Pluriel',
                'avatar' => 'artists/avatars/Gq4gKA7IMJkGMwRnvE7radzt3SLVZvNye1ImagWV.jpeg',
                'urlsample' => 'artists/samples/vSi6Y42Wkdia9fB74VjH5Cfc9waBPJwPUztMRCrF.mpga'
            ]
        );
        Artist::create(
            [
                'name' => 'Yabongo',
                'avatar' => 'nnjCAj8JvG3H44wqw7bgKauSCFe120fakBnEuBv1.jpeg',
                'urlsample' => 'artists/samples/WtOHnJriGhzuBtx1Ke7MSKyxmJxwHAyEaaMK9eVI.mpga'
            ]
        );
    }
}