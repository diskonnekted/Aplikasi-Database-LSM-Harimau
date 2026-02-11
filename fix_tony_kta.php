<?php

use App\Models\Member;

$m = Member::where('full_name', 'like', '%Tony%')->first();
if ($m && !$m->kta_number) {
    $m->update(['kta_number' => Member::generateKtaNumber($m)]);
    echo "KTA Generated: " . $m->kta_number . "\n";
} else {
    echo "KTA already exists or member not found.\n";
}
