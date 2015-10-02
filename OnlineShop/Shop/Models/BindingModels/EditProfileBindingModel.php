<?php


namespace Models\BindingModels;


class EditProfileBindingModel
{
    /**
     * @Required
     */
    private $oldPass;

    /**
     * @Required
     */
    private $newPass;

    /**
     * @Required
     */
    private $confirmPass;

    /**
     * @return mixed
     */
    public function getOldPass()
    {
        return $this->oldPass;
    }

    /**
     * @param mixed $oldPass
     */
    public function setOldPass($oldPass)
    {
        $this->oldPass = $oldPass;
    }

    /**
     * @return mixed
     */
    public function getNewPass()
    {
        return $this->newPass;
    }

    /**
     * @param mixed $newPass
     */
    public function setNewPass($newPass)
    {
        $this->newPass = $newPass;
    }

    /**
     * @return mixed
     */
    public function getConfirmPass()
    {
        return $this->confirmPass;
    }

    /**
     * @param mixed $confirmPass
     */
    public function setConfirmPass($confirmPass)
    {
        $this->confirmPass = $confirmPass;
    }
}