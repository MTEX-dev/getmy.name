<?php

return [
    '400' => [
        'title' => 'Bad Request',
        'description' => 'The server cannot process the request due to a client error.',
    ],
    '401' => [
        'title' => 'Unauthorized',
        'description' => 'Authentication is required and has failed or has not yet been provided.',
    ],
    '402' => [
        'title' => 'Payment Required',
        'description' => 'This is a reserved status code for future use.',
    ],
    '403' => [
        'title' => 'Forbidden',
        'description' => 'You do not have permission to access this resource.',
    ],
    '404' => [
        'title' => 'Page Not Found',
        'description' => 'Sorry, the page you are looking for could not be found.',
    ],
    '405' => [
        'title' => 'Method Not Allowed',
        'description' => 'The method specified in the Request-Line is not allowed for the resource identified by the Request-URI.',
    ],
    '406' => [
        'title' => 'Not Acceptable',
        'description' => 'The resource identified by the request is only capable of generating response entities which have content characteristics not acceptable according to the accept headers sent in the request.',
    ],
    '407' => [
        'title' => 'Proxy Authentication Required',
        'description' => 'The client must first authenticate itself with the proxy.',
    ],
    '408' => [
        'title' => 'Request Timeout',
        'description' => 'The client did not produce a request within the time that the server was prepared to wait.',
    ],
    '409' => [
        'title' => 'Conflict',
        'description' => 'The request could not be completed due to a conflict with the current state of the resource.',
    ],
    '410' => [
        'title' => 'Gone',
        'description' => 'The requested resource is no longer available at the server and no forwarding address is known.',
    ],
    '411' => [
        'title' => 'Length Required',
        'description' => 'The server refuses to accept the request without a defined Content-Length.',
    ],
    '412' => [
        'title' => 'Precondition Failed',
        'description' => 'The precondition given in one or more of the request-header fields evaluated to false when it was tested on the server.',
    ],
    '413' => [
        'title' => 'Payload Too Large',
        'description' => 'The server is refusing to process a request because the request entity is larger than the server is willing or able to process.',
    ],
    '414' => [
        'title' => 'URI Too Long',
        'description' => 'The server is refusing to service the request because the Request-URI is longer than the server is willing to interpret.',
    ],
    '415' => [
        'title' => 'Unsupported Media Type',
        'description' => 'The server is refusing to service the request because the entity of the request is in a format not supported by the requested resource for the requested method.',
    ],
    '416' => [
        'title' => 'Range Not Satisfiable',
        'description' => 'The client has asked for a portion of the file (byte serving), but the server cannot supply that portion.',
    ],
    '417' => [
        'title' => 'Expectation Failed',
        'description' => 'The server cannot meet the requirements of the Expect request-header field.',
    ],
    '418' => [
        'title' => 'I\'m a teapot',
        'description' => 'This code was defined in 1998 as one of the traditional IETF April Fools\' jokes, in RFC 2324, Hyper Text Coffee Pot Control Protocol.',
    ],
    '421' => [
        'title' => 'Misdirected Request',
        'description' => 'The request was directed at a server that is not able to produce a response.',
    ],
    '422' => [
        'title' => 'Unprocessable Entity',
        'description' => 'The server understands the content type of the request entity, and the syntax of the request entity is correct, but it was unable to process the contained instructions.',
    ],
    '423' => [
        'title' => 'Locked',
        'description' => 'The resource that is being accessed is locked.',
    ],
    '424' => [
        'title' => 'Failed Dependency',
        'description' => 'The request failed due to failure of a previous request.',
    ],
    '425' => [
        'title' => 'Too Early',
        'description' => 'Indicates that the server is unwilling to risk processing a request that might be replayed.',
    ],
    '426' => [
        'title' => 'Upgrade Required',
        'description' => 'The client should switch to a different protocol such as TLS/1.0, given in the Upgrade header field.',
    ],
    '428' => [
        'title' => 'Precondition Required',
        'description' => 'The server requires the request to be conditional.',
    ],
    '429' => [
        'title' => 'Too Many Requests',
        'description' => 'The user has sent too many requests in a given amount of time ("rate limiting").',
    ],
    '431' => [
        'title' => 'Request Header Fields Too Large',
        'description' => 'The server is unwilling to process the request because its header fields are too large.',
    ],
    '451' => [
        'title' => 'Unavailable For Legal Reasons',
        'description' => 'A server operator has received a legal demand to deny access to a resource or to a set of resources that includes the requested resource.',
    ],
    '500' => [
        'title' => 'Server Error',
        'description' => 'Whoops, something went wrong on our servers.',
    ],
    '501' => [
        'title' => 'Not Implemented',
        'description' => 'The server does not support the functionality required to fulfill the request.',
    ],
    '502' => [
        'title' => 'Bad Gateway',
        'description' => 'The server, while acting as a gateway or proxy, received an invalid response from an inbound server it accessed while attempting to fulfill the request.',
    ],
    '503' => [
        'title' => 'Service Unavailable',
        'description' => 'The server is currently unable to handle the request due to a temporary overload or scheduled maintenance, which will likely be alleviated after some delay.',
    ],
    '504' => [
        'title' => 'Gateway Timeout',
        'description' => 'The server, while acting as a gateway or proxy, did not receive a timely response from an upstream server it needed to access in order to complete the request.',
    ],
    '505' => [
        'title' => 'HTTP Version Not Supported',
        'description' => 'The server does not support the HTTP protocol version used in the request.',
    ],
    '506' => [
        'title' => 'Variant Also Negotiates',
        'description' => 'Transparent content negotiation for the request results in a circular reference.',
    ],
    '507' => [
        'title' => 'Insufficient Storage',
        'description' => 'The server is unable to store the representation needed to complete the request.',
    ],
    '508' => [
        'title' => 'Loop Detected',
        'description' => 'The server detected an infinite loop while processing the request (sent in WebDAV).',
    ],
    '510' => [
        'title' => 'Not Extended',
        'description' => 'Further extensions to the request are required for the server to fulfill it.',
    ],
    '511' => [
        'title' => 'Network Authentication Required',
        'description' => 'The client needs to authenticate to gain network access.',
    ],
    'general' => [
        'title' => 'An Error Occurred',
        'description' => 'An unexpected error occurred. Please try again later.',
    ],
    'NotFoundHttpException' => [
        'title' => 'Page Not Found',
        'description' => 'The requested resource was not found.',
    ],
    'MethodNotAllowedHttpException' => [
        'title' => 'Method Not Allowed',
        'description' => 'The specified HTTP method is not allowed for this route.',
    ],
    'go_home' => 'Go Home',
];