<?php

use Pest\Arch\Expectation;

it('has no dependencies on vendor packages', function () {
    Expectation::expect('Tapp\\FilamentHelp\\')
        ->toOnlyUse([
            'Illuminate\\',
            'Filament\\',
            'Spatie\\',
        ]);
});
