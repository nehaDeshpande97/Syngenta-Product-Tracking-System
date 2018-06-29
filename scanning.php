<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Barcode Scanner</title>
    <link type="text/css" rel="stylesheet" href="assets/css/style.css" />

    <script type="text/javascript" src="assets/js/jquery-1.11.2.js"></script>
    <script type="text/javascript" src="assets/js/jquery.form.js"></script>
	<script type="text/javascript" src="assets/js/kissy-min.js"></script>
	
    <script type="text/javascript">
	

	
        function fileSelected() {
            var filesToUpload = document.getElementById('fileToUpload');
            var count = typeof filesToUpload.files === 'undefined' ? filesToUpload.value.split(';').length : filesToUpload.files.length;
            if (count > 0) {
                if(typeof filesToUpload.files === 'undefined')
                {
                    document.getElementById('filename').value = filesToUpload.value;
                }
                else {
                    var file = filesToUpload.files[0];
                    document.getElementById('filename').value = file.name;
                }
            }
        }

        function getSelectedBarcodeTypes() {
        	var vType = 0;
        	var barcodeType = document.getElementsByName("BarcodeType");
            for (i = 0; i < barcodeType.length; i++) {
                if (barcodeType[i].checked == true)
                    vType = vType | (barcodeType[i].value * 1);
            }

            return vType;
        }
		function showPosition(position) {
			
	//alert("hi");		
			var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;
	
	var barcoding=document.getElementById("resultBox").textContent;
			//alert(barcoding);
			/* var x =document.getElementById("resultBox1");
    x.innerHTML = "Latitude: " + position.coords.latitude + 
    "<br>Longitude: " + position.coords.longitude; */
	$.ajax({
        type:'POST',
        url:'getlocation.php',
        data:'latitude='+latitude+'&longitude='+longitude+'&barcoding='+barcoding,
        success:function(msg){
            if(msg){
               $("#resultBox1").html(msg);
			   alert("Sale completed");
            }else{
                $("#resultBox1").html('Not Available');
            }
        }
    });
}

     
  function getLocation() {
	 
	 //alert("hi");
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } /*else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }*/
  }
  
        function doReadBarcode() {        		
            $("#btnSubmitUpload").click();
			getLocation();
}

   

        function uploadProgress(evt) {
            if (evt.lengthComputable) {
                var percentComplete = Math.round(evt.loaded * 100 / evt.total);
                document.getElementById('resultBox').innerHTML = 'Upload status: Finished ' + percentComplete.toString() + '%.';
            }
            else {
                //document.getElementById('resultBox').innerHTML = 'unable to compute';
            }
        }

        function uploadComplete(evt) {
            document.getElementById('resultBox').innerHTML = evt;
        }

        function uploadFailed(evt) {
            alert("There was an error attempting to upload the file.");
        }

        function uploadCanceled(evt) {
            alert("The upload has been canceled by the user or the browser dropped the connection.");
        }
        
        function setData(formData, jqForm, options) { 		
			showWaitDialog();
            var uploadFlag = 0;

            var clsval = document.getElementById('fileUpload').getAttribute('class');
            if(clsval.indexOf('hidden') == -1) {
                uploadFlag = 1;
            }
            
            if(uploadFlag) {
                var filesToUpload = document.getElementById('fileToUpload');
                // clear fileToDownload
                setValueOfFileToDownload(formData, "");      
                // var count = typeof filesToUpload.files === 'undefined' ? filesToUpload.value.split(';').length : filesToUpload.files.length;          
            } 
            else {
                // clear fileToUpload
                var iIndex = getFieldIndex(formData, "fileToUpload");
                if(iIndex > -1){
                    formData[iIndex].value = "";
                }
                // set value Of fileToDownload
                var url = document.getElementById('imageURL').value;
                if(url != null && url != "") {                    
                    setValueOfFileToDownload(formData, url);
                } 
            }
            //formData.append('uploadFlag', uploadFlag);
            //formData.append('barcodetype', getSelectedBarcodeTypes());
            if($("#uploadFlag").length > 0)  {
                $("#uploadFlag").val(uploadFlag);
                formData[getFieldIndex(formData, "uploadFlag")].value = uploadFlag;
            }
            else{
                 formData.push({name:'uploadFlag', value:uploadFlag});
                 $('#uploadForm').append('<input type="hidden" name="uploadFlag" id="uploadFlag" value="'+uploadFlag+'" style="display:none" />');                
            }
           
            if($("#barcodetype").length > 0)  {
                $("#barcodetype").val(getSelectedBarcodeTypes());
                formData[getFieldIndex(formData, "barcodetype")].value = getSelectedBarcodeTypes();
            }
            else{
                formData.push({name:'barcodetype', value:getSelectedBarcodeTypes()});
                $('#uploadForm').append('<input type="hidden" name="barcodetype" id="barcodetype" value="'+ getSelectedBarcodeTypes() +'" style="display:none"/>');                
            }
            
            return true; 
        }
        
        function setValueOfFileToDownload(formData, fieldValue){
            if($("#fileToDownload").length > 0){
                $("#fileToDownload").val(fieldValue);
                var iIndex = getFieldIndex(formData, "fileToDownload");
                if(iIndex > -1)
                formData[iIndex].value = fieldValue;
            }
            else{
                formData.push({name:'fileToDownload', value:fieldValue});
                $('#uploadForm').append('<input type="text" name="fileToDownload" id="fileToDownload" value="'+fieldValue+'" style="display:none" />');                        
            }
        }
        
        function getFieldIndex(formData, fieldName){
            var iIndex = -1;
            for(var i=0; i< formData.length; i++) {
                if(formData[i].name == fieldName){
                     iIndex = i;
                     break;
                }
            }
            return iIndex;
        }

		var S = KISSY;
		var dlgDoBarcode;
		
		function showWaitDialog() {
			var ObjString = "<div class=\"D-dailog-body-Recognition\">";
			ObjString += "<p>" + "Processing..." + "</p>";
			ObjString += "<img src='assets/images/loading.gif' style='width:160px; height:160px; margin-left:17px; margin-top:20px;' /></div>";
			document.getElementById("strBody").innerHTML = ObjString;

			ShowWaitDialog(237, 262); 
		}
		
		function DoNotShowWaitDDialogInner() {
			if (dlgDoBarcode) {
				dlgDoBarcode.hide();
			}
		}

		function ShowWaitDialog(varWidth, varHeight) {
			S.use("overlay", function(S, o) {

			dlgDoBarcode = new o.Dialog({
					srcNode: "#J_waiting",
					width: varWidth,
					height: varHeight,
					closable: false,
					mask: true,
					align: {
						node: "#readBarcode",
						points: ['br', 'bl'],
						offset: [20, 0]
					}
				});
				dlgDoBarcode.show();
			});
		}		
		
         $(document).ready(function() { 
            var options = { 
                beforeSubmit: setData,
                async: true,
                success:    function(e) { 
                    uploadComplete(e);
                }, 
                error: function(e){
                    uploadFailed(e);
                },
                uploadProgress: function(e){    
                    uploadProgress(e);          					
                },
				complete: function(e){
					DoNotShowWaitDDialogInner();	
				}
            }; 
            
            $('#uploadForm').ajaxForm(options); 
        }); 
    </script>
