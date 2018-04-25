<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Type;
/**

 * Created by PhpStorm.
 * User: kyle
 * Date: 13/11/17
 * Time: 09:39
 */

class TypeSeeder extends Seeder
{
    public function run(){
        Type::create(
            [
                'type' => 'Zouglou'
            ]
        );
        Type::create(
            [
                'type' => 'Coupe-Decale'
            ]
        );
        Type::create(
            [
                'type' => 'Rumba'
            ]
        );
    }
}