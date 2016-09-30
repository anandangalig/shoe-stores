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

        function testFind()
        {
            //ARRANGE
            $id = null;
            $name = "Foot Locker";
            $test_store = new Store($id, $name);
            $test_store->save();

            $id2 = null;
            $name2 = "CHAMPS";
            $test_store2 = new Store($id2, $name2);
            $test_store2->save();

            //ACT
            $result = Store::find($test_store2->getId());

            //ASSERT
            $this->assertEquals($test_store2, $result);
        }

        function testUpdate()
        {
            //ARRANGE
            $id = null;
            $name = "Foot Locker";
            $test_store = new Store($id, $name);
            $test_store->save();
            $new_name = "CHAMPS";

            //ACT
            $test_store->update($new_name);

            //ASSERT
            $this->assertEquals("CHAMPS", $test_store->getName());
        }

        function testAddBrand()
        {
            //ARRANGE
            $id = null;
            $name = "Foot Locker";
            $test_store = new Store($id, $name);
            $test_store->save();

            $brand_name = "Nike";
            $test_brand = new Brand($id, $brand_name);
            $test_brand->save();

            //ACT
            $test_store->addBrand($test_brand);

            //ASSERT
            $this->assertEquals([$test_brand], $test_store->getBrands());
        }

        function testGetBrands()
        {
            //ARRANGE
            $id = null;
            $name = "Foot Locker";
            $test_store = new Store($id, $name);
            $test_store->save();

            $brand_name = "Nike";
            $test_brand = new Brand($id, $brand_name);
            $test_brand->save();
            $test_store->addBrand($test_brand);

            $brand_name2 = "Reebok";
            $test_brand2 = new Brand($id, $brand_name2);
            $test_brand2->save();
            $test_store->addBrand($test_brand2);

            //ACT
            $result = $test_store->getBrands();

            //ASSERT
            $this->assertEquals([$test_brand, $test_brand2], $result);
        }










    }

 ?>
