<?php


namespace Models\BindingModels;


class EditCashBindingModel
{
    /**
     * @Required
     */
    private $cash;

    /**
     * @Required
     */
    private $confirm;

    /**
     * @return mixed
     */
    public function getCash()
    {
        return $this->cash;
    }

    /**
     * @param mixed $cash
     */
    public function setCash($cash)
    {
        $this->cash = $cash;
    }

    /**
     * @return mixed
     */
    public function getConfirm()
    {
        return $this->confirm;
    }

    /**
     * @param mixed $confirm
     */
    public function setConfirm($confirm)
    {
        $this->confirm = $confirm;
    }
}