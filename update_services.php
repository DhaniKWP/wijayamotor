<?php

use App\Models\Service;

$km_list = [
    '1.000' => 'Service perdana',
    '10.000' => 'Service reguler',
    '20.000' => 'Service reguler',
    '30.000' => 'Service reguler',
    '40.000' => 'Service besar',
    '50.000' => 'Service reguler',
    '60.000' => 'Service reguler',
    '70.000' => 'Service reguler',
    '80.000' => 'Service besar',
    '90.000' => 'Service reguler',
    '100.000' => 'Service reguler',
];

foreach ($km_list as $km => $desc) {
    $name = "Servis Berkala $km KM";
    $service = Service::where('name', $name)->first();
    
    if ($service) {
        $service->update(['price_estimate' => 100000, 'description' => $desc]);
        echo "Updated: $name\n";
    } else {
        Service::create([
            'name' => $name,
            'description' => $desc,
            'price_estimate' => 100000,
        ]);
        echo "Created: $name\n";
    }
}
