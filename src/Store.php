<?php
    class Store
    {
        private $id;
        private $name;

        function __construct($id = null, $name)
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


    }



 ?>
