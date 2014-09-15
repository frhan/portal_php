<?php 
$this->load->view('header');
?>

<div id="container">
	<div class="full-row">
		<h3>File Access Portal</h3>
	</div>
	<div class="full-row">
		<div class="file-menu">
			<a href="#" id="link_upload_file">Upload File</a>
		</div>
		<div class="file-menu" >
			<a href="#" id="link_upload_data">Upload Data File</a>
		</div>
		<div class="file-menu">
			<a href="#" id="link_view">View</a>
		</div>

	</div>

	<div class="full-row mt30" id="upload_file">
		<form name="file-upload" method="post"  action="<?php echo base_url();?>index.php/user/uploadFile" enctype="multipart/form-data">
			<input type="file" name="file" id="userDataFile" /> 
			<input type="submit" name="upload" value="Upload" />
		</form>
	</div>

	<div class="full-row mt30" id="upload_data">
		<form name="file-upload" method="post"  action="<?php echo base_url();?>index.php/user/putSubscriberData" enctype="multipart/form-data">
			<input type="file" name="file"/> 
			<input type="submit" name="upload" value="upload" />
		</form>
	</div>

	<div class="full-row mt30" id="view">
		<form name="file-upload" method="get" id="onsubmit">
			Mobile:<input type="text"  value="1682302875" name="mobile" id="mbno">
			<input type="button" name="Submit" value="Search" id="buttonSearch">
		</form >

	</div>
 
	<div id="content">
		<div class="contentSplit">
		 <div id="pdfContainer" class="pdf-content">
    	  </div>
		</div>
		<div class="contentSplit">
			<table>
				<tr>
					<td class="userDataLabel">Mobile:</td>
					<td class="userDataContent"><label id="lblMobile"></label></td>
				</tr>
				<tr>
					<td class="userDataLabel">Name:</td>
					<td class="userDataContent"><label id="lblName"></label></td>
				</tr>
				<tr>
					<td class="userDataLabel">Farther or Husband Name:</td>
					<td class="userDataContent"><label id="lblFohName"></label></td>
				</tr>

				<tr>
					<td class="userDataLabel">Mother's Name:</td>
					<td class="userDataContent"><label id="lblMothersName"></label></td>
				</tr>

				<tr>
					<td class="userDataLabel">Date Of Birth:</td>
					<td class="userDataContent"><label id="lbldob"></label></td>
				</tr>
				
				<tr>
					<td class="userDataLabel">Gender</td>
					<td class="userDataContent"><label id="lblGender"></label></td>
				</tr>
					<tr>
					<td class="userDataLabel">Address_Address Line</td>
					<td class="userDataContent"><label id="lblAddressline"></label></td>
				</tr>
					<tr>
					<td class="userDataLabel">Address_CityOrDistrict</td>
					<td class="userDataContent"><label id="lblCityOrDist"></label></td>
				</tr>

					</tr>
					<tr>
					<td class="userDataLabel">Photo Type:</td>
					<td class="userDataContent"><label id="lblPhotoType"></label></td>
				</tr>
					<tr>
					<td class="userDataLabel">Photo Id Number:</td>
					<td class="userDataContent"><label id="lblPhotoNumber"></label></td>
				</tr>
				</tr>
					<tr>
					<td class="userDataLabel">Occupation:</td>
					<td class="userDataContent"><label id="lblOcupation"></label></td>
				</tr>
					</tr>
					<tr>
					<td class="userDataLabel">Reference Name:</td>
					<td class="userDataContent"><label id="lblReferenceName"></label></td>
				</tr>

			</table>
		</div>
	</div>



</div>


<script type="text/javascript">

var scale = 1; //Set this to whatever you want. This is basically the "zoom" factor for the PDF.

/**
 * Converts a base64 string into a Uint8Array
 */
function base64ToUint8Array(base64) {
    var raw = atob(base64); //This is a native function that decodes a base64-encoded string.
    var uint8Array = new Uint8Array(new ArrayBuffer(raw.length));
    for(var i = 0; i < raw.length; i++) {
        uint8Array[i] = raw.charCodeAt(i);
    }

    return uint8Array;
}

