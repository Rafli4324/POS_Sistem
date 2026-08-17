<?php
Illuminate\Support\Facades\DB::statement("ALTER TABLE users MODIFY password VARCHAR(255) NOT NULL;");
echo "Password column altered.\n";

$users = Illuminate\Support\Facades\DB::table('users')->get();
foreach($users as $user) {
    Illuminate\Support\Facades\DB::table('users')
        ->where('id', $user->id)
        ->update(['password' => bcrypt($user->username)]);
    echo "Updated password for user: " . $user->username . "\n";
}
echo "Done fixing all passwords!\n";
