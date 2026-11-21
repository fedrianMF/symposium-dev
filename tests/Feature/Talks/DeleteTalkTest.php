<?php

use App\Models\Talk;
use App\Models\User;

test('a user can delete their talk', function () {
    $talk = Talk::factory()->create();

    $response = $this->actingAs($talk->author)->delete(route('talks.destroy', $talk));

    $response->assertRedirect(route('talks.index'));

    $this->assertModelMissing($talk);
});

test('a user cannot delete another user talk', function () {
    $talk = Talk::factory()->create();
    $otherUser = User::factory()->create();

    $response = $this->actingAs($otherUser)->delete(route('talks.destroy', $talk));

    $response->assertForbidden();

    $this->assertModelExists($talk);
});
