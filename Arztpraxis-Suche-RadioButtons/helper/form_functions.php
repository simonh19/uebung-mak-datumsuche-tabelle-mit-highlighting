<?php

function showAlertWarning($message) {
    echo '<div class="alert alert-warning" role="alert">';
    echo $message;
    echo '</div>';
}

function showSuccess($message) {
    echo '<div class="alert alert-success" role="alert">';
    echo $message;
    echo '</div>';
}
