<?php

use Tapp\FilamentHelp\Tests\TestCase;

uses(TestCase::class)->in('Feature', 'Unit');

// Explicitly exclude any non-existent directories that Pest might try to discover
// This prevents errors when Pest tries to discover deleted test directories
