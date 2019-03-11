<?php

namespace App\Entities;

abstract class IEntity
{
    protected $repository;
    protected $eloquent;

    /**
     * Inject the eloquent to entity
     *
     * @param [object] $eloquent
     * @return void
     */
    public function setModel($eloquent)
    {
        $this->eloquent = $eloquent;
    }

    /**
     * Return the eloquent object
     *
     * @return void
     */
    public function getModel()
    {
        return $this->eloquent;
    }

    /**
     * Return self instance after fetched eloquent
     *
     * @param [mix] $key
     * @return IEntity instance
     */
    abstract public function find($key);

    /**
     * For get the constant group name that entity required.
     *
     * @return array
     */
    abstract public function group();

    /**
     * To update an existed database record
     *
     * @return void
     */
    abstract public function savedata($data);

    /**
     * To delete an existed database record
     *
     * @return void
     */
    abstract public function destroy($excute=true);
}