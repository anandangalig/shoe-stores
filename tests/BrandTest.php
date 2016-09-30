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

    class BrandTest extends PHPUnit_Framework_TestCase {

        protected function tearDown()
        {
            Store::deleteAll();
            Brand::deleteAll();
        }

        function testSave()
        {
            //ARRANGE
            $id = null;
            $name = "Under Armour";
            $test_brand = new Brand($id, $name);

            //ACT
            $test_brand->save();

            //ASSERT
            $this->assertEquals([$test_brand], Brand::getAll());
        }

        function testGetAll()
        {
            //ARRANGE
            $id = null;
            $name = "Under Armour";
            $test_brand = new Brand($id, $name);
            $test_brand->save();

            $name2 = "Asics";
            $test_brand2 = new Brand($id, $name2);
            $test_brand2->save();

            //ACT
            $result = Brand::getAll();

            //ASSERT
            $this->assertEquals([$test_brand, $test_brand2], $result);
        }

        function testDeleteAll()
        {
            //ARRANGE
            $id = null;
            $name = "Under Armour";
            $test_brand = new Brand($id, $name);
            $test_brand->save();

            $name2 = "Asics";
            $test_brand2 = new Brand($id, $name2);
            $test_brand2->save();

            //ACT
            Brand::deleteAll();

            //ASSERT
            $this->assertEquals([], Brand::getAll());
        }

        function testFind()
        {
            //ARRANGE
            $id = null;
            $name = "Under Armour";
            $test_brand = new Brand($id, $name);
            $test_brand->save();

            $name2 = "Asics";
            $test_brand2 = new Brand($id, $name2);
            $test_brand2->save();

            //ACT
            $result = Brand::find($test_brand2->getId());

            //ASSERT
            $this->assertEquals($test_brand2, $result);
        }

        function testUpdate()
        {
            //ARRANGE
            $id = null;
            $name = "Under Armour";
            $test_brand = new Brand($id, $name);
            $test_brand->save();
            $new_name = "Nike";

            //ACT
            $test_brand->update($new_name);

            //ASSERT
            $this->assertEquals("Nike", $test_brand->getName());
        }

        function testAddStore()
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
            $test_brand->addStore($test_store);

            //ASSERT
            $this->assertEquals([$test_store], $test_brand->getStores());
        }

        function testGetStores()
        {
            //ARRANGE
            $id = null;
            $brand_name = "Nike";
            $test_brand = new Brand($id, $brand_name);
            $test_brand->save();

            $name = "Foot Locker";
            $test_store = new Store($id, $name);
            $test_store->save();
            $test_brand->addStore($test_store);

            $name2 = "CHAMPS";
            $test_store2 = new Store($id, $name2);
            $test_store2->save();
            $test_brand->addStore($test_store2);

            //ACT
            $result = $test_brand->getStores();

            //ASSERT
            $this->assertEquals([$test_store, $test_store2], $result);
        }

        function testDelete()
        {
            //ARRANGE
            $id = null;
            $name = "Adidas";
            $test_brand = new Brand($id, $name);
            $test_brand->save();

            $name2 = "Nike";
            $test_brand2 = new Brand($id, $name2);
            $test_brand2->save();


            //ACT
            $test_brand->delete();

            //ASSERT
            $this->assertEquals([$test_brand2], Brand::getAll());
        }

        function testDeleteStore()
        {
            //ARRANGE
            $id = null;
            $brand_name = "Nike";
            $test_brand = new Brand($id, $brand_name);
            $test_brand->save();

            $name = "Finish Line";
            $test_store = new Store($id, $name);
            $test_store->save();
            $test_brand->addStore($test_store);

            $name2 = "CHAMPS";
            $test_store2 = new Store($id, $name2);
            $test_store2->save();
            $test_brand->addStore($test_store2);

            //ACT
            $test_brand->deleteStore($test_store->getId());

            //ASSERT
            $this->assertEquals([$test_store2], $test_brand->getStores());

        }








    }

 ?>
