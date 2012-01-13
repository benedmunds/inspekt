<?php

use \FUnit\fu;

include __DIR__ . '/lib/FUnit.php';

fu::test('poop!', function() {
	fu::ok(1, '1 is okay, bro');
});

fu::run();