function loadPdf(pdfData) {
    PDFJS.disableWorker = true; //Not using web workers. Not disabling results in an error. This line is
                                //missing in the example code for rendering a pdf.
    
    var pdf = PDFJS.getDocument(pdfData);
    pdf.then(renderPdf);                               
}

function renderPdf(pdf) {
    pdf.getPage(1).then(renderPage);
}

function renderPage(page) {
    var viewport = page.getViewport(scale);
    var $canvas = jQuery("<canvas></canvas>");
    
    //Set the canvas height and width to the height and width of the viewport
    var canvas = $canvas.get(0);
    var context = canvas.getContext("2d");
    canvas.height = viewport.height;
    canvas.width = viewport.width;
    
    //Append the canvas to the pdf container div
    jQuery("#pdfContainer").append($canvas);
    
    //The following few lines of code set up scaling on the context if we are on a HiDPI display
    var outputScale = getOutputScale();
    if (outputScale.scaled) {
        var cssScale = 'scale(' + (1 / outputScale.sx) + ', ' +
            (1 / outputScale.sy) + ')';
        CustomStyle.setProp('transform', canvas, cssScale);
        CustomStyle.setProp('transformOrigin', canvas, '0% 0%');

        if ($textLayerDiv.get(0)) {
            CustomStyle.setProp('transform', $textLayerDiv.get(0), cssScale);
            CustomStyle.setProp('transformOrigin', $textLayerDiv.get(0), '0% 0%');
        }
    }
    
    context._scaleX = outputScale.sx;
    context._scaleY = outputScale.sy;
    if (outputScale.scaled) {
        context.scale(outputScale.sx, outputScale.sy);
    }     
    
    var canvasOffset = $canvas.offset();
    var $textLayerDiv = jQuery("<div />")
        .addClass("textLayer")
        .css("height", viewport.height + "px")
        .css("width", viewport.width + "px")
        .offset({
            top: canvasOffset.top,
            left: canvasOffset.left
        });
    
    jQuery("#pdfContainer").append($textLayerDiv);
    
    page.getTextContent().then(function(textContent) {
        var textLayer = new TextLayerBuilder($textLayerDiv.get(0), 0); //The second zero is an index identifying
                                                                       //the page. It is set to page.number - 1.
        textLayer.setTextContent(textContent);
        
        var renderContext = {
            canvasContext: context,
            viewport: viewport,
            textLayer: textLayer
        };
        
        page.render(renderContext);
    });
}
function setUserData(user) {
	$('#content').show();
	console.log(user);
	$('#lblMobile').text(user[2]);
	$('#lblName').text(user[3]);
}

$(document).ready(function(){
	
	$('#upload_file').show();
	$('#view').hide();
	$('#upload_data').hide();
	$('#content').hide();

	$('#link_upload_file').click(
	        function () {
	            $('#upload_file').show();
	            $('#upload_data').hide();
	            $('#view').hide();
	            $('#content').hide();
	        }
	);

	$('#link_upload_data').click(
	        function () {
	            $('#upload_file').hide();
	            $('#view').hide();
	            $('#upload_data').show();
	            $('#content').hide();
	        }
	);

	$('#link_view').click(
	        function () {
	            $('#upload_file').hide();
	            $('#upload_data').hide();
	            $('#view').show();
	            $('#content').hide();

	        }
	);

	 $('#buttonSearch').click(function () {
	    var userMb = $('#mbno').val();

	    console.log(userMb);
	   
	    $.ajax({
			  type: "POST",
			  url: "<?php echo base_url();?>index.php/user/getFile",//"http://192.168.9.137/ci/index.php/user/getFile",
			  data: {mobile: userMb},
			  success: function(data){

			  	$('#content').show();
				$pdfStr = data.trim();
			    var pdfData = base64ToUint8Array($pdfStr);
			    loadPdf(pdfData);
			  },
			  dataType: "text"
		});


	    $.ajax({
			  type: "POST",
			  url: "<?php echo base_url();?>index.php/user/getUser",//"http://192.168.9.137/ci/index.php/user/getFile",
			  data: {mobile: userMb},
			  success: function(response){
			  	console.log(response);
			  	//var user = $.parseJson(response);		
			  	var user = $.parseJSON(response);	  
				setUserData(user);	
			  },
			  dataType: "text"
		});

	 });
	
});

</script>

<?php 
$this->load->view('footer');
?>

