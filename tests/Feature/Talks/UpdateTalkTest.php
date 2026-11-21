<?php

use App\Enums\TalkType;
use App\Models\Talk;
use App\Models\User;

test('the edit page is prefilled with the talk data', function () {
    $talk = Talk::factory()->create([
        'title' => 'Original title',
        'type' => TalkType::Keynote,
    ]);

    $response = $this->actingAs($talk->author)->get(route('talks.edit', $talk));

    $response
        ->assertOk()
        ->assertSee('value="Original title"', false)
        ->assertSee('<option value="keynote" selected', false);
});

test('a user can update their talk', function () {
    $talk = Talk::factory()->create();

    $response = $this->actingAs($talk->author)->patch(route('talks.update', $talk), [
        'title' => 'New title',
        'type' => TalkType::Lightning->value,
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('talks.show', $talk));

    expect($talk->refresh()->title)->toBe('New title');
});

test('a user cannot open the edit page of another user talk', function () {
    $talk = Talk::factory()->create();
    $otherUser = User::factory()->create();

    $response = $this->actingAs($otherUser)->get(route('talks.edit', $talk));

    $response->assertForbidden();
});

test('a user cannot update another user talk', function () {
    $talk = Talk::factory()->create();
    $originalTitle = $talk->title;
    $otherUser = User::factory()->create();

    $response = $this->actingAs($otherUser)->patch(route('talks.update', $talk), [
        'title' => 'New title',
        'type' => TalkType::Lightning->value,
    ]);

    $response->assertForbidden();

    expect($talk->refresh()->title)->toBe($originalTitle);
});

test('a talk cannot be updated with an empty title', function () {
    $talk = Talk::factory()->create();
    $originalTitle = $talk->title;

    $response = $this->actingAs($talk->author)->patch(route('talks.update', $talk), [
        'title' => '',
        'type' => TalkType::Lightning->value,
    ]);

    $response->assertSessionHasErrors('title');

    expect($talk->refresh()->title)->toBe($originalTitle);
});
