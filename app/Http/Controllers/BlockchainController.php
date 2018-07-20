<?php

namespace App\Http\Controllers;

use App\Blockchain;
use Illuminate\Http\Request;

class BlockchainController extends Controller
{
    //
    public function index(){
        $blockchain = new Blockchain();
        $blockchain->addBlock('This a block1');
        $blockchain->addBlock('This a block2');

        foreach ($blockchain->blocks as $block){
            echo '<pre>';
            printf("PrevHah: %s\n",$block->prevHash);
            printf("Hah: %s\n",$block->hash);
            printf("Data: %s\n",$block->data);
            printf("\n");
            echo '</pre>';
        }
    }
}
