<?php
    class Store
    {
        private $id;
        private $name;

        function __construct($id=null, $name)
        {
            $this->id = $id;
            $this->name = $name;
        }

        function getId()
        {
            return $this->id;
        }

        function getName()
        {
            return $this->name;
        }

        function setName($new_name)
        {
            $this->name = $new_name;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO stores (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_stores = $GLOBALS['DB']->query("SELECT * FROM stores;");
            $all_stores = array();
            foreach ($returned_stores as $store)
            {
                $id = $store['id'];
                $name = $store['name'];
                $new_store = new Store($id, $name);
                array_push($all_stores, $new_store);
            }
            return $all_stores;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores;");
        }

        static function find($search_id)
        {
            $found_store = null;
            $stores = Store::getAll();
            foreach ($stores as $store) {
                $store_id = $store->getId();
                if ($store_id == $search_id) {
                    $found_store = $store;
                }
            }
            return $found_store;
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE stores SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function addBrand($new_brand)
        {
            $GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ({$new_brand->getId()}, {$this->getId()});");
        }

        function getBrands()
        {
            $returned_brands = $GLOBALS['DB']->query("SELECT brands.* FROM stores
            JOIN brands_stores ON (brands_stores.store_id = stores.id)
            JOIN brands ON (brands.id = brands_stores.brand_id)
            WHERE stores.id = {$this->getId()};");

            $current_brands = array();

            foreach ($returned_brands as $brand)
            {
                $id = $brand['id'];
                $name = $brand['name'];
                $given_brand = new Brand($id, $name);
                array_push($current_brands, $given_brand);
            }
            return $current_brands;

        }




    }



 ?>
