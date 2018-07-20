<?php

namespace App;


class Blockchain
{
    /**
     * 记录整个区块链数据
     * @var array
     */
    public $blocks = [];

    /**
     * 创建创世区块
     * Blockchain constructor.
     */
    public function __construct()
    {
        $this->blocks[] = new Block('', 'Genesis Block');
    }

    /**
     * 上链一个新区块
     * @param $data
     */
    public function addBlock($data)
    {
        $prevBlock = $this->blocks[count($this->blocks) - 1];
        $this->blocks[] = new Block($prevBlock->getBlockHash(), $data);
    }
}