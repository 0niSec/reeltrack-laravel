<?php

namespace App\Observers;

use App\Events\WatchlistEvent;
use App\Models\Activity;
use App\Models\Watchlist;

class WatchlistObserver
{
    public function created(Watchlist $watchlist): void
    {
        WatchlistEvent::dispatch(
            $watchlist->user,
            $watchlist->watchlistable,
            true
        );
    }

    public function deleted(Watchlist $watchlist): void
    {
        Activity::query()
            ->where('user_id', $watchlist->user_id)
            ->where('subject_type', get_class($watchlist->watchlistable))
            ->where('subject_id', $watchlist->watchlistable_id)
            ->where('event_type', 'watchlist')
            ->delete();

        WatchlistEvent::dispatch(
            $watchlist->user,
            $watchlist->watchlistable,
            false
        );
    }
}
