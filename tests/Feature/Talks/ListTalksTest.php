<?php

use App\Models\Talk;
use App\Models\User;

test('it lists the user talks on the talks index page', function () {
    $user = User::factory()->has(Talk::factory()->count(2))->create();
    $otherUsersTalk = Talk::factory()->create();

    $response = $this->actingAs($user)->get(route('talks.index'));

    $response
        ->assertOk()
        ->assertSee($user->talks->first()->title)
        ->assertSee($user->talks->last()->title)
        ->assertDontSee($otherUsersTalk->title);
});
