<?php

use App\Models\Talk;
use App\Models\User;

test('it shows basic talk details on the talk show page', function () {
    $talk = Talk::factory()->create();

    $response = $this->actingAs($talk->author)->get(route('talks.show', $talk));

    $response
        ->assertOk()
        ->assertSee($talk->title)
        ->assertSee($talk->abstract);
});

test('users cannot see the show page of other users talks', function () {
    $talk = Talk::factory()->create();
    $otherUser = User::factory()->create();

    $response = $this->actingAs($otherUser)->get(route('talks.show', $talk));

    $response->assertForbidden();
});
