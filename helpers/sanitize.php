<?php
function sanitize_email($email)
{
    return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
}
