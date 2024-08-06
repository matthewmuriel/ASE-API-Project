<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>External Inventory Database</title>
<link href="../assets/css/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/font-awesome.min.css">
<link rel="stylesheet" href="../assets/css/owl.carousel.css">
<link rel="stylesheet" href="../assets/css/owl.theme.default.min.css">

<!-- MAIN CSS -->
<link rel="stylesheet" href="../assets/css/templatemo-style.css">
</head>
<body>
<body id="top" data-spy="scroll" data-target=".navbar-collapse" data-offset="50">
     <!-- MENU -->
     <section class="navbar custom-navbar navbar-fixed-top" role="navigation">
          <div class="container">
               <div class="navbar-header">
                    <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                         <span class="icon icon-bar"></span>
                         <span class="icon icon-bar"></span>
                         <span class="icon icon-bar"></span>
                    </button>

                    <!-- lOGO TEXT HERE -->
                    <a href="#" class="navbar-brand">Add New Equipment</a>
               </div>
               <!-- MENU LINKS -->
               <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-nav-first">
                    <li><a href="index.php" class="smoothScroll">Home</a></li>
                         <li><a href="search.php" class="smoothScroll">Search Equipment</a></li>
                         <li><a href="add.php" class="smoothScroll">Add Equipment</a></li>
                         <li><a href="modify.php" class="smoothScroll">Modify Equipment</a></li>
                    </ul>
               </div>
          </div>
     </section>
 <!-- HOME -->
     <section id="home">
          </div>
     </section>
     <!-- FEATURE -->
     <section id="feature">
          <div class="container">
               <div class="row">
                   
                   <?php 
                        include("../functions.php");
                        $devices=equipment_call("list_devices","");
                        $manufacturers=equipment_call("list_manufacturers","");

                        if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="DeviceExists")
                        {
                            echo '<div class="alert alert-danger" role="alert">Serial Number already exists in database!</div>';

                        }elseif (isset($_REQUEST['msg']) && $_REQUEST['msg'] == "ManufacturerExists")
                        {
                            echo '<div class="alert alert-danger" role="alert">Manufacturer already exists in database!</div>';
                        }elseif (isset($_REQUEST['msg']) && $_REQUEST['msg'] == "DeviceTypeExists")
                        {
                            echo '<div class="alert alert-danger" role="alert">Device Type already exists in database!</div>';
                        }elseif (isset($_REQUEST['msg']) && $_REQUEST['msg'] == "ManufacturerEmpty")
                        {
                            echo '<div class="alert alert-danger" role="alert">Manufacturer cannot be empty!</div>';
                        }elseif (isset($_REQUEST['msg']) && $_REQUEST['msg'] == "SerialEmpty")
                        {
                            echo '<div class="alert alert-danger" role="alert">Serial Number cannot be empty!</div>';
                        }elseif (isset($_REQUEST['msg']) && $_REQUEST['msg'] == "DeviceEmpty")
                        {
                            echo '<div class="alert alert-danger" role="alert">Device Type cannot be empty!</div>';
                        }
                   ?>
            <div class="row">
                <h2>Choose:</h2>
                <form method="post" action="">
                    <div class="text-center">
                    <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="submit" class="btn btn-primary btn-lg" name="equipment" id="equipment">Add Equipment</button>
                            <button type="submit" class="btn btn-primary btn-lg" name="device" id="device">Add Device Type</button>
                            <button type="submit" class="btn btn-primary btn-lg" name="manufacturer">Add Manufacturer</button>
                    </div>
                    </div>
                    <br>
                </form>
            </div>
            <div class="row">
                <?php
                    if (isset($_POST['equipment'])){
                        echo'    <form method="post" action="">';
                        echo'    <div><br><h3>Add Equipment</h3><br></div>';
                        echo'    <div class="form-group">';
                        echo'        <label for="exampleDevice">Device:</label>';
                        echo'        <select class="form-control" name="device">';
                        foreach($devices as $key=>$value)
                            echo '<option value="'.$key.'">'.$value.'</option>';
                        echo'        </select>';
                        echo'    </div>';
                        echo'    <div class="form-group">';
                        echo'        <label for="exampleManufacturer">Manufacturer:</label>';
                        echo'        <select class="form-control" name="manufacturer">';
                        foreach($manufacturers as $key=>$value)
                            echo '<option value="'.$key.'">'.$value.'</option>';
                        echo'        </select>';
                        echo'    </div>';
                        echo'    <div class="form-group">';
                        echo'        <label for="exampleSerial">Serial Number:</label>';
                        echo'        <input type="text" class="form-control" id="serialInput" name="serialnumber">';
                        echo'    </div>';
                        echo'        <button type="submit" class="btn btn-primary" name="equipmentSubmit" value="submit">Add Equipment</button>';
                        echo'    </form>';
                    }
                ?>        

               </div>
               <!-- Row to add a device type to database -->
            <div class="row">
                <?php
                    if (isset($_POST['device'])){
                        echo'    <form method="post" action="">';
                        echo'    <div><br><h3>Add Device Type</h3><br></div>';
                        echo'    <div class="form-group">';
                        echo'        <label for="exampleDevice">Device Type:</label>';
                        echo'        <input type="text" class="form-control" id="deviceInput" name="device">';
                        echo'    </div>';
                        echo'    <button type="submit" class="btn btn-primary" name="deviceTypeSubmit" value="submit2">Add Device Type</button>';
                        echo'    </form>';
                    }
                ?>
            </div>
            <!-- Row to add a manufacturer to database -->
            <div class="row">
            <?php
                if (isset($_POST['manufacturer'])){
                echo'    <form method="post" action="">';
                echo'    <div><br><h3>Add Manufacturer</h3><br></div>';
                echo'    <div class="form-group">';
                echo'        <label for="exampleManufacturer">Manufacturer:</label>';
                echo'        <input type="text" class="form-control" id="manufacturerInput" name="manufacturer">';
                echo'    </div>';
                echo'    <button type="submit" class="btn btn-primary" name="manufacturerSubmit" value="submit3">Add Manufacturer</button>';
                echo'    </form>';
                }
            ?>

            </div>


          </div>
     </section>
