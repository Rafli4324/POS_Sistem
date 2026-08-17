<?php
$users = Illuminate\Support\Facades\DB::table('users')->get();
foreach($users as $user) {
    Illuminate\Support\Facades\DB::table('users')
        ->where('id', $user->id)
        ->update(['password' => bcrypt($user->username)]);
    echo "Updated password for user: " . $user->username . " (set to '" . $user->username . "')\n";
}
echo "Done fixing all passwords!\n";
