<?php

namespace Safe;

use Safe\Exceptions\ArrayException;

/**
 * Applies the user-defined callback function to each
 * element of the array. This function will recurse
 * into deeper arrays.
 *
 * @param array $array The input array.
 * @param callable $callback Typically, callback takes on two parameters.
 * The array parameter's value being the first, and
 * the key/index second.
 *
 * If callback needs to be working with the
 * actual values of the array, specify the first parameter of
 * callback as a
 * reference. Then,
 * any changes made to those elements will be made in the
 * original array itself.
 * @param mixed $arg If the optional arg parameter is supplied,
 * it will be passed as the third parameter to the
 * callback.
 * @throws ArrayException
 *
 */
function array_walk_recursive(array &$array, callable $callback,  $arg = null): void
{
    error_clear_last();
    if ($arg !== null) {
        $result = \array_walk_recursive($array, $callback, $arg);
    }else {
        $result = \array_walk_recursive($array, $callback);
    }
    if ($result === false) {
        throw ArrayException::createFromPhpError();
    }
}


/**
 * This function shuffles (randomizes the order of the elements in) an array.
 * It uses a pseudo random number generator that is not suitable for
 * cryptographic purposes.
 *
 * @param array $array The array.
 * @throws ArrayException
 *
 */
function shuffle(array &$array): void
{
    error_clear_last();
    $result = \shuffle($array);
    if ($result === false) {
        throw ArrayException::createFromPhpError();
    }
}

