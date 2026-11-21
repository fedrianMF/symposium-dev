<?php

use App\Models\Talk;

test('guests are redirected to the login page on every talk route', function (string $method, string $routeName) {
    $talk = Talk::factory()->create();

    $response = $this->call($method, route($routeName, $talk));

    $response->assertRedirect(route('login'));

    $this->assertModelExists($talk);
})->with([
    'index' => ['GET', 'talks.index'],
    'create' => ['GET', 'talks.create'],
    'store' => ['POST', 'talks.store'],
    'show' => ['GET', 'talks.show'],
    'edit' => ['GET', 'talks.edit'],
    'update' => ['PATCH', 'talks.update'],
    'destroy' => ['DELETE', 'talks.destroy'],
]);
