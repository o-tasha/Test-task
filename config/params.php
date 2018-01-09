<?php

return [
    'adminEmail' => 'admin@example.com',
    'orderEmailTo' => (date("G") >= 8 && date("G") < 18)?'working@example.com':'non-working@example.com',
];
