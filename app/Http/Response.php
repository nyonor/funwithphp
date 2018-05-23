<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/5/18
 * Time: 12:59 PM
 */

namespace App\Http;


class Response extends AbstractMessage implements ResponseInterface
{
    protected $statusCode   = 0;
    protected $reasonPhrase = '';

    /**
     * Gets the response status code.
     *
     * The status code is a 3-digit integer result code of the server's attempt
     * to understand and satisfy the request.
     *
     * @return int Status code.
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Return an instance with the specified status code and, optionally, reason phrase.
     *
     * If no reason phrase is specified, implementations MAY choose to default
     * to the RFC 7231 or IANA recommended reason phrase for the response's
     * status code.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * updated status and reason phrase.
     *
     * @see http://tools.ietf.org/html/rfc7231#section-6
     * @see http://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml
     * @param int $code The 3-digit integer result code to set.
     * @param string $reasonPhrase The reason phrase to use with the
     *     provided status code; if none is provided, implementations MAY
     *     use the defaults as suggested in the HTTP specification.
     * @return static
     * @throws \InvalidArgumentException For invalid status code arguments.
     */
    public function withStatus($code, $reasonPhrase = '')
    {
        $cloned = clone $this;
        $cloned->statusCode = $code;
        $cloned->reasonPhrase = $reasonPhrase;
        return $cloned;
    }

    /**
     * Gets the response reason phrase associated with the status code.
     *
     * Because a reason phrase is not a required element in a response
     * status line, the reason phrase value MAY be empty. Implementations MAY
     * choose to return the default RFC 7231 recommended reason phrase (or those
     * listed in the IANA HTTP Status Code Registry) for the response's
     * status code.
     *
     * @see http://tools.ietf.org/html/rfc7231#section-6
     * @see http://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml
     * @return string Reason phrase; must return an empty string if none present.
     */
    public function getReasonPhrase()
    {
        $reason_phrase_to_return = '';

        if (empty($this->reasonPhrase)) {
            switch($this->statusCode):
                case (200):
                    $reason_phrase_to_return = 'OK';
                    break;
                case (500):
                    $reason_phrase_to_return = 'Internal Server Error';
                    break;
                case (301):
                    $reason_phrase_to_return = 'Moved Permanently';
                    break;
                case (303):
                    $reason_phrase_to_return = 'See Other';
                    break;
                case (307):
                    $reason_phrase_to_return = 'Temporary Redirect';
                    break;
            endswitch;
        } else {
            $reason_phrase_to_return = $this->reasonPhrase;
        }

        return $reason_phrase_to_return;
    }
}