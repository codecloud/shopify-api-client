<?php
require 'vendor/autoload.php';

$gen = new \Codecloud\ShopifyApiClient\CodeGeneration\EndpointGenerator(
    new \Symfony\Component\Yaml\Parser()
);

$gen->generateModels(__DIR__ . '/../config/endpoints', __DIR__ . '/../src/Endpoint');