</body>
</html>
<?php
    if (isset($_POST['equipmentSubmit']))
    //if the equipment submit button is pressed then add the equipment to the database
    {
        if (empty($_POST['serialnumber']))
        {
            redirect("add.php?msg=SerialEmpty");
        }

        $serial=trim($_POST['serialnumber']);
        $device=$_POST['device'];
        $manufacturer=$_POST['manufacturer'];
        $data="sn=".$serial."&did=".$device."&mid=".$manufacturer;

        $result = add_device_equipment("add_equipment",$data);

        if ($result === "Success")
        {
            redirect("index.php?msg=EquipmentAdded");
        }else{
            redirect("add.php?msg=DeviceExists");
        }
    }elseif (isset($_POST['deviceTypeSubmit']))
    //if the device type submit button is pressed then add the device type to the database
    {
        if (empty($_POST['device']))
        {
            redirect("add.php?msg=DeviceEmpty");
        }

        $device=trim($_POST['device']);
        //change to lowercase
        $device=strtolower($device);
        $data="name=".$device;

        $result = add_device_equipment("add_device",$data);

        if ($result === "Success")
        {
            redirect("index.php?msg=DeviceTypeAdded");
        }else{
            redirect("add.php?msg=DeviceTypeExists");
        }

    }elseif (isset($_POST['manufacturerSubmit']))
    //if the manufacturer submit button is pressed then add the manufacturer to the database
    {
        if (empty($_POST['manufacturer']))
        {
            redirect("add.php?msg=ManufacturerEmpty");
        }

        $manufacturer=trim($_POST['manufacturer']);
        $data="name=".$manufacturer;
        echo $data;

        $result = add_device_equipment("add_manufacturer",$data);

        if ($result === "Success")
        {
            redirect("index.php?msg=ManufacturerAdded");
        }else{
            redirect("add.php?msg=ManufacturerExists");
        }
    }
?>