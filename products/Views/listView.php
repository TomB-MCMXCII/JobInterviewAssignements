<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="stylesheet" type="text/css" href="./css/bootstrap.css">
    <script src="jquery-3.5.1.min.js"></script>
</head>
<body style="font-weight: 400;">
    <div style="width: 90%;" id="main" class="container-fluid">
        <div style="margin: auto;" class="row header">
                <div style="padding: 0;" class="col title">
                    <h1>Product List</h1>
                </div>
                <div style="padding: 0;" class="col saveBtnContainer">
                    <button form="deleteProduct" id="save" class="saveBtn">Save</button>
                </div>    
        </div>
        <form id="deleteProduct" action="list?f=massDelete" method="POST">
            <div style="margin: auto;" class="row bookRow">
                <?php foreach ($data["books"] as $key => $value) :?>
                    <?php if($key == 1){echo "<div class=\"col\"></div>";}?>
                    <div class="col-xl-3  item">
                        <div class="row">
                            <div class="col-2 checkBoxWrapper">
                                <input name="books[]" value="<?php echo $value["id"]?>" type="checkbox">
                            </div>
                        </div>
                        <div class="row itemContentRow">    
                            <p><?php echo $value["sku"]; ?></p>
                            <p><?php echo $value["name"]; ?></p>
                            <p><?php echo $value["price"]; ?></p>
                            <p>Weight: <?php echo $value["weight"]; ?></p>
                        </div>
                    </div>
                    <?php if($key == 1 || $key == 2){echo "<div class=\"col\"></div>";}?>
                <?php endforeach?>
            </div>
            <div style="margin: auto;" class="row cdRow">
                <?php foreach ($data["cd"] as $key => $value) :?>
                    <?php if($key == 1){echo "<div class=\"col\"></div>";}?>
                    <div class="col-xl-3 item">
                        <div class="row">
                            <div class="col-2 checkBoxWrapper">                      
                                <input name="cds[]" value="<?php echo $value["id"]?>" type="checkbox">
                            </div>
                        </div>        
                        <div class="row itemContentRow">    
                            <p><?php echo $value["sku"]; ?></p>
                            <p><?php echo $value["name"]; ?></p>
                            <p><?php echo $value["price"]; ?></p>
                            <p>Size: <?php echo $value["size"]; ?></p>
                        </div>    
                    </div>
                    <?php if($key == 1 || $key == 2){echo "<div class=\"col\"></div>";}?>
                <?php endforeach?>
            </div>
            <div style="margin: auto;" class="row mb-5 furnitureRow">
                <?php foreach ($data["furniture"] as $key => $value) :?>
                    <?php if($key == 1){echo "<div class=\"col\"></div>";}?>
                    <div class="col-xl-3 item ">
                        <div class="row">
                            <div class="col-2 checkBoxWrapper">
                                <input name="furniture[]" value="<?php echo $value["id"]?>" type="checkbox">
                            </div>
                        </div>    
                        <div class="row itemContentRow">
                            <p><?php echo $value["sku"]; ?></p>
                            <p><?php echo $value["name"]; ?></p>
                            <p><?php echo $value["price"]; ?></p>
                            <p>Dimension: <?php echo $value["width"];?>x<?php echo $value["length"]; ?>x<?php echo $value["height"]; ?></p>
                        </div>
                    </div>
                    <?php if($key == 1 || $key == 2){echo "<div class=\"col\"></div>";}?>
                <?php endforeach?>
            </div>
        </form>    
    </div>
</body>
</html>