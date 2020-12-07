<?php

namespace App\Observers;

use App\Thumbnail;

class ThumbnailObserver
{
    /**
     * Handle the thumbnail "created" event.
     *
     * @param  \App\Thumbnail  $thumbnail
     * @return void
     */
    public function created(Thumbnail $thumbnail)
    {
        //
    }

    /**
     * Handle the thumbnail "updated" event.
     *
     * @param  \App\Thumbnail  $thumbnail
     * @return void
     */
    public function updated(Thumbnail $thumbnail)
    {
        //
    }

    /**
     * Handle the thumbnail "deleted" event.
     *
     * @param  \App\Thumbnail  $thumbnail
     * @return void
     */
    public function deleted(Thumbnail $thumbnail)
    {
        unlink($thumbnail->filename);
    }

    /**
     * Handle the thumbnail "restored" event.
     *
     * @param  \App\Thumbnail  $thumbnail
     * @return void
     */
    public function restored(Thumbnail $thumbnail)
    {
        //
    }

    /**
     * Handle the thumbnail "force deleted" event.
     *
     * @param  \App\Thumbnail  $thumbnail
     * @return void
     */
    public function forceDeleted(Thumbnail $thumbnail)
    {
        //
    }
}
