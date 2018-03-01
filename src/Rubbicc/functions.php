<?php

/*
 * Add helper function
 */

if (! function_exists('rubbicc')) {

    /**
     * @param string $to
     * @param string $message
     * @param array $extra_params
     * @return mixed
     */
    function rubbicc($to = null, $message = null)
    {
        $rubbicc = app('rubbicc');
        if (! (is_null($to) || is_null($message))) {
            return $rubbicc->sendMessage($to, $message);
        }
        return $rubbicc;
    }
}