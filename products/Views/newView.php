<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Add</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" 
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" 
    crossorigin="anonymous">
    <script src="jquery-3.5.1.min.js"></script>
</head>
<body style="font-weight: 600;">
    <div style="width: 90%;" id="main" class="container-fluid">
        <div style="margin: auto;" class="row header">
                <div style="padding: 0;" class="col title">
                    <h1>Product Add</h1>
                </div>
                <div style="padding: 0;" class="col saveBtnContainer">
                    <button form="newProductForm" id="save" class="saveBtn">Save</button>
                </div>
        </div>
        <div style="margin: auto;" class="row">
            <div class="formContainer">
                 <form id="newProductForm" action="new?f=addProduct" onsubmit="return validate()" method="POST"> 
                    <label for="sku">SKU</label> <input type="text" name="sku" id="sku" required > <span id="skuError"></span><br>
                    <label for="name">Name</label> <input type="text" name="name" id="name" required > <br>
                    <label for="price">Price</label> <input type="number" step="0.01" name="price" id="price" required value=""> <br>
                    <label for="type" id="typeLabel" class="typeLabel">Type Switcher :</label>
                    <select id="productType" name="type" onchange="setTypeForm(this.value)"> 
                        <option value="noType">Type switcher</option>
                        <option value="furniture">Furniture</option>
                        <option value="book">Book</option>
                        <option value="cd">CD</option>
                    </select> 
                    <div id="specialAttribute">
                    <span id="typeError"></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>

    const setTypeForm = (value) =>  {
        document.getElementById('specialAttribute').innerHTML = specialAttribute[value];
    }
    
    const specialAttribute = { 
        "noType":    "<span id=\"typeError\"></span> ",

        "furniture":    "<label for=\"height\">Height:</label>" + "<input type=\"number\" name=\"height\" step=\"0.01\" required/><br>" + 
                        "<label for=\"width\">Width:</label>" + "<input type=\"number\" name=\"width\" step=\"0.01\" required/><br>" +
                        "<label for=\"length\">Length:</label>" + "<input type=\"number\" name=\"length\" step=\"0.01\" required/><br>" +
                        "<p class=\"description\">Please provide dimensions in meters e.g. 92cm is 0.92 meters.</p>",

        "book":    "<label for=\"weight\">Weight:</label>" + "<input type=\"number\" name=\"weight\" required/><br>" + 
                    "<p class=\"description\">Please provide weight in kilograms.</p>",
        
        "cd":    "<label for=\"size\">Size:</label>" + "<input type=\"number\" name=\"size\" required/><br>" +
                "<p class=\"description\">Please provide size in megabytes.</p>",
    }
   
    function validate(){
        var productType = document.querySelector('#productType option:checked').value;
        var sku = document.forms["newProductForm"]["sku"].value;
        var data = {type: productType, sku: sku};
        if(productType == "noType"){
            showNoTypeError();
            return false;
        }else{ 
            $.ajax({
                url : "new?f=skuExists",
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                type: "POST",
                data : {myData:data},
                success: function(responseData, textStatus, jqXHR)
                {
                    
                    if(responseData == 1){
                        showSkuExistsError();
                    }
                    else if(responseData == 0){
                                            
                        document.getElementById("newProductForm").submit();    
                    }  
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    console.log(errorThrown);  
                }
            });
        }
        return false;
    }

    function showNoTypeError(){ 
        var p = document.getElementById("typeError");
            
        if(p.innerText == ""){
            var text = document.createTextNode("Please select a product type");
            p.appendChild(text);
        }
    }

    function showSkuExistsError(){
        var span = document.getElementById("skuError");

        if(span.innerText == "")
        {
            var text = document.createTextNode("A product with this sku allready exists");
            span.appendChild(text);
        }  
    }
</script>

</body>
</html>