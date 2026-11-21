<?php

use App\Enums\TalkType;
use App\Models\Talk;
use App\Models\User;

test('the create talk page loads', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('talks.create'))
        ->assertOk();
});

test('a user can create a talk', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('talks.store'), [
        'title' => 'My new talk',
        'type' => TalkType::Keynote->value,
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('talks.index'));

    $this->assertDatabaseHas('talks', [
        'title' => 'My new talk',
        'type' => TalkType::Keynote->value,
        'user_id' => $user->id,
    ]);
});

test('a talk is always created for the logged in user even if another user_id is sent', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    $this->actingAs($user)->post(route('talks.store'), [
        'title' => 'My new talk',
        'type' => TalkType::Keynote->value,
        'user_id' => $otherUser->id,
    ]);

    expect(Talk::sole()->user_id)->toBe($user->id);
});

test('a talk cannot be created without a title and a type', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->from(route('talks.create'))
        ->post(route('talks.store'), []);

    $response
        ->assertSessionHasErrors(['title', 'type'])
        ->assertRedirect(route('talks.create'));

    expect(Talk::count())->toBe(0);
});

test('a talk with an invalid type is rejected', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('talks.store'), [
        'title' => 'My new talk',
        'type' => 'workshop',
    ]);

    $response->assertSessionHasErrors('type');

    expect(Talk::count())->toBe(0);
});
