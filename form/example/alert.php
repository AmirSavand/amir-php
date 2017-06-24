<?php

// Load requirements
require "../../include/requirements.php";

// Set alert
Amir::set_alert("<b>Wow!</b> Hello world. Click on me to dismiss!", "success");

// Success
http_response_code(201);
