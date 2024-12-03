<?php

declare(strict_types=1);

namespace Tests\Feature\Transfer;

use App\Models\User;
use App\Notifications\Admin\Transfer\ScheduleNotification;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

final class ScheduleTransferTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @throws Exception
     */
    public function test_can_schedule_transfer(): void
    {
        Notification::fake();

        Notification::assertNothingSent();

        $user = User::factory()->create();
        $user->assignRole(Role::create(['name' => 'admin']));

        $this->post(route('transfer.schedule'), [
            'name' => $this->faker->name,
            'phone' => '+79991234567',
        ]);

        Notification::assertSentTo(
            [$user], ScheduleNotification::class
        );
    }
}
