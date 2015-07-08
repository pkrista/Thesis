<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8"/>

		<!-- Google web fonts -->
		<link href="http://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700" rel='stylesheet' />

		<!-- The main CSS file -->
		<link href="assets/css/style.css" rel="stylesheet" />
                <link rel="stylesheet" href="css/foundation.css" />
	</head>

	<body>

            <form class="panel" id="upload" method="post" action="form/upload.php" enctype="multipart/form-data">
			<div class="callout panel" id="drop"> <!--action="form/upload.php"-->
				Drop Here

				<a class="tiny button" style="margin-top:12px;">Browse</a>
				<input type="file" name="upl" multiple />
			</div>

			<ul>
				<!-- The file uploads will be shown here -->
			</ul>

		</form>

        
		<!-- JavaScript Includes -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src="assets/js/jquery.knob.js"></script>

		<!-- jQuery File Upload Dependencies -->
		<script src="assets/js/jquery.ui.widget.js"></script>
		<script src="assets/js/jquery.iframe-transport.js"></script>
		<script src="assets/js/jquery.fileupload.js"></script>
		
		<!-- Our main JS file -->
		<script src="assets/js/script.js"></script>

	</body>
</html>