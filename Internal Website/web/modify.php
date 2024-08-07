<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Advanced Software Engineering</title>
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
                    <a href="#" class="navbar-brand">Modify Equipment Database</a>
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
                    $dblink=db_connect("equipment");
                    $sql="Select `name`,`auto_id` from `devices`";
                    $result=$dblink->query($sql) or
                        die("<p>Something went wrong with $sql<br>".$dblink->error);
                    $devices=array();
                    $manufacturers=array();
                    while ($data=$result->fetch_array(MYSQLI_ASSOC))
                        $devices[$data['auto_id']]=$data['name'];
                    $sql="Select `name`,`auto_id` from `manufacturers`";
                    $result=$dblink->query($sql) or
                        die("<p>Something went wrong with $sql<br>".$dblink->error);
                    while ($data=$result->fetch_array(MYSQLI_ASSOC))
                        $manufacturers[$data['auto_id']]=$data['name'];

                    if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="DeviceError")
                        echo '<div class="alert alert-danger" role="alert">Please enter a new device name or status.</div>';
                    elseif (isset($_REQUEST['msg']) && $_REQUEST['msg']=="ManufacturerError")
                        echo '<div class="alert alert-danger" role="alert">Please enter a new manufacturer name or status.</div>';
                    elseif (isset($_REQUEST['msg']) && $_REQUEST['msg']=="DeviceExists")
                        echo '<div class="alert alert-danger" role="alert">New device name already exists. Cannot rename!</div>';
                    elseif (isset($_REQUEST['msg']) && $_REQUEST['msg']=="ManufacturerExists")
                        echo '<div class="alert alert-danger" role="alert">New manufacturer name already exists. Cannot rename!</div>';
                    elseif (isset($_REQUEST['msg']) && $_REQUEST['msg']=="SerialError")
                        echo '<div class="alert alert-danger" role="alert">Please enter a serial number.</div>';
                    elseif (isset($_REQUEST['msg']) && $_REQUEST['msg']=="EquipmentError")
                        echo '<div class="alert alert-danger" role="alert">Please enter a new serial number, device, or manufacturer.</div>';
                    elseif (isset($_REQUEST['msg']) && $_REQUEST['msg']=="EquipmentMissing")
                        echo '<div class="alert alert-danger" role="alert">Serial number not found.</div>';
                    elseif (isset($_REQUEST['msg']) && $_REQUEST['msg']=="RenameExists")
                        echo '<div class="alert alert-danger" role="alert">New serial number already exists. Cannot rename!</div>';
                ?>
                <h2>Choose:</h2>
                <form method="post" action="">
                    <div class="text-center">
                    <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="submit" class="btn btn-primary btn-lg" name="device" id="equipment">Modify Device</button>
                            <button type="submit" class="btn btn-primary btn-lg" name="manufacturer" id="device">Modify Manufacturer</button>
                            <button type="submit" class="btn btn-primary btn-lg" name="equipment">Modify Equipment</button>
                    </div>
                    </div>
                    <br>
                </form>
            </div>
            <div class="row">

                <?php
                    if (isset($_POST['device']))
                    {
                        echo '<form method="post" action="">
                        <div><h3>Modify Device</h3><br></div>
                        <div class="form-group">
                            <label for="device">Device:</label>
                            <select class="form-control" name="device" id="device">';
                        foreach ($devices as $key=>$value)
                            echo "<option value=\"$key\">$value</option>";
                        echo '</select>
                        </div>
                        <div class="form-group">
                            <label for="manufacturer">Rename:</label>
                            <input type="text" class="form-control" name="new_device" id="new_device" placeholder="(Optional)">
                        </div>
                        <div class="form-group ">
                            <label for="manufacturer_status">Status:</label>
                            <select class="form-control" name="status" id="status">
                                <option value="">Select Status (Optional)</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div>
                        <button type="submit" class="btn btn-default" name="deviceSubmit">Modify Device</button>
                        </div>
                        </form>';
                    }
                ?>


            </div>

            <div class="row">
                <?php
                    if (isset($_POST['manufacturer']))
                    {
                        echo '<form method="post" action="">
                        <div><h3>Modify Manufacturer</h3><br></div>
                        <div class="form-group">
                            <label for="manufacturer">Manufacturer:</label>
                            <select class="form-control" name="manufacturer" id="manufacturer">';
                        foreach ($manufacturers as $key=>$value)
                            echo "<option value=\"$key\">$value</option>";
                        echo '</select>
                        </div>
                        <div class="form-group
                        <label for="manufacturer">Rename:</label>
                        <input type="text" class="form-control" name="new_manufacturer" id="new_manufacturer" placeholder="(Optional)">
                        </div>
                        <div class="form-group  ">
                        <label for="status">Status:</label>
                        <select class="form-control" name="status" id="status">
                            <option value="">Select Status (Optional)</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        </div>
                        <div>
                        <button type="submit" class="btn btn-default" name="manufacturerSubmit">Modify Manufacturer</button>
                        </div>
                        </form>';
                    }
                ?>
            </div>
            <div class="row">
                <?php
                    if (isset($_POST['equipment']))
                    {
                        echo '<form method="post" action="">
                        <div><h3>Modify Equipment</h3><br></div>
                        <div class="form-group">
                            <label for="manufacturer">Serial Number:</label>
                            <input type="text" class="form-control" name="serial" id="serial" placeholder="Required">
                        </div>
                        <div class="form-group">
                            <label for="manufacturer">Rename Serial Number:</label>
                            <input type="text" class="form-control" name="new_serial" id="new_serial" placeholder="(Optional)">
                        </div>
                        <div class="form-group ">
                            <label for="device">Device:</label>
                            <select class="form-control" name="device" id="device">
                                <option value="">Select Device (Optional)</option>';
                        foreach ($devices as $key=>$value)
                            echo "<option value=\"$key\">$value</option>";
                        echo '</select>
                        </div>

                        <div class="form-group ">
                            <label for="manufacturer">Manufacturer:</label>
                            <select class="form-control" name="manufacturer" id="manufacturer">
                                <option value="">Select Manufacturer (Optional)</option>';
                        foreach ($manufacturers as $key=>$value)
                            echo "<option value=\"$key\">$value</option>";
                        echo '</select>
                        </div>
                        <div>
                        <button type="submit" class="btn btn-default" name="EquipmentSubmit">Modify Equipment</button>
                        </div>
                        </form>';
                    }
                ?>
            </div>
          </div>
     </section>
