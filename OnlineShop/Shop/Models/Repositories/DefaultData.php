<?php


namespace Models\Repositories;


use Framework\DB\SimpleDB;

abstract class DefaultData
{
    /**
     * @var SimpleDB
     */
    protected $db;

    public function __construct()
    {
        $this->db = new SimpleDB();
    }
}