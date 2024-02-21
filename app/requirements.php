<?php

$db = $this->db;


if (!empty($f3->get('SESSION.session_id'))) {
    $f3->set('users_id', $f3->get('SESSION.users_id'));
    $f3->set('users_type', $f3->get('SESSION.users_type'));
    $f3->set('users_name', $f3->get('SESSION.users_name'));
} else {
    $f3->set('users_id', 0);
    $f3->set('users_type', 0);
    $f3->set('users_name', ' ');
}
