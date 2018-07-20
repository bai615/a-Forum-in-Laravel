<?php

namespace App;


class Block
{
    /**
     * 前一个区块的 Hash 值
     * @var
     */
    public $prevHash;

    /**
     * 当前区块的 Hash 值
     * @var
     */
    public $hash;

    /**
     * 区块生成的时间戳
     * @var
     */
    public $timeStamp;

    /**
     * 区块保存的数据
     * @var
     */
    public $data;

    /**
     * 初始化数据
     * Block constructor.
     * @param $prevHash
     * @param $data
     */
    public function __construct($prevHash, $data)
    {
        $this->prevHash = $prevHash;
        $this->timeStamp = time();
        $this->data = $data;
        $this->setBlockHash();
    }

    /**
     * 设置区块 Hash 值
     */
    public function setBlockHash()
    {
        $data = serialize($this);
        $this->hash = hash('sha256', $data);
    }

    /**
     * 获取区块 Hash 值
     * @return mixed
     */
    public function getBlockHash()
    {
        return $this->hash;
    }
}