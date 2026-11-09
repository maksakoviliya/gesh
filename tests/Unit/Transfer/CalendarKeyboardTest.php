<?php

declare(strict_types=1);

namespace Tests\Unit\Transfer;

use App\Services\Transfer\TelegramMessageBuilder;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\TestCase;

final class CalendarKeyboardTest extends TestCase
{
    protected function tearDown(): void
    {
        Carbon::setTestNow();
    }

    /** @return array<int, array<int, array{text: string, callback_data: string}>> */
    private function rows(Carbon $month): array
    {
        return json_decode(json_encode(TelegramMessageBuilder::calendarKeyboard($month)), true)['inline_keyboard'];
    }

    public function test_today_is_taken_in_sheregesh_timezone_and_past_days_are_disabled(): void
    {
        // 18:00 UTC on Nov 9 is already 01:00 on Nov 10 in Sheregesh
        Carbon::setTestNow(Carbon::parse('2026-11-09 18:00:00', 'UTC'));
        $rows = $this->rows(TelegramMessageBuilder::today());

        $this->assertSame('Ноябрь 2026', $rows[0][1]['text']);
        $this->assertSame('noop', $rows[0][0]['callback_data'], 'no way back from the current month');
        $this->assertSame('cal:2026-12', $rows[0][2]['callback_data']);

        // Nov 1, 2026 is a Sunday: six blanks, then the day in the last column
        $firstWeek = $rows[2];
        $this->assertCount(7, $firstWeek);
        $this->assertSame('·', $firstWeek[6]['text']);

        $days = array_merge(...array_slice($rows, 2));
        $this->assertCount(7 * (count($rows) - 2), $days, 'every week row is full');
        $clickable = array_values(array_filter($days, fn ($b) => str_starts_with($b['callback_data'], 'date:')));
        $this->assertSame('date:2026-11-10', $clickable[0]['callback_data']);
        $this->assertSame('date:2026-11-30', end($clickable)['callback_data']);
    }

    public function test_time_is_picked_hour_then_quarter(): void
    {
        $hours = json_decode(json_encode(TelegramMessageBuilder::hoursKeyboard()), true)['inline_keyboard'];
        $this->assertCount(24, array_merge(...$hours));
        $this->assertSame(['text' => '07:00', 'callback_data' => 'hour:7'], $hours[1][3]);

        $minutes = json_decode(json_encode(TelegramMessageBuilder::minutesKeyboard(7)), true)['inline_keyboard'];
        $this->assertSame(['time:07:00', 'time:07:15', 'time:07:30', 'time:07:45'], array_column($minutes[0], 'callback_data'));
        $this->assertSame('hours', $minutes[1][0]['callback_data']);
    }

    public function test_passengers_one_to_eight(): void
    {
        $rows = json_decode(json_encode(TelegramMessageBuilder::passengersKeyboard()), true)['inline_keyboard'];
        $this->assertSame(array_map(fn ($n) => "pax:$n", range(1, 8)), array_column(array_merge(...$rows), 'callback_data'));
    }

    public function test_past_month_is_clamped_and_next_month_can_go_back(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-11-09 10:00:00', 'UTC'));

        $this->assertSame('Ноябрь 2026', $this->rows(Carbon::parse('2026-10-01'))[0][1]['text']);

        $december = $this->rows(Carbon::parse('2026-12-01'));
        $this->assertSame('cal:2026-11', $december[0][0]['callback_data']);
        $this->assertSame('date:2026-12-01', $december[2][1]['callback_data'], 'Dec 1, 2026 is a Tuesday');
    }
}