</body>
</html>
<?php
    if (isset($_POST['deviceSubmit']))
    //if deviceSubmit is set then update the device
    {
        $msg = "";
        $device=$_POST['device'];
        //if new device is not empty then update the device
        if ($_POST['new_device']!="")
        {
            $new_device=$_POST['new_device'];
            //check if new device name already exists in the database
            $sql="SELECT * From `devices` where `name`='$new_device'";
            $result=$dblink->query($sql) or
                die("<p>Something went wrong with $sql<br>".$dblink->error);
            if ($result->num_rows > 0)
            {
                redirect("modify.php?msg=DeviceExists");
            }else{
                $sql="Update `devices` set `name`='$new_device' where `auto_id`=$device";
                $result=$dblink->query($sql) or
                    die("<p>Something went wrong with $sql<br>".$dblink->error);
                //append success message to $msg
                $msg .= "DeviceName";
            }

        }
        //if status is not empty then update the status
        if ($_POST['status']!="")
        {
            $status=$_POST['status'];
            $sql="Update `devices` set `status`='$status' where `auto_id`=$device";
            $result=$dblink->query($sql) or
                die("<p>Something went wrong with $sql<br>".$dblink->error);
            //append success message to $msg
            $msg .= "DeviceStatus";
        }
        //if both new device and status are empty then display error message
        if ($_POST['new_device']=="" && $_POST['status']=="")
        {
            redirect("modify.php?msg=DeviceError");
        }
        //redirect to index.php with success message
        redirect("index.php?msg=$msg");
    }
    elseif (isset($_POST['manufacturerSubmit']))
    //if manufacturerSubmit is set then update the manufacturer
    {
        $msg = "";
        $manufacturer=$_POST['manufacturer'];
        //if new manufacturer is not empty then update the manufacturer
        if ($_POST['new_manufacturer']!="")
        {
            $new_manufacturer=$_POST['new_manufacturer'];
            //check if new manufacturer name already exists in the database
            $sql="SELECT * From `manufacturers` where `name`='$new_manufacturer'";
            $result=$dblink->query($sql) or
                die("<p>Something went wrong with $sql<br>".$dblink->error);
            if ($result->num_rows>0)
            {
                redirect("modify.php?msg=ManufacturerExists");
            }else{
                $sql="Update `manufacturers` set `name`='$new_manufacturer' where `auto_id`=$manufacturer";
                $result=$dblink->query($sql) or
                    die("<p>Something went wrong with $sql<br>".$dblink->error);
                //append success message to $msg
                $msg .= "ManufacturerName";
            }

            

        }
        //if status is not empty then update the status
        if ($_POST['status']!="")
        {
            $status=$_POST['status'];
            $sql="Update `manufacturers` set `status`='$status' where `auto_id`=$manufacturer";
            $result=$dblink->query($sql) or
                die("<p>Something went wrong with $sql<br>".$dblink->error);
            //append success message to $msg
            $msg .= "ManufacturerStatus";
        }
        //if both new manufacturer and status are empty then display error message
        if ($_POST['new_manufacturer']=="" && $_POST['status']=="")
        {
            redirect("modify.php?msg=ManufacturerError");
        }
        //redirect to index.php with success message
        redirect("index.php?msg=$msg");
    }
    elseif (isset($_POST['EquipmentSubmit']))
    {
        $device=$_POST['device'];
        $manufacturer=$_POST['manufacturer'];
        $serial=trim($_POST['serial']);
        $new_serial=trim($_POST['new_serial']);
        $msg = "";

        //if serial is empty then display error message
        if ($serial=="")
        {
            redirect("modify.php?msg=SerialError");
        }
        //if new serial and device and manufacturer are empty then display error message
        if ($new_serial=="" && $device=="" && $manufacturer=="")
        {
            redirect("modify.php?msg=EquipmentError");
        }
        //check if serial number exists
        $sql="Select `auto_id` from `serials` where `serial_number`='$serial'";
        $result=$dblink->query($sql) or
            die("<p>Something went wrong with $sql<br>".$dblink->error);
        if ($result->num_rows==0)
        {
            redirect("modify.php?msg=EquipmentMissing");
        }

        //if new serial is not empty then update the serial number
        if ($new_serial!="")
        {
            //check if new serial number already exists
            $sql="Select `auto_id` from `serials` where `serial_number`='$new_serial'";
            $result=$dblink->query($sql) or
                die("<p>Something went wrong with $sql<br>".$dblink->error);
            if ($result->num_rows>0)
            {
                redirect("modify.php?msg=RenameExists");
            }

            $sql="Update `serials` set `serial_number`='$new_serial' where `serial_number`='$serial'";
            $result=$dblink->query($sql) or
                die("<p>Something went wrong with $sql<br>".$dblink->error);
            //append success message to $msg
            $msg .= "Serial";
        }
        //if device is not empty then update the device
        if ($device!="")
        {
            $sql="Update `serials` set `device_id`=$device where `serial_number`='$serial'";
            $result=$dblink->query($sql) or
                die("<p>Something went wrong with $sql<br>".$dblink->error);
            //append success message to $msg
            $msg .= "Device";
        }
        //if manufacturer is not empty then update the manufacturer
        if ($manufacturer!="")
        {
            $sql="Update `serials` set `manufacturer_id`=$manufacturer where `serial_number`='$serial'";
            $result=$dblink->query($sql) or
                die("<p>Something went wrong with $sql<br>".$dblink->error);
            //append success message to $msg
            $msg .= "Manufacturer";
        }

        redirect("index.php?msg=$msg");
    }
?>