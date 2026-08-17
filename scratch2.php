<?php
$users = Illuminate\Support\Facades\DB::table('users')->get();
foreach($users as $user) {
    echo "ID: " . $user->id . ", Username: " . $user->username . ", Password: " . $user->password . "\n";
}
