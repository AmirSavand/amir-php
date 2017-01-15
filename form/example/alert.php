<?php

// Load requirements
require "../../include/requirements.php";

// Set alert
Amir::setAlert("<b>Wow!</b> Hello world. Click on me to dismiss!", "success");

// Success
http_response_code(201);
