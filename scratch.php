<?php
$users = Illuminate\Support\Facades\DB::table('users')->get();
foreach($users as $user) {
    if (!str_starts_with($user->password, '$2y$')) {
        Illuminate\Support\Facades\DB::table('users')
            ->where('id', $user->id)
            ->update(['password' => bcrypt($user->password)]);
        echo "Updated password for: " . $user->username . "\n";
    }
}
echo "Done checking all users.\n";