</head>

<body>
    <div id="wrapper">
		<div class="D-dailog row" id="J_waiting"><div id="strBody"></div></div>
        <div id="dbr-php">
		
			<img  align="center" src="syngentalogo.jpg" style="margin-left:175px"/><br><br>
            <h1>Product Scanner</h1>
            <!--<form action="">-->               
            <div class="step step1">                
                <div id="fileUpload" class="getFile">
                    <form action="readbarcode.php" id="uploadForm" method="post">
                        
                            <h4>QRCode</h4>
                            <input type="file" id="fileToUpload" name="fileToUpload" onchange="fileSelected();" style="display:none;" />
                            <input type="text" readonly="readonly" id="filename" onclick="document.getElementById('fileToUpload').click();" />
                            <input type="button" onclick="document.getElementById('fileToUpload').click();" />
                       <!--     <a class="clickSwitch" href="javascript:void(0);">or, Specify an URL</a>-->
                        <input type="submit" id="btnSubmitUpload" style="display:none;">
                    </form>
                </div>
              <!--  <div id="fileDownload" class="hidden getFile">
                    <input type="text" id="imageURL"/>
                    <!--<input type="button"/>
                    <a class="clickSwitch" href="javascript:void(0);">or, Upload from local</a>
                </div>-->
				<input id="chkQRCode" name="BarcodeType" checked="true" type="checkbox" value="0x4000000" hidden>
            </div>
			 
           <!-- <div class="step step2">-->
                <!--<span class="num">2</span>
                <h4>
                    Barcode Types:</h4>
                <ul class="barcodeType">
                    <li class="on">
                        <label for="chkLinear">
                            <input id="chkLinear" name="BarcodeType" type="checkbox" checked="true" value="0x3FF">
                            <span>Linear</span><br />
                            <div class="imgWrapper">
                                <img src="assets/images/oned.gif" width="90" alt="Barcode Type Linear" /></div>
                        </label>
                    </li>
                    <li>
                        <label for="chkQRCode">-->

                            <!--<span>QRCode</span><br />
                            <div class="imgWrapper">
                                <img src="assets/images/qr.gif" width="60" alt="Barcode Type QRCode" /></div>
                        </label>
                    </li>
                    <li>
                        <label for="chkPDF417">
                            <input id="chkPDF417" name="BarcodeType" type="checkbox" value="0x2000000">
                            <span>PDF417</span><br />
                            <div class="imgWrapper">
                                <img src="assets/images/pdf417.gif" width="100" height="38" alt="Barcode Type PDF417" /></div>
                        </label>
                    </li>
                    <li>
                        <label for="chkDataMatrix">
                            <input id="chkDataMatrix" name="BarcodeType" type="checkbox" value="0x8000000">
                            <span>DataMatrix</span><br />
                            <div class="imgWrapper">
                                <img src="assets/images/dm.gif" width="60" alt="Barcode Type DataMatrix" /></div>
                        </label>
                    </li>
                </ul>-->
            <!--</div>-->
            <div class="step step3">
                 <a id="readBarcode" name="RecgabtnCssBarcode" onclick="doReadBarcode();" style="margin-left:175px">
                </a>
                <div id="resultBox" style="display:none">
                </div>
				 <div id="resultBox1" style="display:none">
                </div>
				
            </div>
			

			
			
			
            <!--</form>-->
            
        </div>
    </div>

    <script type="text/javascript">
        $("a.clickSwitch").click(function() {
            $(".getFile").toggleClass('hidden');
        });

        $("ul.barcodeType :checkbox").click(function() {
            $(this).parents('li').toggleClass('on');
        });

		
		
		function getValue()
		{
			var location=document.getElementById('resultBox1').innerHTML;
			var barcode=document.getElementById('resultBox').innerHTML;
			
			alert(location);
			alert(barcode);
			
			
		}
    </script>

</body>
</html>
