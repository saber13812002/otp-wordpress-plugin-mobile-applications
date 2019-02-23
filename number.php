<?php

function right10($recipient_no)
{
    $len = strlen($recipient_no);

    if ($len >= 10) {
        $recipient_no = substr($recipient_no, $len - 10, $len);
    }
    return $recipient_no;
}