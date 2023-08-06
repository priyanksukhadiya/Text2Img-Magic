<!DOCTYPE html>
<html>

<head>
    <title>Text to Image Generator</title>
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <div id="page-loader" class="page-loader" style="display:none">
        <div class="spinner"></div>
        <div class="txt">Your Image is Generating<br> Please Wait...</div>
    </div>

    <div class="main-container">
        <div class="main-box">
            <h1 class="title">Text to Image Generator</h1>
            <form id="text-form">
                <input type="text" name="prompt" id="text-input" placeholder="Enter your text">
                <button type="submit">Generate Image</button>
            </form>
        </div>

        <!-- Generated Image Show Here -->
        <p id="your-generaed-image" style="display:none;">-- : Your Generated Image :--</p>
        <div id="generated-image" class="ccontainer"></div>

    </div>
    <div class="container-fluid">
        <!-- Footer Section -->
        <footer class="footer-section">
            <div class="copyright-area">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 text-center text-lg-left">
                            <div class="copyright-text">
                                <p>Copyright &copy; 2023, All Right Reserved <a
                                        href="https://github.com/priyanksukhadiya">Priyank Sukhadiya</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
<script>
    $(document).ready(function() {
        // Handle form submission
        $(document).ajaxStart(function() {
            $('#page-loader').show();
            $('#text-form').hide();
        });

        // Hide the loader and show the form when the AJAX request completes
        $(document).ajaxStop(function() {
            $('#page-loader').hide();
            $('#text-form').show();
            $('#your-generaed-image').show();
        });


        $('#text-form').submit(function(event) {
            event.preventDefault();

            // Get the input value
            var text = $('#text-input').val();

            // Create an object to hold the data
            var formData = {
                prompt: text
            };

            // Send the AJAX request
            $.ajax({
                type: 'POST',
                url: 'eden_api.php',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        var imageURL = response.imageURL;
                        displayImage(imageURL);
                    } else {
                        console.log(response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error:', error);
                }
            });
        });

        function displayImage(imageURL) {
            var imageContainer = $('#generated-image');
            imageContainer.html('<img src="' + imageURL + '" alt="Generated Image">');
            imageContainer.css('display', 'block');

        }
    });
</script>

</html>
