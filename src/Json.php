<?php

namespace Tc\Json;

/**
 * Json
 *
 * @author Carl Craig <carlcraig.threeceestudios@gmail.com>
 */
class Json
{
    /**
     * @param $input
     * @param int $options
     * @param int $depth
     * @return string
     * @throws JsonException
     */
    public static function encode($input, $options = 0, $depth = 512)
    {
        $encoded = json_encode($input, $options, $depth);
        if (function_exists('json_last_error') && $error = json_last_error()) {
            throw new JsonException(static::transformJsonError($error));
        }

        return $encoded;
    }

    /**
     * @param $input
     * @param int $options
     * @param int $depth
     * @return null|string
     */
    public static function encodeWithoutException($input, $options = 0, $depth = 512)
    {
        try {
            $encoded = static::encode($input, $options, $depth);
        } catch (JsonException $e) {
            $encoded = null;
        }

        return $encoded;
    }

    /**
     * @param $jsonString
     * @param bool $assoc
     * @param int $depth
     * @param int $options
     * @return mixed
     * @throws JsonException
     */
    public static function decode(
        $jsonString,
        $assoc = false,
        $depth = 512,
        $options = 0
    ) {
        $decoded = json_decode($jsonString, $assoc, $depth, $options);
        if (function_exists('json_last_error') && $error = json_last_error()) {
            throw new JsonException(self::transformJsonError($error));
        }

        return $decoded;
    }

    /**
     * @param $jsonString
     * @param bool $assoc
     * @param int $depth
     * @param int $options
     * @return mixed|null
     */
    public static function decodeWithoutException(
        $jsonString,
        $assoc = false,
        $depth = 512,
        $options = 0
    ) {
        try {
            $decoded = static::decode($jsonString, $assoc, $depth, $options);
        } catch (JsonException $e) {
            $decoded = null;
        }

        return $decoded;
    }

    /**
     * @param $error
     * @return string
     */
    private static function transformJsonError($error)
    {
        switch ($error) {
            case JSON_ERROR_STATE_MISMATCH:
                return 'Underflow or the modes mismatch.';
            case JSON_ERROR_CTRL_CHAR:
                return 'Control character error, possibly incorrectly encoded.';
            case JSON_ERROR_UTF8:
                return 'Malformed UTF-8 characters, possibly incorrectly encoded.';
            case JSON_ERROR_RECURSION:
                return 'The object or array passed to json_encode include recursive references and cannot be encoded.';
            case JSON_ERROR_INF_OR_NAN:
                return 'The value passed to json_encode includes either NAN or INF.';
            case JSON_ERROR_UNSUPPORTED_TYPE:
                return 'A value of an unsupported type was given to json_encode';
            case JSON_ERROR_DEPTH:
                return 'The maximum stack depth has been exceeded';
            case JSON_ERROR_SYNTAX:
                return 'Syntax error.';
            default:
                return 'Unknown Json Error. No. '.((int)$error);
        }
    }
}
