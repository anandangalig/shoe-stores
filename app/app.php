<?php
    /**
    *@backupGlobals disabled
    *@backupStaticAttributes disabled
    */

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Brand.php";
    require_once __DIR__."/../src/Store.php";

    $app = new Silex\Application();

    $server = "mysql:host=localhost:8889;dbname=shoes";
    $username = "root";
    $password = "root";
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array("twig.path" => __DIR__."/../views"));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app) {
        return $app["twig"]->render("index.html.twig", array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });
//=======================STORES==============================================
    $app->post("/create_store", function() use ($app) {
        $id = null;
        $new_store = new Store($id, $_POST['new_store_name']);
        $new_store->save();
        return $app["twig"]->render("index.html.twig", array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->post("/delete_all_stores", function() use ($app) {
        Store::deleteAll();
        return $app["twig"]->render("index.html.twig", array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->get("/store/{id}", function($id) use ($app) {
        $store = Store::find($id);
        $carried_brands = $store->getBrands();
        $all_brands = Brand::getAll();
        return $app["twig"]->render("store.html.twig", array('store' => $store, 'carried_brands' => $carried_brands, 'all_brands' => $all_brands));
    });

    $app->post("/add_brand/{id}", function($id) use ($app) {
        $brand_added = Brand::find($_POST['add_brand_name']);
        $store = Store::find($id);
        $store->addBrand($brand_added);
        $carried_brands = $store->getBrands();
        $all_brands = Brand::getAll();
        return $app["twig"]->render("store.html.twig", array('store' => $store, 'carried_brands' => $carried_brands, 'all_brands' => $all_brands));
    });

    $app->post("/update_store/{id}", function($id) use ($app) {
        $store = Store::find($id);
        $store->update($_POST['new_store_name']);
        $carried_brands = $store->getBrands();
        $all_brands = Brand::getAll();
        return $app["twig"]->render("store.html.twig", array('store' => $store, 'carried_brands' => $carried_brands, 'all_brands' => $all_brands));
    });









//======================BRANDS===============================================
    $app->post("/create_brand", function() use ($app) {
        $id = null;
        $new_brand = new Brand($id, $_POST['new_brand_name']);
        $new_brand->save();
        return $app["twig"]->render("index.html.twig", array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->post("/delete_all_brands", function() use ($app) {
        Brand::deleteAll();
        return $app["twig"]->render("index.html.twig", array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->get("/brand/{id}", function($id) use ($app) {
        $brand = Brand::find($id);
        $carried_stores = $brand->getStores();
        $all_stores = Store::getAll();
        return $app["twig"]->render("brand.html.twig", array('brand' => $brand, 'carried_stores' => $carried_stores, 'all_stores' => $all_stores));
    });

    $app->post("/add_store/{id}", function($id) use ($app) {
        $store_added = Store::find($_POST['add_store_name']);
        $brand = Brand::find($id);
        $brand->addStore($store_added);
        $carried_stores = $brand->getStores();
        $all_stores = Store::getAll();
        return $app["twig"]->render("brand.html.twig", array('brand' => $brand, 'carried_stores' => $carried_stores, 'all_stores' => $all_stores));
    });

    $app->post("/update_brand/{id}", function($id) use ($app) {
        $brand = Brand::find($id);
        $brand->update($_POST['new_brand_name']);
        $carried_stores = $brand->getStores();
        $all_stores = Store::getAll();
        return $app["twig"]->render("brand.html.twig", array('brand' => $brand, 'carried_stores' => $carried_stores, 'all_stores' => $all_stores));
    });




    return $app;
 ?>
