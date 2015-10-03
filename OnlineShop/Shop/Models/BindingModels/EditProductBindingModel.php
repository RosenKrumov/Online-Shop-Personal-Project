<?php


namespace Models\BindingModels;


class EditProductBindingModel
{
    /**
     * @Required
     */
    private $id;

    /**
     * @Required
     */
    private $productname;

    /**
     * @Required
     */
    private $productmodel;
    /**
     * @Required
     */
    private $productprice;
    /**
     * @Required
     */
    private $productquantity;
    /**
     * @Required
     */
    private $category;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getProductname()
    {
        return $this->productname;
    }

    /**
     * @param mixed $productname
     */
    public function setProductname($productname)
    {
        $this->productname = $productname;
    }

    /**
     * @return mixed
     */
    public function getProductmodel()
    {
        return $this->productmodel;
    }

    /**
     * @param mixed $productmodel
     */
    public function setProductmodel($productmodel)
    {
        $this->productmodel = $productmodel;
    }

    /**
     * @return mixed
     */
    public function getProductprice()
    {
        return $this->productprice;
    }

    /**
     * @param mixed $productprice
     */
    public function setProductprice($productprice)
    {
        $this->productprice = $productprice;
    }

    /**
     * @return mixed
     */
    public function getProductquantity()
    {
        return $this->productquantity;
    }

    /**
     * @param mixed $productquantity
     */
    public function setProductquantity($productquantity)
    {
        $this->productquantity = $productquantity;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }
}