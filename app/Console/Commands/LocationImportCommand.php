<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Orchestra\Parser\Xml\Facade as XmlParser;
use App\Models\Location;

class LocationImportCommand extends Command
{
    protected $signature = 'location:import';
    protected $description = 'Import location data from XML file';

    public function handle()
    {
        // Шлях до XML-файлу


        $xml = XmlParser::load('public/26-ex_xml_atu.xml');

        $locations = $xml->parse([
            'locations' => ['uses' => 'RECORD[OBL_NAME,REGION_NAME,CITY_NAME,CITY_REGION_NAME,STREET_NAME]'],
        ]);

        foreach ($locations['locations'] as $locationData) {


            Location::create([
                'obl_name' => $locationData['OBL_NAME'],
                'region_name' => $locationData['REGION_NAME'] ?? null,
                'city_region_name' => $locationData['CITY_REGION_NAME'] ?? null,
                'city_name' => $locationData['CITY_NAME'] ?? null,
                'street_name' => $locationData['STREET_NAME'] ?? null,
            ]);
        }

        $this->info('Location data imported successfully.');
    }
}
