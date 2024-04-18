<?php

// app/helpers.php

if (!function_exists('formatAmount')) {
    function formatAmount($amount)
    {
        return number_format($amount, 2);
    }
}

?>
