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
                    <a href="#" class="navbar-brand">Search Equipment Database</a>
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
                    $devices=equipment_call("list_devices", "check=false");
                    $manufacturers=equipment_call("list_manufacturers", "check=false");

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
                            <button type="submit" class="btn btn-primary btn-lg" name="device">Modify Device</button>
                            <button type="submit" class="btn btn-primary btn-lg" name="manufacturer" >Modify Manufacturer</button>
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
                        <button type="submit" class="btn btn-primary" name="deviceSubmit">Modify Device</button>
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
                        <button type="submit" class="btn btn-primary" name="manufacturerSubmit">Modify Manufacturer</button>
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

                        <button type="submit" class="btn btn-primary" name="EquipmentSubmit">Modify Equipment</button>

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
        if (empty($_POST['new_device']) && empty($_POST['status']))
        {
            redirect("modify.php?msg=DeviceError");
        }
        
        $device=$_POST['device'];
        $new_device=$_POST['new_device'];
        $status=$_POST['status'];
        $data = "did=".$device;

        if (!empty($new_device))
        {
            $data .= "&rid=".$new_device;
        }
        if (!empty($status))
        {
            $data .= "&status=".$status;
        }

        $result=modify_device_equipment("modify_device", $data);

        switch ($result)
        {
            case "Device":
                redirect("index.php?msg=DeviceName");
                break;
            case "Status":
                redirect("index.php?msg=DeviceStatus");
                break;
            case "Device/Status":
                redirect("index.php?msg=DeviceNameDeviceStatus");
                break;
            case "Device exists":
                redirect("modify.php?msg=DeviceExists");
                break;
            default:
                redirect("modify.php?msg=Error");
                break;
        }
        
    }
    elseif (isset($_POST['manufacturerSubmit']))
    //if manufacturerSubmit is set then update the manufacturer
    {
        if (empty($_POST['new_manufacturer']) && empty($_POST['status']))
        {
            redirect("modify.php?msg=ManufacturerError");
        }

        $manufacturer=$_POST['manufacturer'];
        $new_manufacturer=$_POST['new_manufacturer'];
        $status=$_POST['status'];
        $data = "mid=".$manufacturer;

        if (!empty($new_manufacturer))
        {
            $data .= "&rid=".$new_manufacturer;
        }
        if (!empty($status))
        {
            $data .= "&status=".$status;
        }

        $result=modify_device_equipment("modify_manufacturer", $data);

        switch ($result)
        {
            case "Name":
                redirect("index.php?msg=ManufacturerName");
                break;
            case "Status":
                redirect("index.php?msg=ManufacturerStatus");
                break;
            case "Name/Status":
                redirect("index.php?msg=ManufacturerNameManufacturerStatus");
                break;
            case "Exists":
                redirect("modify.php?msg=ManufacturerExists");
                break;
            default:
                redirect("modify.php?msg=Error");
                break;
        }

    }
    elseif (isset($_POST['EquipmentSubmit']))
    {

        if (empty($_POST['serial']))
        {
            redirect("modify.php?msg=SerialError");
        }

        if (empty($_POST['new_serial']) && empty($_POST['device']) && empty($_POST['manufacturer']))
        {
            redirect("modify.php?msg=EquipmentError");
        }

        $serial=trim($_POST['serial']);
        $new_serial=trim($_POST['new_serial']);
        $device=$_POST['device'];
        $manufacturer=$_POST['manufacturer'];
        $data = "sn=".$serial;

        if (!empty($new_serial))
        {
            $data .= "&rsn=".$new_serial;
        }

        if (!empty($device))
        {
            $data .= "&did=".$device;
        }

        if (!empty($manufacturer))
        {
            $data .= "&mid=".$manufacturer;
        }

        $result=modify_equipment("modify_serial", $data);

        switch ($result)
        {
            case "Serial":
                redirect("index.php?msg=Serial");
                break;
            case "Device":
                redirect("index.php?msg=Device");
                break;
            case "Manufacturer":
                redirect("index.php?msg=Manufacturer");
                break;
            case "Serial/Device":
                redirect("index.php?msg=SerialDevice");
                break;
            case "Serial/Manufacturer":
                redirect("index.php?msg=SerialManufacturer");
                break;
            case "Device/Manufacturer":
                redirect("index.php?msg=DeviceManufacturer");
                break;
            case "Serial/Device/Manufacturer":
                redirect("index.php?msg=SerialDeviceManufacturer");
                break;
            case "Exists":
                redirect("modify.php?msg=RenameExists");
                break;
            case "Not found":
                redirect("modify.php?msg=EquipmentMissing");
                break;
            default:
                redirect("modify.php?msg=Error");
                break;
        }
    }
?>