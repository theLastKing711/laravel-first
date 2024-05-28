<?php

test('return 200', function () {
    $response = $this->get('/products');

    $response->assertStatus(200);
});
