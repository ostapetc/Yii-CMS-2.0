<?
/**
 * @author sergey.yusupov
 * @date   : 14.02.12 10:16
 */
abstract class JsonRpcClient {

    protected $url;

    public function __construct($url = nusll)
    {
        $this->url = $url;
    }

    public function __call($name, $arguments)
    {
        $id = md5(microtime());
        $request = array(
            'jsonrpc' => '2.0',
            'method'  => $name,
            'params'  => $arguments,
            'id'      => $id
        );

        $jsonRequest = json_encode($request);

        $ctx = stream_context_create(array(
            'http' => array(
                'method'  => 'POST',
                'header'  => "Content-Type: application/json-rpc\r\n",
                'content' => $jsonRequest
            )
        ));

        $jsonResponse = '';
        try {
            $fp = fopen($this->url, 'r', false, $ctx);
            while ($line = fgets($fp))
            {
                $jsonResponse .= trim($line) . "\n";
            }
            fclose($fp);
        } catch (Exception $e) {
            if (isset($fp) && $fp !== false) {
                fclose($fp);
                throw $e;
            }
        }

        if ($jsonResponse === '')
            throw new JsonRpcException('fopen failed', JsonRpcException::INTERNAL_ERROR);

        $response = json_decode($jsonResponse);

        if ($response === null)
            throw new JsonRpcException('JSON cannot be decoded', JsonRpcException::INTERNAL_ERROR);

        if ($response->id != $id)
            throw new JsonRpcException('Mismatched JSON-RPC IDs', JsonRpcException::INTERNAL_ERROR);

        if (property_exists($response, 'error'))
            throw new JsonRpcException($response->error->message, $response->error->code);
        else if (property_exists($response, 'result'))
            return $response->result;
        else
            throw new JsonRpcException('Invalid JSON-RPC response', JsonRpcException::INTERNAL_ERROR);
    }
}

class MebelramaJsonRpcClient extends JsonRpcClient {

    const MEBELRAMA_JSON_API_URL = 'http://mebelrama.ru/jsonRpcApi';

    public function __construct($url = null)
    {
        if ($url === null) {
            $this->url = self::MEBELRAMA_JSON_API_URL;
        }
    }
}

class JsonRpcException extends Exception
{
    const PARSE_ERROR = -32700;
    const INVALID_REQUEST = -32600;
    const METHOD_NOT_FOUND = -32601;
    const INVALID_PARAMS = -32602;
    const INTERNAL_ERROR = -32603;

    private $data = null;

    public function __construct($message, $code, $data = null)
    {
        $this->data = $data;
        parent::__construct($message, $code);
    }

    public function getErrorAsArray() {
        $result = array(
            'code' => $this->getCode(),
            'message' => $this->getMessage(),
        );
        if ($this->data !== null) $result['data'] = $this->data;
        return $result;
    }
}

