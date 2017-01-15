<div class="container">
    <div class="jumbotron col-md-8 col-md-offset-2">
        <h1>Alert</h1>
        <p>Click on the button to make an ajax call that creates an alert.</p>
        <button class="btn btn-success btn-lg" onclick="makeAlert(this)">Alert</button>
        <button class="btn btn-warning btn-lg" onclick="Amir.Alert.show('Hello world!')">Alert via JS</button>
    </div>
</div>

<?php
    $base->extra = '
        <script>
            function makeAlert(button) {

                $(button).addClass("disabled");

                $.ajax({
                    type: "post",
                    url: "/form/example/alert.php",
                    success: function () {
                        window.location.href = "/";
                    }
                });
            };
        </script>
   ';
?>
