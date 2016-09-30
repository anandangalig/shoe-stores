<?php

    /**
    *@backupGlobals disabled
    *@backupStaticAttributes disabled
    */

    require_once "src/Brand.php";
    require_once "src/Store.php";

    $server = 'mysql:host=localhost:8889;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO ($server, $username, $password);

    class StoreTest extends PHPUnit_Framework_TestCase {

        protected function tearDown()
        {
            Store::deleteAll();
            // Brand::deleteAll();
        }

        function testSave()
        {
            //ARRANGE
            $id = null;
            $name = "Foot Locker";
            $test_store = new Store($id, $name);

            //ACT
            $test_store->save();

            //ASSERT
            $this->assertEquals([$test_store], Store::getAll());
        }

        function testGetAll()
        {
            //ARRANGE
            $id = null;
            $name = "Foot Locker";
            $test_store = new Store($id, $name);
            $test_store->save();

            $name2 = "CHAMPS";
            $test_store2 = new Store($id, $name2);
            $test_store2->save();

            //ACT
            $result = Store::getAll();

            //ASSERT
            $this->assertEquals([$test_store, $test_store2], $result);
        }

        function testDeleteAll()
        {
            //ARRANGE
            $id = null;
            $name = "Foot Locker";
            $test_store = new Store($id, $name);
            $test_store->save();

            $name2 = "CHAMPS";
            $test_store2 = new Store($id, $name2);
            $test_store2->save();

            //ACT
            Store::deleteAll();

            //ASSERT
            $this->assertEquals([], Store::getAll());
        }



    }

 ?>
