<?php
$kasir = \App\Models\User::where('username', 'kasir')->first();
if (!$kasir) {
    \App\Models\User::create([
        'name' => 'Kasir',
        'username' => 'kasir',
        'password' => bcrypt('kasir'),
        'role' => 'kasir',
    ]);
    echo "Kasir user created successfully.\n";
} else {
    echo "Kasir user already exists.\n";
}
